<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use App\carepays_providers\provider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class changeAccountController extends Controller
{

    public function update(Request $request)
    {

        $provider = $request->user();

        $validator = $this->validateData($request);

        // if($validator->fails())
        // {
        //     return response()->json(['errors' => $validator->getMessageBag()], 422);
        // }

        $provider->update([
            'email' => $request->email,
            'name'  => $request->name,
            'npi'   => $request->npi
        ]);

        return "Account updated";

    }

    public function validateData(Request $request)
    {
        $request->validate([
            'email'   => 'email|required|unique:providers,email,'.$request->user()->id,
            'name'    => 'required',
            'npi'     => 'required|numeric|digits:10'
        ]);
        // $validator = Validator::make($request->all(), [
        //     'email'   => 'email|required|unique:providers,email,'.$request->user()->id,
        //     'name'    => 'required',
        //     'npi'     => 'required|numeric|digits:10'
        // ]);
    }

    public function userPassword(provider $user)
    {
        return $user->password;
    }
}
