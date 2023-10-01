<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealTimeNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $invoice;
    public $created_at;
    public $user;
    /**
     * Create a new event instance.
     */
    public function __construct($invoice,$created_at,$user)
    {
        //
        $this->invoice = $invoice;
        $this->created_at = $created_at;
        $this->user = $user;
    }

   
    public function broadcastOn()
    {
        return new Channel('notify');
    }
   
}