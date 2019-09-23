<?php

declare(strict_types = 1);

namespace App\Mail;

use App\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var ContactMessage
     */
    public $details;

    /**
     * Create a new message instance.
     *
     * @param ContactMessage $details
     */
    public function __construct(ContactMessage $details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.contact_notification')
            ->subject('New contact message');
    }
}
