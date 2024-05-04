<?php

namespace App\Events\Admin;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class sendPasswordLink
{
    use Dispatchable, SerializesModels;

    public $user_details;
    public function __construct($details)
    {
        $this->user_details = $details;
    }

}
