<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if(!$token = auth('api')->attempt($request->only(['email', 'password'])))
        {
            return abort(401);
        }

        return (new UserResource($request->user()))
        ->additional([
            'meta' => [
                'token' => $token
            ]
        ]);

    }

    public function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => ['required', 'email',
                Rule::exists('users')->where(function($query) {
                    $query->where('active', 1);
                })
            ],
            'password'        => 'required'
        ], $this->validationErrors());

    }

    public function validationErrors()
    {
        return [
            $this->username(). '.exists' => "email not found, or you need to activate your email"
        ];
    }

    public function username()
    {
        return 'email';
    }

}
