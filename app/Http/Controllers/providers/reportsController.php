<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\carepays_providers\provider_claim;
use App\Http\Resources\providers\collectorsReportResource;

class reportsController extends Controller
{
    
    public function get_claims_with_assoc_collectors(Request $request) 
    {
        $providers = provider_claim::filter($request)->with(
            ['provider', 'remark_codes']
        )->where('practise_id', $request->practise_id)->paginate(20);

        return (new collectorsReportResource($providers))->additional([
            'stats' => $this->get_claim_stats($request)
        ]);

    }

    public function get_claim_stats(Request $request) 
    {
    
        return provider_claim::filter($request)
        ->select(...$this->get_stats_query())->where('practise_id', $request->practise_id)->get();

    }

    public function get_stats_query() 
    {
        return [
            DB::raw('IFNULL(SUM(CASE WHEN claim_status = "denied" THEN 1 END), 0) AS eob_denied_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN claim_status = "accepted" THEN 1 END), 0) AS eob_accepted_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN claim_status = "rejected" THEN 1 END), 0) AS eob_rejected_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN status = "to_be_reviewed" THEN 1 END), 0) AS opened_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN status = "assigned" OR status = "to_be_reviewed" THEN 1 END), 0) AS unpaid_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN status = "submitted" THEN 1 END), 0) AS submitted_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN status = "resolved" THEN 1 END), 0) AS resolved_claims'),
            DB::raw('IFNULL(SUM(CASE WHEN status = "assigned" THEN 1 END), 0) AS assigned_claims'),
            DB::raw('cast(avg(days_to_resolve) as INT) as avg_days_to_resolve'),
            DB::raw('SUM(total_claim_charges) AS total_charges'),
            // DB::raw('SUM(CASE WHEN status = "submitted" OR status = "resolved" THEN total_claim_charges ELSE 0 END) AS money_gathered'),
            
            DB::raw('SUM(CASE WHEN status = "submitted" OR status = "resolved" THEN total_claim_charges ELSE 0 END) AS money_gathered'),
            DB::raw('SUM(CASE WHEN status = "assigned" OR status = "to_be_reviewed" THEN total_claim_charges ELSE 0 END) AS due_charges')
        ];
    }

    public function get_remark_codes_with_dates(Request $request) 
    {

        $remark_types = ['avoidable', 'low_fruit', 'compliance'];
        $request->validate([
            'type' => ['required', Rule::in($remark_types)]
        ]);

        $record = provider_claim::join('claim_remark_codes as codes', 'codes.claim_id', '=', 'provider_claims.id')
        ->where($request->type, 1)
        ->select(
            DB::raw('SUM(CASE WHEN claim_status = "denied" THEN 1 ELSE 0 END) AS eob_denied_claims'),
            DB::raw('SUM(CASE WHEN claim_status = "accepted" THEN 1 ELSE 0 END) AS eob_accepted_claims'),
            DB::raw('SUM(CASE WHEN claim_status = "rejected" THEN 1 ELSE 0 END) AS eob_rejected_claims'),
            DB::raw('SUM(CASE WHEN claim_status = "processing" THEN 1 ELSE 0 END) AS eob_processing_claims'),
            DB::raw('SUM(CASE WHEN status = "assigned" THEN 1 ELSE 0 END) AS assigned'),
            DB::raw('SUM(CASE WHEN status = "submitted" THEN 1 ELSE 0 END) AS submitted_claims'),
            DB::raw('SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) AS resolved_claims'),
            'date_of_service'
        )
        ->groupBy('date_of_service')    
        ->get();

        $processing = [];
        $denied = [];
        $rejected = [];
        $accepted = [];
        $opened = [];
        $resolved = [];
        $dates = [];
        $assigned = [];

        $record->each(function ($item) use (&$processing, &$denied, &$accepted, &$opened, &$resolved, &$dates) {
            return [
                $processing  []= $item['eob_processing_claims'],
                $denied    []= $item['eob_denied_claims'],
                $accepted  []= $item['eob_accepted_claims'],
                $rejected  []= $item['rejected_claims'],
                $opened    []= $item['opened_claims'],
                $submitted []= $item['submitted_claims'],
                $resolved  []= $item['resolved_claims'],
                $assigned  []= $item['assigned'],
                $dates     []= $item['date_of_service'] 
            ];
            
        });

        return response()->json([
            'processing' => $processing, 
            'denied' => $denied, 
            'rejected' => $rejected, 
            'accepted' => $accepted, 
            'opened' => $opened, 
            'resolved' => $resolved, 
            'assigned' => $assigned,
            'date' => $dates, 

        ]);

    }

