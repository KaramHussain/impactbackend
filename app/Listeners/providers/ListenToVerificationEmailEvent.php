<?php

namespace App\Listeners\providers;

use App\Events\providers\sendVerificationEmail;
use App\Mail\providers\sendVerificationMailToProvider as AppSendVerificationMailToProvider;
use Illuminate\Support\Facades\Mail;

class ListenToVerificationEmailEvent
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

    /**
     * Handle the event.
     *
     * @param  sendVerificationEmail  $event
     * @return void
     */
    public function handle(sendVerificationEmail $event)
    {
        $provider = $event->provider;
        Mail::to($provider->email)->send(new AppSendVerificationMailToProvider($provider));
    }
}
