<?php

declare(strict_types = 1);

namespace App\Events;

use App\ContactMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewContactRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ContactMessage
     */
    public $contactMessage;

    /**
     * Create a new event instance.
     *
     * @param ContactMessage $contactMessage
     */
    public function __construct(ContactMessage $contactMessage) {
        $this->contactMessage = $contactMessage;
    }
}
