<?php

namespace App\Http\Controllers;

use DB;
use App\doctors\doctor;
use Illuminate\Http\Request;
use App\doctors\doctorTreatments;
use App\Events\Auth\sendEmailToUsersOnNegotiate;
use App\Http\Resources\shoppingWindow\shoppingWindowResource;
use App\manager\connectionManager;

class shoppingWindowController extends Controller
{
    protected $connection;

    public function __construct()
    {
        $this->connection = app(connectionManager::class)->getConnection('mur');
    }

    public function sendEmailToUser(Request $request)
    {
        //sending email to user about their offer
        $user = $request->user();
        $data = [];
        $data['user']['name'] = $user->first_name . " " . $user->last_name;
        $data['user']['email'] = $user->email;
        $data['data'] = $request->all();
        event(new sendEmailToUsersOnNegotiate((object) $data));
    }

    public function getFilters()
    {
        return [];
    }

    public function fetchCreds()
    {
        return response()->json(
            array_filter(doctor::pluck('credentials')->unique()->toArray())
        );
    }

    public function fetch_provider_types(Request $request)
    {

        $doctorTreatments = doctorTreatments::query();

        $doctorTreatments = $doctorTreatments->join('national_provider', 'national_provider.npi', '=', 'cpt_codes.npi')
            ->select(DB::raw('distinct provider_type'))
            ->where('all_codes', $request->code)
            ->get()
            ->makeHidden(["out_of_pocket_cost", "market_rate", "purchase_cost", "average_cost", "average_saved", "covered_cost"]);

        return response()->json($doctorTreatments);
    }

    public function fetch(Request $request)
    {

        $latlng = explode(",", $request->latlng);

        $latitude = count($latlng) ? $latlng[0] : 0;
        $longitude = count($latlng) > 1 ?  $latlng[1] : 0;

        $max_distance = $request->has('miles') ? $request->miles : 80;
        $min_distance = 0;

        $code = $request->code;
        $limit = 12;
        $offset = $request->page ? ($request->page - 1) * $limit : 0;

        $distance_sql = '(6371*acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude) ) ) ) AS distance';

        $gender = $request->has('gender') && ($request->gender == 'm' || $request->gender == 'f') ? $request->gender : null;

        $selects = [
            'zip_code',
            'national_provider.id as doctor_id',
            'provider_type',
            'cpt_codes.*'
        ];

        if ($request->has('latlng') && ($latitude != 0 && $longitude != 0)) {
            $selects[] = DB::raw($distance_sql);
        }

        $doctorTreatments = doctorTreatments::query();

        $treatments = $doctorTreatments
            ->join('national_provider', 'cpt_codes.npi', '=', 'national_provider.npi')
            ->join('address', 'provider_id', '=', 'national_provider.npi')
            ->select($selects)
            ->where('all_codes', $code);

        if ($request->has('gender') && ($request->gender == 'm' || $request->gender == 'f')) {
            $treatments = $treatments->where('gender', $gender);
        }

        if ($request->has('reason_for_visit') && ($request->reason_for_visit != 0 || $request->reason_for_visit != '0')) {
            $treatments = $treatments->where('provider_type', $request->reason_for_visit);
        }

        if ($request->has('latlng') && ($latitude != 0 && $longitude != 0)) {
            // $treatments = $treatments->havingRaw('distance IS NULL OR (distance >= ? AND distance <= ?)', [$min_distance, $max_distance]);
            // $treatments = $treatments->orderBy('distance');

            $treatments = $treatments->groupBy('distance');
            $treatments = $treatments->having('distance', '<', $max_distance);
        }

        $treatments = $treatments->simplePaginate($limit);

        $count = $this->get_count_of_treatments($request, $code, $gender);

        // return response()->json($treatments);

        // return new shoppingWindowResource($treatments);

        return (new shoppingWindowResource($treatments))->additional([
            'meta' => [
                'total' => $count
            ]
        ]);

        // $relationships = [
        //     'doctor' => function($query) use ($request) {
        //         $query->filter($request);
        //     },
        //     'doctor.address' => function($query) use ($request) {
        //         $query->filter($request);
        //     }
        // ];

        // $treatments = doctorTreatments::with($relationships)
        // ->filter($request)
        // ->paginate(12);

    }

    public function fetchWithDistance(Request $request)
    {
        $latlng = explode(",", $request->latlng);

        $lat = count($latlng) ? $latlng[0] : 0;
        $lng = count($latlng) > 1 ?  $latlng[1] : 0;
        $code = $request->code;
        $gender = $request->has('gender') && ($request->gender == 'm' || $request->gender == 'f') ? $request->gender : null;

        if ($request->has('latlng') && ($lat != 0 && $lng != 0)) {
            $dtDistance = $this->connection->select("select
            a.zip_code,
            np.id as doctor_id,
            np.provider_type,
            (6370 * acos(sin(radians('$lat')) * sin(radians(latitude)) + cos(radians('$lat')) * cos(radians(latitude)) * cos(radians(longitude) - radians('$lng')))) AS distance,
            cc.*
            from cpt_codes cc
            join national_provider np on np.npi = cc.npi
            join address a on a.provider_id = np.npi
            where cc.all_codes = '49180'
            and (6370 * acos(sin(radians('$lat')) * sin(radians(latitude)) + cos(radians('$lat')) * cos(radians(latitude)) * cos(radians(longitude) - radians('$lng')))) < 10
            limit 12");
            // $count = $this->get_count_of_treatments($request, $code, $gender);
            // return (new shoppingWindowResource($dtDistance))->additional([
            //     'meta' => [
            //         'total' => $count
            //     ]
            // ]);
            return json_encode($dtDistance);
        } else {
            return "Lat long not passed";
        }
    }

    public function get_count_of_treatments(Request $request, $code, $gender)
    {
        $selects = DB::raw('count(*) as aggregate');

        $doctorTreatments = doctorTreatments::query();
        $count = $doctorTreatments
            ->join('national_provider', 'cpt_codes.npi', '=', 'national_provider.npi')
            ->join('address', 'provider_id', '=', 'national_provider.npi')
            ->select($selects)
            ->where('all_codes', $code);

        if ($gender != null) {
            $count = $count->where('gender', $gender);
        }

        if ($request->has('reason_for_visit') && ($request->reason_for_visit != 0 || $request->reason_for_visit != '0')) {
            $count = $count->where('provider_type', $request->reason_for_visit);
        }

        return $count->first()->aggregate;
    }

    public function getDescriptionOfCptCode(Request $request, $code = null)
    {
        $db = DB::connection(
            app(connectionManager::class)->getConnection('icd10cm_cpts_layterms_crosswalk')
        );
        $table = $db->table('cpts_layterms');
        $code = $code == null ? $request->code : $code;

        $result = $table->where('cpt_code', $code)->get(['cpt_code_full_description']);
        return response()->json($result);
    }
}
