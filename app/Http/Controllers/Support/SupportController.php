<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\manager\connectionManager;
use App\Http\Controllers\Controller;
use App\Events\Support\sendEmailToRecipientsOnSupportRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Support\SupportEmail;

class SupportController extends Controller
{
    // protected $connection;

    // public function __construct()
    // {
    //     $this->connection = app(connectionManager::class)->getConnection('search_engine');
    // }   

    public function sendSupportEmail(Request $request)
    {
        $message = new SupportMessage();
        $message->full_name = $request->full_name;
        $message->email = $request->email;
        $message->contact_number = $request->contact_number;
        $message->description = $request->description;
        event(new sendEmailToRecipientsOnSupportRequest((object) $message));

        // $to_addresses = array ("artgelber9454@gmail.com", "thebazshah@gmail.com", "rameel.ahmed@gmail.com");
        // $email_subject = 'Support Request';

        // Mail::to($to_addresses)
        //     // ->subject($email_subject)
        //     ->send(new SupportEmail((object) $message));
    }

    // public function sendEmailToUser(Request $request)
    // {
    //     //sending email to user about their offer
    //     $user = $request->user();
    //     $data = [];
    //     $data['user']['name'] = $user->first_name . " " . $user->last_name;
    //     $data['user']['email'] = $user->email;
    //     $data['data'] = $request->all();
    //     event(new sendEmailToUsersOnNegotiate((object) $data));
    // }
}
