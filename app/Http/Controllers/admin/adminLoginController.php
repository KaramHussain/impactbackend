<?php

namespace App\Http\Controllers\admin;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\admin\adminResource;
use Illuminate\Validation\ValidationException;

class adminLoginController extends Controller
{
    public function login(Request $request) 
    {
        
        $this->validateLogin($request);

        if(!$token = Auth::guard('admins')->attempt($request->only(['email', 'password'], $request->remember))) 
        {
            throw ValidationException::withMessages([
                'email' => 'Email not found or you need to activate your email'
            ]);
            return abort(401, "You are unauthorized");
        }

        return response()->json($token);

    }

    public function me() 
    {
        return response()->json([
            'data' => new adminResource(auth('admins')->user())
        ]);
    }

    public function validateLogin(Request $request) 
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('admins')->where(function($query) {
                    $query->whereNotNull('email_verified_at')->where('active', 1);
                }),
            ],
            'password' => 'required'
        ]);    
    }

}
