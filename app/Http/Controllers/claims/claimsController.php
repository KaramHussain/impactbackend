<?php

namespace App\Http\Controllers\claims;

use App\claims\claim;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\claims\claimTreatmentsController;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class claimsController extends Controller
{


    public function store(Request $request)
    {
        $claim_time       = date("H:i:s");
        $transaction_date = date("Y-m-d");
        $transaction_time = date("H:i:s");
        $interchange_date = date("Y-m-d");
        $interchange_time = date("H:i:s");

        $claim = claim::create([

            'claim_id' => $request->claim_id,
            'order_id' => $request->order_id,
            'user_id' => $request->user_id,
            'provider_id' => $request->provider_id,
            'patient_insurance_id' => $request->patient_insurance_id,
            'date_of_service' => $request->date_of_service,
            'claim_status' => $request->claim_status,
            'claim_time' => $claim_time,
            'transaction_date' => $transaction_date,
            'transaction_time' => $transaction_time,
            'interchange_date' => $interchange_date,
            'interchange_time' => $interchange_time,
            'submitter_entity_identifier_code' => $request->submitter_entity_identifier_code,
            'submitter_name' => $request->submitter_name,
            'submitter_contact_name' => $request->submitter_contact_name,
            'submitter_communication_number' => $request->submitter_communication_number,
            'receiver_entity_identifier_code' => $request->receiver_entity_identifier_code,
            'receiver_name' => $request->receiver_name,
            'receiver_identification_code' => $request->receiver_identification_code,
            'total_claim_charge_amount' => $request->total_claim_charge_amount,
            'no_of_proc' => $request->no_of_proc,
            'no_of_dx' => $request->no_of_dx

        ]);

        $claim_treatments = new claimTreatmentsController;

        $claim_treatments->store($claim, $request);

        return response()->json("success");

    }

    public function show(Request $request)
    {
        $auth = $request->user();

        $claim = $auth->claims()
        ->where('provider_id', $request->doctor_id)
        ->where('order_id', $request->order_id)->first();

        return response()->json($claim);

    }

}
