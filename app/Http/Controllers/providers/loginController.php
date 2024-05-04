<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if(!$token = Auth::guard('providers')->attempt($request->only(['email', 'password'], $request->remember)))
        {
            return abort(401, "Oh! you are unauthorized");
        }

        return response()->json(['data' =>
            ['token' => $token]
        ]);
    }

    public function validateLogin(Request $request)
    {
        $this->validate($request, $this->validationRules(), $this->validationErrors());
    }

    public function validationRules()
    {
        return [
            $this->username() => ['required', 'email',
                Rule::exists('providers')->where(function($query) {
                    $query->whereNotNull('email_verified_at')->where('active', 1);
                })
            ],
            'password'        => 'required'
        ];
    }

    public function validationErrors()
    {
        return [
            $this->username(). '.exists' => "email not found, or you need to activate your account"
        ];
    }

    public function username()
    {
        return 'email';
    }
}
