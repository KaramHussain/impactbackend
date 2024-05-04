<?php

namespace App\Events\providers\members;

use Illuminate\Queue\SerializesModels;

class sendOTPToMember
{
    use SerializesModels;

    public $provider, $member, $otp;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider, $member, $otp)
    {
        $this->provider = $provider;
        $this->member = $member;
        $this->otp = $otp;
    }


}
