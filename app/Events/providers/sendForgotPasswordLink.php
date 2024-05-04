<?php

namespace App\Events\providers;

use Illuminate\Queue\SerializesModels;

class sendForgotPasswordLink
{
    use SerializesModels;

    public $user_details;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->user_details = $details;
    }


}
