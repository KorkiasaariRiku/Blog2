<?php 
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    // Traits used by this event class for various functionalities.
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // The user instance associated with this event.
    public $user;

    // Constructor for initializing the event with a user instance.
    public function __construct($user)
    {
        $this->user = $user;
    }

    // Define the channels on which the event should be broadcast.
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
