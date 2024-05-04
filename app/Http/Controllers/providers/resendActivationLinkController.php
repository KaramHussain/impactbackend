<?php

namespace App\Http\Controllers\providers;

use Illuminate\Http\Request;
use App\carepays_providers\provider;
use App\Http\Controllers\Controller;
use App\Events\providers\sendVerificationEmail;

class resendActivationLinkController extends Controller
{
    public function resend(Request $request)
    {

        $provider = $this->validateResendRequest($request);

        $provider = provider::where('email', $request->email)->first();

        if($provider)
        {

            $provider->update([
                'email_token'       => str_random(255),
                'email_verified_at' => null
            ]);

            event(new sendVerificationEmail($provider));
            return response()->json(200);

        }
        return abort(401);
    }

    public function validateResendRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:providers,email'
        ], [
            'email.exists' => 'Sorry we could not found that email'
        ]);
    }
}
