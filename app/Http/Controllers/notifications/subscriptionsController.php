<?php

namespace App\Http\Controllers\notifications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\notifications\subscriber;

class subscriptionsController extends Controller
{
    public function subscribe(Request $request)
    {
        $email = $request->email;
        $this->validateEmail($request);
        $subscriber = subscriber::create(['email' => $email]);
        if($subscriber)
        {
            return response()->json(['Subsciption added']);
        }

    }

    public function validateEmail(Request $request)
    {
        return $request->validate([
            'email' => 'required|email'
        ]);
    }

}
