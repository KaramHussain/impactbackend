<?php

namespace App\Listeners\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\Auth\negotiatePriceMail;
use App\Events\Auth\sendEmailToUsersOnNegotiate;

class sendEmailToUsersOnNegotiateListener
{

    public function handle(sendEmailToUsersOnNegotiate $event)
    {
        $data = $event->data;
        $user = (Object) $data->user;
        Mail::to($user->email)->send(new negotiatePriceMail($data));
    }
}
