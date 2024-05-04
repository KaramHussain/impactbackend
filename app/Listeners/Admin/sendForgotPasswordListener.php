<?php

namespace App\Listeners\Admin;

use Illuminate\Support\Facades\Mail;
use App\Events\Admin\sendPasswordLink;
use App\Mail\Admin\resetPasswordMailToProvider;

class sendForgotPasswordListener
{
    
    public function handle(sendPasswordLink $event)
    {
        $details = $event->user_details;
        Mail::to($details->email)->send(new resetPasswordMailToProvider($details));
    }
}
