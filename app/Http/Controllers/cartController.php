<?php

namespace App\Http\Controllers;

use App\cart;
use Illuminate\Http\Request;
use App\doctors\doctorTreatments;
use App\manager\connectionManager;
use Illuminate\Support\Facades\DB;

class cartController extends Controller
{
    /**
     * Restricts only authenticated users
     *
     * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['get_lab_and_pathology_codes']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = $request->user();
        return response()->json(
            $auth->cart()
            ->latest('created_at')
            ->get()
        );
    }

    public function getCount(Request $request)
    {
        $user = $request->user();
        return optional($user->cart)->count();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCart($request);

        $auth = $request->user();

        [$date_of_service, $time_of_service] = $this->formatted_date($request->date_of_service);

        $treatments = new doctorTreatments;
        $treatment = $treatments->findById($request->treatment_id);

        if($treatment == null) return abort(422, "Treatment not found");

        $hidden_charges = $this->get_hidden_charges($request->cpt);

        $average_cost = $treatment->average_cost;
        $saved_cost = $treatment->average_saved;
        $purchase_cost = $treatment->purchase_cost;
        $negotiated_cost = $request->negotiatedCost;

        if($negotiated_cost !== null && $negotiated_cost !== '' && $negotiated_cost !== 0)
        {
            $saved_cost = $treatment->average_saved + ($average_cost - $negotiated_cost);
        }

        $anesthesia = $this->get_anesthesia_fee($request->cpt);
       
        $anesthesia_fee = 0;
        $anesthesia_code = null;
        $units = 0;

        if(!is_null($anesthesia)) 
        {
            $anesthesia_fee = (double) optional($anesthesia)->fee;
            $anesthesia_code = optional($anesthesia)->anesthesia_code;
            $units = (double) optional($anesthesia)->units;
        }

        [$pathology_codes, $radiology_codes] = $this->get_radiology_and_pathology_codes($request->cpt);

        $charges_details = $this->get_charges_details($anesthesia_fee, $units, $anesthesia_code, $anesthesia->description, $pathology_codes, $radiology_codes, $hidden_charges, $request->cpt, $average_cost);

        $hidden_fee = (double) !is_null($hidden_charges) ? $hidden_charges->fee : 0;

        $category = $this->get_item_category($request->cpt);

 
        $cart = $auth->cart()->create([
            'doctor_id'            => $request->doctor,
            'cpt'                  => $request->cpt,
            'date_of_appointment'  => $date_of_service,
            'time_of_appointment'  => $time_of_service,
            'average_cost'         => $average_cost,
            'purchase_cost'        => $purchase_cost,
            'saved_cost'           => $saved_cost,
            'negotiated_cost'      => $negotiated_cost,
            'anesthesia_fee'       => $anesthesia_fee,
            'facility_expenses'    => cart::FACILITY_EXPENSES,
            'hidden_charges'       => $hidden_fee,
            'charges_details'      => $charges_details,
            'date_of_booking'      => now(),
            'category'             => $category 
        ]);

        return $cart ? response()->json($cart, 200) : abort(422);
       
    }

    public function get_item_category($code) 
    {
        $master_db = app(connectionManager::class)->getConnection('master');
        $cpts_crosswalk = DB::connection($master_db)->table('rules_categories_cpts_crosswalk');
        return optional($cpts_crosswalk->where('cpt', $code)->first())->name;        
    }

    public function get_charges_details($anesthesia_fee, $units, $anesthesia_code, $description, $pathology_codes, $radiology_codes, $hidden_charges, $primary_code, $average_cost)
    {

        $charges_details = [];

        $charges_details['anesthesia']= [
            'code'        => $anesthesia_code,
            'units'       => $units,
            'fee'         => $anesthesia_fee,
            'description' => $description
        ];

        $charges_details['pathology']= [
            'code'        => $pathology_codes->includes,
            'fee'         => $pathology_codes->fee,
            'description' => $pathology_codes->description              
        ];

        $charges_details['radiology']= [
            'code'        => $radiology_codes->includes,
            'fee'         => $radiology_codes->fee,
            'description' => $radiology_codes->description              
        ];

        if(!is_null($hidden_charges))
        {
            $charges_details['hidden_charges']= [
                'code'        => $hidden_charges->code,
                'fee'         => $hidden_charges->fee,
                'description' => $hidden_charges->description              
            ];
        }

        $cosurg_details = $this->get_corsurgeon_codes($primary_code);
        
        if(!is_null($cosurg_details))
        {
            $charges_details['cosurg_details']= [
                'code'           => $cosurg_details->code,
                'fee'            => $this->get_cosurg_fee($average_cost, $cosurg_details->cosurgeon_code),
                'description'    => $cosurg_details->description,
                'global_days'    => $cosurg_details->global_days,
                'cosurgeon_code' => $cosurg_details->cosurgeon_code,
                'note'           => $this->get_cosurg_note($cosurg_details->global_days),
                'category'       => $this->get_cosurg_category($cosurg_details->global_days)             
            ];
        }

        $charges_details['added_charges_list']= [
            'anesthesia'        => true,
            'radiology'         => true,
            'pathology'         => true,
            'cosurg_details'    => true,
            'hidden_charges'    => true,
            'facility_expenses' => true,
            'evob_charges'      => true
        ]; 

        return $charges_details;
    }

    public function get_cosurg_category($global_days) 
    {
        if($global_days === '010') 
        {
            return 'Minor';
        }
        else if($global_days === '090') 
        {
            return 'Major';
        }
        else 
        {
            return null;    
        }
    }

    public function get_cosurg_note($global_days) 
    {
        if($global_days === '010') 
        {
            return 'This is a minor surgery and you can have 10 days Post Op visits without additional cost.';
        }
        else if($global_days === '090') 
        {
            return 'This is a major surgery and you can have 90 days Post Op visits without additional cost.';
        }
        else 
        {
            return null;    
        }
    }

    public function get_cosurg_fee($cost, $cosurg_code) 
    {
        if($cosurg_code === '1') 
        {
            return ($cost * 15)/100;
        }
        else if($cosurg_code === '2') 
        {
            return ($cost * 15)/100;
        }
        else 
        {
            return 0;
        }
    }

    public function get_corsurgeon_codes($primary_code) 
    {
        $master_db = app(connectionManager::class)->getConnection('master');
        $cosurg_codes = DB::connection($master_db)->table('cosurgeon_codes');
        $cosurg_codes = $cosurg_codes
        ->select("code", "modifier", "description", "global_days", "cosurgeon_code")
        ->where('code', $primary_code)
        ->limit(1)
        ->first();
        return $cosurg_codes;
    }


    public function get_radiology_and_pathology_codes($cpt) 
    {
        $master_db = app(connectionManager::class)->getConnection('master');
       
        $radiology_codes = DB::connection($master_db)->table('radiology_codes');
        $pathology_codes = DB::connection($master_db)->table('pathology_codes');

        $pathology_codes = $pathology_codes
        ->select("includes", DB::raw("max(max_charge_amount) as fee"), "description")
        ->where('cpt_code', $cpt)
        ->limit(1)
        ->first();

        $radiology_codes = $radiology_codes
        ->select("includes", DB::raw("max(max_charge_amount) as fee"), "description")
        ->where('cpt_code', $cpt)
        ->limit(1)
        ->first();
        
        return [$pathology_codes, $radiology_codes];
    }

    public function get_anesthesia_fee($cpt) 
    {
        $master_db = app(connectionManager::class)->getConnection('master');
        $db = DB::connection($master_db);
        $anesthesia = $db->table('anesthesia_cpt_crosswalk');

        return 
        $anesthesia
        ->select(
            DB::raw('max(average_submitted_charge_amount) as fee'),
            'anesthesia_code',
            'units',
            'cpt_code_full_description as description'
        )
        ->join('layterms_cpts_layterms', 'layterms_cpts_layterms.cpt_code', '=', 'anesthesia_code')
        ->where('anesthesia_cpt_crosswalk.cpt_code', $cpt)
        ->limit(1)
        ->first();
    }

    public function get_hidden_charges($cpt)
    {
        $master_db = app(connectionManager::class)->getConnection('master');
        $db = DB::connection($master_db);

        $codes = $db->table('addon_primary_crosswalk')
        ->where('addon_code', $cpt)
        ->pluck('primary_code');

        $hidden_charges = null;

        if($codes->count() > 0)
        {
            return $hidden_charges = $this->get_charges_from_mur($master_db, $codes);
        }
        
        $codes = $db->table('addon_primary_crosswalk')->where('primary_code', $cpt)->pluck('addon_code');
        
        if($codes->count() > 0)
        {
            $hidden_charges = $this->get_charges_from_mur($master_db, $codes);
        }

        return $hidden_charges;

    }

    private function get_charges_from_mur($master_db, $codes) 
    {
        return doctorTreatments::select('layterms.cpt_code_full_description as description', DB::raw('max(avg_submitted_charge_amount) as fee'), 'all_codes as code')
        ->join(DB::raw($master_db.'.layterms_cpts_layterms layterms'), 'layterms.cpt_code', '=', 'all_codes')
        ->whereIn('all_codes', $codes)
        ->limit(1)
        ->first(); 
    }


    public function formatted_date($date_of_service)
    {
        $date = explode(' ', $date_of_service);

        $date_of_service = date($date[0]);

        $time_of_service = date("H:i", strtotime($date[1] . "" . $date[2]));

        return [$date_of_service, $time_of_service];
    }

    public function validateCart(Request $request)
    {
        return $request->validate([
            'treatment'       => 'required',
            'date_of_service' => 'required'
        ]);
    }

    public function update_cart_details(Request $request)
    {

        $cart_item = cart::find($request->item_id);
        $user = $request->user();

        if($user->id != $cart_item->user_id) return "Could not update cart";

        $cart_updated = tap($cart_item)->update([
            'add_evob_charges' => $request->add_evob_charges
        ]);

        if($cart_updated) return $cart_updated;

        return "Could not update cart";

    }

    public function update_cart_charges(Request $request) 
    {
        $cart_item = cart::find($request->item_id);
        $type = $request->type;
        $type = "charges_details->added_charges_list->$type";
      
        if($request->user()->id != $cart_item->user_id) return "Could not update cart";

        $cart_item->$type = $request->add_charge;
        $cart_item->save();
       

        if($cart_item) return $cart_item;

        return "Could not update cart";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = cart::find($id);
        $cart->delete();
        return response()->json(200);
    }
}
