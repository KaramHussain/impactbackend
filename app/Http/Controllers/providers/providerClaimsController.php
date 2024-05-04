<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\carepays_providers\provider_claim;
use App\carepays_providers\claim_remark_code;
use App\carepays_providers\provider_responsibility;
use App\Http\Resources\providers\providerClaimsResource;

class providerClaimsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        [$low_fruit, $avoidable, $compliance] = $this->getProviderRemarkTypes($request);

        $providers = provider_claim::join('claim_remark_codes', 'claim_remark_codes.claim_id', '=', 'provider_claims.id')
        // ->join('claim_reason_codes', 'claim_reason_codes.claim_id', '=', 'provider_claims.id')
        ->select('provider_claims.*', 'claim_remark_codes.code')
        ->whereIn('provider_claims.payer_id', $request->payers)
        ->where(function($query) use ($low_fruit, $compliance, $avoidable) {
            $query->Orwhere('low_fruit', $low_fruit);
            $query->Orwhere('compliance', $compliance);
            $query->Orwhere('avoidable', $avoidable);
        })
        ->where('status', 'to_be_reviewed')
        ->orWhere(function($query) use ($request) {
            $query->whereIn('status', ['assigned', 'submitted', 'resolved'])->where('provider_id', $request->user()->id);
        });

        return ( new providerClaimsResource( $providers->paginate() ));
        
    }
    
    /**
     * get only collector claims on which he is working.
     *
     * @return $claims
     */

    public function get_working_claims_of_collector(Request $request) 
    {
       
        $providers = provider_claim::filter($request)
        ->where('provider_id', $request->provider_id);
        
        return ( new providerClaimsResource( $providers->paginate(12) ));
    }

     /**
     * Check remark types for provider
     *
     * @return @array
     */
    public function getProviderRemarkTypes(Request $request) 
    {
        $remark_codes = provider_responsibility::join('remark_codes', 'remark_codes.id', '=', 'responsable_id')
        ->where('provider_id', $request->user()->id)
        ->where('responsable_type', 'remark_code')
        ->get(['low_fruit', 'avoidable', 'compliance'])->toArray();

        $low_fruits = array_unique(array_column($remark_codes, 'low_fruit'));
        $avoidables = array_unique(array_column($remark_codes, 'avoidable'));
        $compliances = array_unique(array_column($remark_codes, 'compliance'));

        $low_fruit = in_array('1', $low_fruits) ? 1 : 0;
        $avoidable = in_array('1', $avoidables) ? 1 : 0;
        $compliance = in_array('1', $compliances) ? 1 : 0;

        return [$low_fruit, $avoidable, $compliance];
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
        $claims = $request->for_;
        $type = strtolower(gettype($claims));
        Storage::put('new_file', json_encode($request->for_));
        if($type == 'string') 
        {
            $claims = json_decode($claims, true);
        }    
        
        $this->storeJsonError($type);
       
        foreach($claims as $claim) 
        {
            $claim = (object) $claim;
            $saved_claim = provider_claim::create([
                'claim_id'               => $claim->claim_id,
                'claim_status'           => $claim->claim_status[0],
                'practise_id'            => $claim->practise_id,
                'payer_id'               => $claim->payer_id,
                'patient_name'           => $claim->patient_name,
                'doctor_name'            => $claim->provider_name,
                'payer_name'             => $claim->payer_name,
                'total_claim_charges'    => $claim->total_claim_charges,
                'patient_responsibility' => $claim->patient_responsibility,
                'total_paid_amount'      => $claim->total_paid_amount,
                //'date_of_service'        => $claim->s
            ]);

            foreach($claim->remark_codes as $remark_code) 
            {
                $remark_code = (array) $remark_code;

                claim_remark_code::create([
                    'claim_id' => $saved_claim->id,
                    'code'     => $remark_code['code'] ?? NULL,
                    'avoidable' => $remark_code['AVOIDABLE DENIAL'],
                    'low_fruit' => $remark_code['LOW FRUIT'],
                    'compliance' => $remark_code['COMPLIANCE']
                ]);
            }
            
        }

        return "Success, Data saved";
    
    }

    public function storeJsonError($type) 
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                echo ' - No errors';
                Storage::put('errors_log', 'No errors'.$type);
            break;
            case JSON_ERROR_DEPTH:
                echo ' - Maximum stack depth exceeded';
                Storage::put('errors_log', 'Maximum stack depth exceeded'.$type);
            break;
            case JSON_ERROR_STATE_MISMATCH:
                echo ' - Underflow or the modes mismatch';
                Storage::put('errors_log', 'Underflow or the modes mismatch'.$type);
            break;
            case JSON_ERROR_CTRL_CHAR:
                echo ' - Unexpected control character found';
                Storage::put('errors_log', 'Unexpected control character found'.$type);
            break;
            case JSON_ERROR_SYNTAX:
                echo ' - Syntax error, malformed JSON';
                Storage::put('errors_log', 'malformed JSON'.$type);
            break;
            case JSON_ERROR_UTF8:
                echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                Storage::put('errors_log', 'Malformed UTF-8 characters, possibly incorrectly encoded'.$type);
            break;
            default:
                echo ' - Unknown error';
                Storage::put('errors_log', 'Unknown error'.$type);
            break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\provider_claim  $provider_claim
     * @return \Illuminate\Http\Response
     */
    public function show(provider_claim $provider_claim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\provider_claim  $provider_claim
     * @return \Illuminate\Http\Response
     */
    public function edit(provider_claim $provider_claim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\provider_claim  $provider_claim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $claim = provider_claim::findByClaimId($request->claim_id)->first();

        if($claim->status == provider_claim::SUBMITTED) 
        {
            return "Claim already submitted";
        }

        $claim = tap($claim)->update([
            'status'             => provider_claim::SUBMITTED,
            'claim_status'       => 'processing',
            'date_of_submission' => now(),
            'days_to_submit'     => $this->getDiffInDates($claim->date_of_assigned)
        ]);
        return response()->json($claim);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\provider_claim  $provider_claim
     * @return \Illuminate\Http\Response
     */
    public function destroy(provider_claim $provider_claim)
    {
        //
    }

    /**
     * Assign claim to provider and update status
     *
     * @param  \Illuminate\Http\Request $request
     * @return string
     */
    public function assign_claim(Request $request)
    {
        $claim = provider_claim::findByClaimId($request->claim_id)->first();
        $provider_id = $request->provider_id;
        if(strtolower($request->handle_claim) == 'yes')
        {
            $claim = tap($claim)->update([
                'status'           => 'assigned',
                'provider_id'      => $provider_id,
                'date_of_assigned' => now()
            ]);
        }

        return response()->json($claim);

    }

    public function check_claim_status(Request $request)
    {
        return provider_claim::findByClaimId($request->claim_id)->first();
    }

}
