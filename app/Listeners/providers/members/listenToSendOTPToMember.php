<?php

namespace App\Listeners\providers\members;

use App\Events\providers\members\sendOTPToMember;
use App\Mail\providers\members\sendOTPMail;
use Illuminate\Support\Facades\Mail;

class listenToSendOTPToMember
{

    /**
     * Handle the event.
     *
     * @param  sendOTPToMember  $event
     * @return void
     */
    public function handle(sendOTPToMember $event)
    {
        $provider = $event->provider;
        $member = $event->member;
        $otp = $event->otp;
        Mail::to($member->email)->send(new sendOTPMail($provider, $member, $otp));
    }
}
