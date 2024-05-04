<?php

namespace App\Mail\user;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class resetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public $email;
    public $url = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->token = $details->token;
        $this->email = $details->email;
        $this->url = config('app.frontend_url').'/account/reset?token='.$this->token.'&email='.$this->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Emails.user.resetPassword');
    }
}
