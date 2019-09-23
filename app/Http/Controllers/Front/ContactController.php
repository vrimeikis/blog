<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Front;

use App\ContactMessage;
use App\Http\Requests\SendContactMessageRequest;
use App\Mail\ContactNotificationMail;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

/**
 * Class ContactController
 * @package App\Http\Controllers\Front
 */
class ContactController extends Controller
{
    /**
     * @return View
     */
    public function __invoke(): View
    {
        return view('front.contact_us');
    }

    /**
     * @param SendContactMessageRequest $request
     * @return RedirectResponse
     */
    public function sendEmail(SendContactMessageRequest $request): RedirectResponse
    {
        $message = ContactMessage::query()->create([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'message' => $request->getMessage(),
        ]);

        Mail::to('vytautas.rimeikis@gmail.com')
            ->send(new ContactNotificationMail($message));

        return redirect()->route('contact.us')
            ->with('status', 'Thanks for your request, we will replay as soon as possible!');
    }
}
