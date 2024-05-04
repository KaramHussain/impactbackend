<?php

namespace App\Mail\providers\members;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendOTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $provider, $otp, $member;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($provider, $member, $otp)
    {
        $this->provider = $provider;
        $this->member = $member;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Join carePays Invitation')->markdown('providers.members.sendOTPView');
    }
}
