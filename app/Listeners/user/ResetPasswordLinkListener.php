<?php

namespace App\Listeners\user;

use App\Events\user\ResetPasswordLink;
use App\Mail\user\resetPasswordMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class ResetPasswordLinkListener
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
     * @param  ResetPasswordLink  $event
     * @return void
     */
    public function handle(ResetPasswordLink $event)
    {
        $details = $event->user_details;
        Mail::to($details->email)->send(new resetPasswordMail($details));
    }
}
