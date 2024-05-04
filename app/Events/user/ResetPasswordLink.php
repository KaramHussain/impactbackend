<?php

namespace App\Events\user;

// use Illuminate\Queue\SerializesModels;
// use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordLink implements ShouldQueue
{
    // use Dispatchable, SerializesModels;

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

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
