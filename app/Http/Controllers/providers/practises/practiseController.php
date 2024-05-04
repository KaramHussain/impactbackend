<?php

namespace App\Http\Controllers\providers\practises;

use App\carepays_providers\practise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\providers\registrationRequest;

class practiseController extends Controller
{

    public function create(registrationRequest $request)
    {
        //$this->validateRequest($request);

        return practise::create([
            'name'        => $request->company_name,
            'phone'       => $request->phone,
            'zipcode'     => $request->zipcode,
            'city'        => $request->city,
            'state'       => $request->state,
            'admin_email' => $request->email,
            'address'     => $request->address
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update');
        $this->validateCompany($request);

        $provider = $request->user();

        $provider->practise()->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
            'state'   => $request->state,
            'city'    => $request->city,
            'zipcode' => $request->zipcode
        ]);

        return response()->json("Changes saved", 200);
    }

    public function validateRequest(Request $request)
    {
        $request->validate([
            // 'company_name'  => 'required|unique:practises,name',
            'phone'         => 'required',
            'address'       => 'required',
            'state'         => 'required|exists:states,state',
            'city'          => 'required',
            // 'city'          => 'required|exists:cities,city',
            'zipcode'       => 'required|min:5,max:5'
        ]);
    }

    public function validateCompany(Request $request)
    {
        $request->validate([
            // 'name'    => 'required|unique:practises,name,',
            'phone'   => 'required',
            'address' => 'required',
            'state'   => 'required|exists:states,state',
            'city'    => 'required',
            // 'city'    => 'required|exists:cities,city',
            'zipcode' => 'required|min:5,max:5'
        ]);
    }
}
