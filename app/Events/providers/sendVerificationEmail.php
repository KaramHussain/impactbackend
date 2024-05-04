<?php

namespace App\Events\providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Queue\SerializesModels;

class sendVerificationEmail
{
    use SerializesModels;

    public $provider;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }
}