    public function get_stats_with_collectors(Request $request) 
    {
        $record = provider_claim::filter($request)
        ->join('providers', 'providers.id', '=', 'provider_claims.provider_id')
        ->select(
            DB::raw('SUM(CASE WHEN claim_status = "denied" THEN total_claim_charges ELSE 0 END) AS eob_denied_charges'),
            DB::raw('SUM(CASE WHEN claim_status = "accepted" THEN total_claim_charges ELSE 0 END) AS eob_accepted_charges'),
            DB::raw('SUM(CASE WHEN claim_status = "rejected" THEN total_claim_charges ELSE 0 END) AS eob_rejected_charges'),
            DB::raw('SUM(CASE WHEN claim_status = "processing" THEN total_claim_charges ELSE 0 END) AS eob_processing_charges'),
            DB::raw('SUM(CASE WHEN status = "assigned" THEN total_claim_charges ELSE 0 END) AS assigned_charges'),
            DB::raw('SUM(CASE WHEN status = "submitted" THEN total_claim_charges ELSE 0 END) AS submitted_charges'),
            DB::raw('SUM(CASE WHEN status = "resolved" THEN total_claim_charges ELSE 0 END) AS resolved_charges'),
            DB::raw('SUM(CASE WHEN status = "submitted" OR claim_status = "denied" THEN total_claim_charges ELSE 0 END) AS expected_revenue'),
            DB::raw('SUM(total_claim_charges) AS total_charges'),
            DB::raw('AVG(days_to_resolve) AS avg_days_to_resolve'),
            'providers.name as providers',
            'providers.id',
            'date_of_service'
        )
        ->groupBy('providers.id')    
        ->get();

        $denied_charges = [];
        $accepted_charges = [];
        $rejected_charges = [];
        $processing_charges = [];
        $resolved_charges = [];
        $collectors = [];
        $submitted_charges = [];
        $assigned_charges = [];
        $expected_revenue = [];
        $date_of_service = [];
        $avg_days_to_resolve = [];
        $total = [];
        $avg_collected_raito = [];


        $record->each(function ($item) use 
        (&$denied_charges, 
        &$accepted_charges, 
        &$rejected_charges, 
        &$processing_charges, 
        &$resolved_charges, 
        &$collectors, 
        &$submitted_charges, 
        &$assigned_charges, 
        &$date_of_service, 
        &$expected_revenue, 
        &$avg_days_to_resolve, 
        &$total, 
        &$avg_collected_raito) {
            return [
                $denied_charges      []= $item['eob_denied_charges'],
                $accepted_charges    []= $item['eob_accepted_charges'],
                $rejected_charges    []= $item['eob_rejected_charges'],
                $processing_charges  []= $item['eob_processing_charges'],
                $assigned_charges    []= $item['assigned_charges'],
                $submitted_charges   []= $item['submitted_charges'],
                $resolved_charges    []= $item['resolved_charges'],
                $collectors          []= $item['providers'],
                $date_of_service     []= $item['date_of_service'],
                $expected_revenue    []= $item['expected_revenue'],
                $avg_days_to_resolve []= $item['avg_days_to_resolve'],
                $total               []= $item['total_charges'],
                $avg_collected_raito []= $item['eob_accepted_charges'] / $item['total_charges']  
            ];
        });

        return [ 
            'denied_charges'      => $denied_charges,
            'accepted_charges'    => $accepted_charges,
            'rejected_claims'     => $rejected_charges,
            'processing_claims'   => $processing_charges,
            'resolved_claims'     => $resolved_charges,
            'collectors'          => $collectors,
            'submitted_charges'   => $submitted_charges,
            'assigned_charges'    => $assigned_charges,
            'date'                => $date_of_service,
            'expected_revenue'    => $expected_revenue,
            'avg_days_to_resolve' => $avg_days_to_resolve,
            'avg_collected_raito' => $avg_collected_raito,
            'total'               => $total,
        ];

    }


}
