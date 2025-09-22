<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\AutoReplyMail;

class ContactController extends Controller
{
    /**
     * Store a new contact message from the form.
     */
    public function store(Request $request)
    {
        Log::info('Contact form submission received', ['ip' => $request->ip()]);
        
        // Rate limiting: 20 attempts per hour per IP (increased for testing)
        $key = 'contact_form_' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 20)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);
            
            throw ValidationException::withMessages([
                'rate_limit' => __('Too many contact attempts. Please try again in :minutes minutes.', ['minutes' => $minutes])
            ]);
        }

        // Honeypot protection
        if ($request->filled('website')) {
            // This is likely a bot, silently reject
            return redirect()->back()->with('success', __('common.contact_success'));
        }

        // Debug reCAPTCHA before validation
        $recaptchaResponse = $request->input('g-recaptcha-response');
        
        // Manual reCAPTCHA validation
        if (!empty($recaptchaResponse)) {
            // Create NoCaptcha instance directly
            $nocaptcha = new \Anhskohbo\NoCaptcha\NoCaptcha(
                config('captcha.secret'),
                config('captcha.sitekey')
            );
            
            $recaptchaValid = $nocaptcha->verifyResponse($recaptchaResponse, $request->ip());
            
            if (!$recaptchaValid) {
                return redirect()->back()
                    ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.'])
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->withErrors(['g-recaptcha-response' => 'Please complete the reCAPTCHA verification.'])
                ->withInput();
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'newsletter' => 'sometimes|boolean',
        ]);

        // Count this attempt for rate limiting
        RateLimiter::hit($key, 3600); // 1 hour

        // Set newsletter to false if not provided
        $validated['newsletter'] = $request->has('newsletter');

        // Create the contact message
        \App\Models\ContactMessage::create($validated);

        // Send instant auto-reply to the customer
        try {
            $fullName = $validated['first_name'] . ' ' . $validated['last_name'];
            Mail::to($validated['email'])->send(new AutoReplyMail(
                $fullName, 
                $validated['email'], 
                $validated['subject']
            ));
            
            Log::info('Auto-reply sent successfully', [
                'email' => $validated['email'],
                'name' => $fullName
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send auto-reply', [
                'email' => $validated['email'],
                'error' => $e->getMessage()
            ]);
            // Don't break the form submission if auto-reply fails
        }

        // Send notification to admin email
        try {
            $adminEmail = 'support@soosanegypt.com';
            $fullName = $validated['first_name'] . ' ' . $validated['last_name'];
            
            Mail::raw(
                "New Contact Form Message Received\n\n" .
                "Name: {$fullName}\n" .
                "Email: {$validated['email']}\n" .
                "Company: " . ($validated['company'] ?: 'Not specified') . "\n" .
                "Phone: " . ($validated['phone'] ?: 'Not specified') . "\n" .
                "Subject: {$validated['subject']}\n" .
                "Newsletter: " . ($validated['newsletter'] ? 'Yes' : 'No') . "\n\n" .
                "Message:\n{$validated['message']}\n\n" .
                "---\n" .
                "This message was sent from the contact form on soosanegypt.com",
                function ($message) use ($validated, $fullName, $adminEmail) {
                    $message->to($adminEmail)
                           ->subject("New Contact Message: {$validated['subject']}")
                           ->replyTo($validated['email'], $fullName);
                }
            );
            
            Log::info('Admin notification sent successfully', [
                'admin_email' => $adminEmail,
                'customer_email' => $validated['email'],
                'subject' => $validated['subject']
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification', [
                'admin_email' => $adminEmail,
                'customer_email' => $validated['email'],
                'error' => $e->getMessage()
            ]);
            // Don't break the form submission if admin notification fails
        }

        // Log successful contact form submission
        Log::info('Contact form submitted successfully', [
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', __('common.contact_success'));
    }
}
