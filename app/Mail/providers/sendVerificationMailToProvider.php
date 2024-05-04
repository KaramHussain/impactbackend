<?php

namespace App\Mail\providers;

use App\carepays_providers\provider;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendVerificationMailToProvider extends Mailable
{
    use Queueable, SerializesModels;

    public $provider;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(provider $provider)
    {
        $this->provider = $provider;
        $this->url = config('app.frontend_impact_analysis') . '/verify?token=' . $provider->email_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email verification')->markdown('providers.sendVerificationEmailToProvider');
    }
}
