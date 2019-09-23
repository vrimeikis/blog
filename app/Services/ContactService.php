<?php

declare(strict_types = 1);

namespace App\Services;

use App\ContactMessage;
use App\Mail\ContactNotificationMail;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContactService
 * @package App\Services
 */
class ContactService
{
    /**
     * @param string $messageText
     * @param string $fromMail
     * @param string|null $toName
     */
    public function saveAndSendNotification(
        string $messageText,
        string $fromMail,
        ?string $toName = null
    ): void {
        $message = ContactMessage::query()->create([
            'name' => $toName,
            'email' => $fromMail,
            'message' => $messageText,
        ]);

        Mail::to('vytautas.rimeikis@gmail.com')
            ->send(new ContactNotificationMail($message));
    }
}