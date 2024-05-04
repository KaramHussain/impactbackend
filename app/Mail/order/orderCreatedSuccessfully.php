<?php

namespace App\Mail\order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class orderCreatedSuccessfully extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->url = env('APP_FRONTEND').'/profile/orders/'.$order->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('auth.order.orderCreatedSuccessfully');
    }
}
