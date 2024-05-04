<?php

namespace App\Mail\providers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class resetPasswordMailToProvider extends Mailable
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
        $this->url = config('app.frontend_impact_analysis').'/account/reset?token='.$this->token.'&email='.$this->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('providers.resetPasswordMailToProviderView');
    }
}
