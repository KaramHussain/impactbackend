<?php

namespace App\Http\Controllers\dependants;

use App\dependants\patient_dependant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class dependantsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function store(Request $request)
    {

        $user = auth()->user($request);

        $insurance = $user->insurances()->where('id', $request->insurance)->first();

        if(!$insurance) return [];

        $dependant = $insurance->dependants()->create([
           'user_id'            => $user->id,
           'dependant_name'     => $request->name,
           'dependant_relation' => $request->relation
        ]);

       return response()->json($dependant);

    }

    public function index(Request $request)
    {
        $dependants = $this->dependantsByInsurance($request);
        return response()->json($dependants);
    }

    public function dependantsByInsurance(Request $request)
    {
        return patient_dependant::where('insurance_id', $request->insurance)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function update(patient_dependant $dependant, Request $request)
    {

        $dependant = tap($dependant)->update(
            $this->dependantFields($request)
        );

        return response()->json($dependant);

    }

    public function delete(patient_dependant $dependant)
    {
        $dependant->delete();
        return response()->json("Dependant deleted");
    }

    public function dependantFields($request)
    {
        return [
            'dependant_name' => $request->name,
            'dependant_relation' => $request->relation
        ];
    }

}
