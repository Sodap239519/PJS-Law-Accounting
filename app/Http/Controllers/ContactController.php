<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'details' => 'required|string',
        ]);

        try {
            $contact = Contact::create($validated);

            $this->sendNotificationEmail($contact);

            return redirect()->back()->with('success', __('common.contact_form.success'));
        } catch (\Exception $e) {
            Log::error('Contact form submission failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', __('common.contact_form.error'))
                ->withInput();
        }
    }

    private function sendNotificationEmail(Contact $contact): void
    {
        try {
            Mail::send('emails.contact-notification', ['contact' => $contact], function ($message) use ($contact) {
                $message->to('Nn.piyarat2410@gmail.com')
                    ->subject('New Contact Form Submission - ' . $contact->subject);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }
    }
}
