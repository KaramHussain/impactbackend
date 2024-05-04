<?php

namespace App\Listeners\providers;

use Illuminate\Support\Facades\Mail;
use App\Events\providers\sendForgotPasswordLink;
use App\Mail\providers\resetPasswordMailToProvider;

class listenToSendForgotPasswordLink
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(sendForgotPasswordLink $event)
    {
        $details = $event->user_details;
        Mail::to($details->email)->send(new resetPasswordMailToProvider($details));
    }
}
