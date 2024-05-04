<?php

namespace App\Http\Controllers\providers;

use App\carepays_providers\provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class activationController extends Controller
{
    public function activate(Request $request)
    {

        $provider = provider::where('email_token', $request->token)
        ->whereNotNull('email_token')
        ->whereNull('email_verified_at')
        ->firstOrFail();
        $provider->update([
            'email_verified_at' => date('Y-m-d'),
            'email_token'       => null
        ]);
        return response()->json("Account activated", 200);
        

    }
}
