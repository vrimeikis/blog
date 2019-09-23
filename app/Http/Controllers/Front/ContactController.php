<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Front;

use App\Http\Requests\SendContactMessageRequest;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class ContactController
 * @package App\Http\Controllers\Front
 */
class ContactController extends Controller
{
    /**
     * @var ContactService
     */
    private $contactService;

    /**
     * ContactController constructor.
     * @param ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

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
        $this->contactService->saveAndSendNotification(
            $request->getMessage(),
            $request->getEmail(),
            $request->getName()
        );

        return redirect()->route('contact.us')
            ->with('status', 'Thanks for your request, we will replay as soon as possible!');
    }
}
