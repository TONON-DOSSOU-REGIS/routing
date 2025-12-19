<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactConfirmationMail;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function create()
    {
        return view('support.nous-contacter');
    }

    public function store(ContactRequest $request)
    {
        // Validate and get validated data
        $data = $request->validated();

        Log::info('Contact form validated data:', $data);

        // Convert privacy_accepted value to boolean integer for DB
        $data['privacy_accepted'] = $request->has('privacy_accepted') ? 1 : 0;

        // Define a time window for duplicate submissions (e.g. last 1 day)
        $duplicateTimeWindow = Carbon::now()->subDay();

        // Normalize email input for consistent comparison
        $email = strtolower(trim($data['email']));
        $data['email'] = $email;

        // Normalize message input if exists
        if (isset($data['message'])) {
            $data['message'] = trim($data['message']);
        }

        // Additional logging for debugging
        Log::info('Checking for duplicates with normalized email ' . $email . ' since ' . $duplicateTimeWindow->toDateTimeString());

        // Broaden duplicate detection by matching email and message content if available
        $query = Contact::where('email', $email)
            ->where('created_at', '>=', $duplicateTimeWindow);

        if (isset($data['message'])) {
            $query->where('message', $data['message']);
        }

        // Log latest contacts by this email before check
        $latestContacts = Contact::where('email', $email)->orderBy('created_at', 'desc')->limit(3)->get();
        Log::info('Latest contacts for email ' . $email . ':', $latestContacts->toArray());

        $duplicateExists = $query->exists();

        Log::info('Duplicate check result: ' . ($duplicateExists ? 'found duplicate' : 'no duplicate'));

        if ($duplicateExists) {
            // Resend confirmation mail for existing contact matching email and message
            $existingContact = Contact::where('email', $email)
                ->orderBy('created_at', 'desc')
                ->lockForUpdate()
                ->first();

            if ($existingContact) {
                Mail::to($existingContact->email)->send(new ContactConfirmationMail($existingContact));
                Log::info('Duplicate contact submission detected, resent confirmation mail to:', ['email' => $existingContact->email]);
            }

            // Redirect to thank you page without creating a new record
            return redirect()->route('support.nous-contacter.thankyou', ['locale' => app()->getLocale()])
                ->with('status', 'Votre demande a déjà été enregistrée. Un email de confirmation vous a été envoyé.');
        }

        // Save new contact to database
        $contact = Contact::create($data);

        Log::info('Contact saved to DB:', $contact->toArray());

        // Send confirmation mail for new contact
        Mail::to($contact->email)->send(new ContactConfirmationMail($contact));

        Log::info('Confirmation mail sent to:', ['email' => $contact->email]);

        // Redirect to thank you page
        return redirect()->route('support.nous-contacter.thankyou', ['locale' => app()->getLocale()]);
    }

    public function thankYou()
    {
        return view('support.contact_thank_you');
    }
}

