<?php

declare(strict_types = 1);

namespace App\Listeners;

use App\Events\NewContactRequestEvent;
use App\Mail\ContactNotificationMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewContactRequestNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param NewContactRequestEvent $event
     *
     * @return void
     */
    public function handle(NewContactRequestEvent $event) {
        Mail::to('vytautas.rimeikis@gmail.com')
            ->send(new ContactNotificationMail($event->contactMessage));
    }
}
