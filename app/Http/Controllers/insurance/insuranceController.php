<?php

namespace App\Http\Controllers\insurance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\authInsuranceResource;
use App\insurance\patient_insurance;
use App\insurance\payer_list;
use Illuminate\Validation\Rule;

class insuranceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->except(['fetch', 'types']);
    }

    public function fetch(Request $request)
    {
        $name = $request->q;
        $results = payer_list::where('name', 'LIKE', "%$name%")->orderBy('name', 'ASC')->distinct()->limit(6)->get(['name as term']);
        return response()->json($results);
    }

    public function types()
    {
        $results = payer_list::where('insurance_type', '<>', NULL)->orderBy('insurance_type', 'ASC')->distinct()->get(['insurance_type']);
        return response()->json($results);
    }

    public function delete($id, Request $request)
    {
        $auth = $request->user();
        if($auth->insurances()->find($id)->delete())
        {
            return 200;
        }
    }

    public function create(Request $request)
    {

        $auth = $request->user();

        $this->validateInsurance($request);

        if(($request->person !== 'self' && $request->person != 0) && ($request->financial_guarantor == null || $request->financial_guarantor == ''))
        {
            return response()->json(['errors' =>
                ['financial_guarantor' => ['Financial guarantor name is required']
            ]], 422);
        }

        $patient_insurance_created = $auth->insurances()->create($this->insuranceDetails($request));

        if($patient_insurance_created)
        {
            return response()->json(200);
        }
    }

    public function update($id, Request $request)
    {
        $auth = $request->user();

        $this->validateInsurance($request);

        if(($request->person !== 'self' && $request->person != 0) && ($request->financial_guarantor == null || $request->financial_guarantor == ''))
        {
            return response()->json(['errors' =>
                ['financial_guarantor' => ['Financial guarantor name is required']
            ]], 422);
        }


        $patient_insurance_created =
        $auth->insurances()->where('id', $id)
        ->update($this->insuranceDetails($request));

        if($patient_insurance_created)
        {
            return response()->json(200);
        }
    }

    public function insuranceDetails(Request $request)
    {
        return [
            'insurance_person'          => $request->person,
            'insured_ssn'               => $request->id_or_ssn,
            'insurance_package'         => $request->package,
            'financial_guarantor_name'  => $request->financial_guarantor_name,
            'insurance_name'            => $request->insurance_name,
            'insurance_type'            => $request->type,
            'insurance_policy_number'   => $request->policy_number,
            'insurance_service_number'  => $request->service_number,
            'insurance_plan_name'       => $request->plan_name,
            'is_employeed'              => $request->employeed,
            'can_contact_employer'      => $request->contact_for_verification,
            'name_of_employer'          => null,
            'hr_contact_person'         => null,
            'hr_phone_no'               => null,
            'group_id_no'               => 000
        ];
    }

    public function validateInsurance(Request $request)
    {
        $rule = Rule::notIn('0');

        $request->validate([
            'person'         => $rule,
            'insurance_name' => 'required',
            'type'           => $rule,
            'package'        => $rule,
            'policy_number'  => 'required|numeric',
            'plan_name'      => 'required',
            'id_or_ssn'      => 'required',
            'service_number' => 'required|numeric'
        ]);
    }

    public function getAuthInsurances(Request $request)
    {

        $auth_id = $request->user()->id;

        return new authInsuranceResource(
            patient_insurance::where('user_id', $auth_id)->get()
        );

    }
    //single insurance
    public function getAuthInsurance(patient_insurance $insurance, Request $request)
    {
       $auth = $request->user();
       return $auth->insurances()->find($insurance->id);
    }

}
