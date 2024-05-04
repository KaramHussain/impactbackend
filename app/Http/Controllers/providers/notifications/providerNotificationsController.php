<?php

namespace App\Http\Controllers\providers\notifications;

use Illuminate\Http\Request;
use App\carepays_providers\provider;
use App\Http\Controllers\Controller;

class providerNotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:providers'])->except(['send_claim_uploaded_notification']);
    }

    public function send_claim_uploaded_notification(Request $request)
    {
        $email = $request->email;
        provider::where('email', $email)->first();
        //@todo
    }

    public function showAllunread(Request $request)
    {

        $notifications = $request->user()->unreadNotifications;

        return response()->json($notifications, 200);

    }

    public function markAsRead(Request $request)
    {
        $notifications = $request->user()->unreadNotifications;
        $notifications->markAsRead();
    }

    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;
        $notifications->markAsRead();
        return response()->json($notifications, 200);
    }

    public function show(Request $request)
    {
        $notification = $request->user()->notifications()->find($request->id);
        return response()->json(
            tap($notification)->markAsRead()
        );
    }

}
