<?php

namespace App\Providers;

use App\Events\Admin\sendPasswordLink;
use App\Events\Auth\{userRequestedActivationEmail, sendEmailToUsersOnNegotiate};
use App\Events\order\mailUserOrderCreated;
use App\Events\order\orderPaymentFailed;
use App\Events\user\ResetPasswordLink;
use App\Listeners\Auth\{sendActivationEmail, sendEmailToUsersOnNegotiateListener};
use App\Listeners\user\ResetPasswordLinkListener;
use App\Events\order\orderCreated;
use App\Events\providers\members\sendOTPToMember;
use App\Events\providers\sendForgotPasswordLink;
use App\Events\providers\sendVerificationEmail;
use App\Listeners\Admin\sendForgotPasswordListener;
use App\Listeners\order\mailUserOrderCreatedListener;
use App\Listeners\order\markOrderStatusFailed;
use App\Listeners\order\processPayment;
use App\Listeners\providers\listenToSendForgotPasswordLink;
use App\Listeners\providers\ListenToVerificationEmailEvent;
use App\Listeners\providers\members\listenToSendOTPToMember;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        userRequestedActivationEmail::class => [
            sendActivationEmail::class,
        ],
        ResetPasswordLink::class => [
            ResetPasswordLinkListener::class,
        ],
        sendEmailToUsersOnNegotiate::class => [
            sendEmailToUsersOnNegotiateListener::class
        ],
        orderCreated::class => [
            processPayment::class
        ],
        orderPaymentFailed::class => [
            markOrderStatusFailed::class
        ],
        mailUserOrderCreated::class => [
            mailUserOrderCreatedListener::class
        ],
        sendVerificationEmail::class => [
            ListenToVerificationEmailEvent::class
        ],
        sendOTPToMember::class => [
            listenToSendOTPToMember::class
        ],
        sendForgotPasswordLink::class => [
            listenToSendForgotPasswordLink::class
        ],
        sendPasswordLink::class => [
            sendForgotPasswordListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
