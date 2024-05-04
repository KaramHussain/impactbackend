<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\carepays_providers\practise;
use App\Http\Controllers\Controller;
use App\carepays_providers\provider_claim;

class membersController extends Controller
{

    public function __construct() 
    {
        // $this->middleware('auth:admins');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $members = $this->get_members_from_edi($request);
        $members = gettype($members) === 'string' ? json_decode($members, false) : $members;
        if(!count($members)) return [];
        $practise_ids = collect($members)->pluck('PROVIDER_ID');
        $practises = $this->get_practises_details($practise_ids);
        $practise_details = $this->get_merged_practises_details($members, $practises);

        return response()->json($practise_details);
    }

    public function get_merged_practises_details($members, $practises) 
    {
        $details = [];
        for($i = 0; $i < count($members); $i++) 
        {
            $member = (array) $members[$i];
            $key = array_search($member['PROVIDER_ID'], array_column($practises, 'id'));
            if($key !== false) 
            {
                $details []= array_merge($member, (array) $practises[$key]);
            }
        }
        return $details;
    }


    protected function get_practises_details($practise_ids) 
    {
        return practise::with(['providers', 'providers.roles'])->whereIn('id', $practise_ids)->get()->toArray();
    }

    public function get_members_from_edi(Request $request) 
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://graph.carebidsexchange.com/get_all');
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request->all()));

        $response = curl_exec($ch);

        return $response;

        curl_close($ch);
    }

    public function get_top_performers() 
    {
        $providers =  provider_claim::
        select('providers.name as name', DB::raw('SUM(total_paid_amount) as total_paid_amount'), 'providers.image as image')
        ->join('providers', 'providers.id', '=', 'provider_claims.provider_id')
        ->groupBy('provider_id')
        ->latest('total_paid_amount')
        ->limit(5)
        ->get();
        return response()->json($providers);
    }

    public function get_members() 
    {
        return response()->json(practise::paginate(12));
    }

}
