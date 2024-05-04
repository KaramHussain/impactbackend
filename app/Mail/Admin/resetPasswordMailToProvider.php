<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPasswordMailToProvider extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $token;
    public $email;
    public $url = null;

    public function __construct($details)
    {
        $this->token = $details->token;
        $this->email = $details->email;
        $this->url = config('app.frontend_admin').'/reset?token='.$this->token.'&email='.$this->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Admin\resetPasswordMail')->subject('Recover Your Password');
    }
}
