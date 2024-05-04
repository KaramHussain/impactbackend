<?php

namespace App\Listeners\Auth;

use App\Events\Auth\userRequestedActivationEmail;
use App\Mail\Auth\ActivationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class sendActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  userRequestedActivationEmail  $event
     * @return void
     */
    public function handle(userRequestedActivationEmail $event)
    {

        if($event->user->active) {
            return;
        }

        Mail::to($event->user->email)->send(new ActivationEmail($event->user));

    }
}
