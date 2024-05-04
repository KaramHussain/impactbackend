<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\manager\connectionManager;
use App\Http\Controllers\Controller;
use App\Events\Support\sendEmailToRecipientsOnSupportRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Support\SupportEmail;

class SupportMessage
{
    public $full_name;
    public $email;
    public $contact_number;
    public $description;
}
