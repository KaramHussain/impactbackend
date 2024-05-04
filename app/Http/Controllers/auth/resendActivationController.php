<?php

namespace App\Http\Controllers\auth;

use DB;
use Illuminate\Support\Str;
use App\Events\Auth\userRequestedActivationEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class resendActivationController extends Controller
{
    public function resend(Request $request)
    {

        $user = $this->validateResendRequest($request);
        $db = DB::table('users');
        $user = (array) $db->where('email', $request->email)->get()[0];

        if($user)
        {

            $db = DB::table('users');
            $user = $db->where('email', $request->email)->update([
                'activation_token' => Str::random(255),
                'active'           => 0
            ]);

            $user = $db->where('email', $request->email)->get()->first();

            event(new userRequestedActivationEmail($user));
            return response()->json(200);

        }
        return abort(401);
    }

    public function validateResendRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Sorry we could not found that email'
        ]);
    }
}
