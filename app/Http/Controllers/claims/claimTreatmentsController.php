<?php

namespace App\Http\Controllers\claims;

use App\claims\claim_treatment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\claims\claimDxPointersController;

class claimTreatmentsController extends Controller
{
    public function store($claim, Request $request)
    {
        $claim_treatments = $request->claim_treatments[0];

        $claim_dx_pointers = new claimDxPointersController;
        foreach($claim_treatments as $treatment)
        {
            $treatment = (object) $treatment;
            $treatment = claim_treatment::create([

                'claim_id' => $claim->id,
                'cpt_code' => $treatment->cpt,
                'cpt_status' => 'closed',
                //'cpt_description' => $treatment->cpt_description,
                'dx1' => $treatment->dx1,
                'dx2' => $treatment->dx2,
                'dx3' => $treatment->dx3,
                'dx4' => $treatment->dx4,
                'pos' => 0,
                'tos' => 0,
                'cpt_units' => $treatment->units,
                'cpt_charged_amount' => $treatment->charge_amount,
                'cpt_allowed_amount' => 0,
                'cpt_expected_amount' => 0,

            ]);

            $claim_dx_pointers->store($claim, $treatment, $request);
        }

    }
}
