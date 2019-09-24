<?php

declare(strict_types = 1);

namespace App\Services;

use App\ContactMessage;
use App\Mail\ContactNotificationMail;
use App\Repositories\ContactMessageRepository;
use Illuminate\Support\Facades\Mail;

/**
 * Class ContactService
 * @package App\Services
 */
class ContactService
{
    /**
     * @var ContactMessageRepository
     */
    private $contactMessageRepository;

    /**
     * ContactService constructor.
     * @param ContactMessageRepository $contactMessageRepository
     */
    public function __construct(ContactMessageRepository $contactMessageRepository)
    {
        $this->contactMessageRepository = $contactMessageRepository;
    }


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
        /** @var ContactMessage $message */
        $message = $this->contactMessageRepository->create([
            'name' => $toName,
            'email' => $fromMail,
            'message' => $messageText,
        ]);

        Mail::to('vytautas.rimeikis@gmail.com')
            ->send(new ContactNotificationMail($message));
    }
}