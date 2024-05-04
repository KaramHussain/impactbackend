<?php

namespace App\Listeners\Support;

use Illuminate\Support\Facades\Mail;
use App\Mail\Support\SupportEmail;
use App\Events\Support\sendEmailToRecipientsOnSupportRequest;

class sendEmailToUsersOnNegotiateListener
{

    public function handle(sendEmailToRecipientsOnSupportRequest $event)
    {
        $to_addresses = array ("artgelber9454@gmail.com", "thebazshah@gmail.com", "rameel.ahmed@gmail.com");
        $emailSubject = 'Support Request';

        $data = $event->data;
        $user = (Object) $data->user;
        Mail::to($to_addresses)
        ->subject($emailSubject)
        ->send(new SupportEmail($data));
    }
}
