<?php

namespace App\Http\Controllers\providers;

use App\carepays_providers\provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class passwordsController extends Controller
{

    public function update(Request $request)
    {

        $provider = $request->user();

        if($provider->email == $request->email)
        {
            return "You did not changed your email";
        }

        $validator = $this->validatePasswords($request);

        if($validator->fails())
        {
            return response()->json(['errors' => $validator->getMessageBag()], 422);
        }

        $provider->update([
            'password' => bcrypt($request->new_password)
        ]);

        return "Password updated";

    }

    public function validatePasswords(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password'         => [
                'required',
                'between:8,25',
                function($attribute, $value, $fail)  use ($request) {
                    if(!Hash::check($value, $this->userPassword($request->user()))) {
                        $fail('Old password is incorrect');
                    }
                }
            ],
            'new_password'         => 'required|between:8,25',
            'confirm_new_password' => [
                'required',
                'between:8,25',
                function($attribute, $value, $fail) use ($request) {
                    if($value !== $request->new_password) {
                        $fail('Passwords does not match');
                    }
                }
            ]
        ]);

        return $validator;

    }

    public function userPassword(provider $user)
    {
        return $user->password;
    }
}
