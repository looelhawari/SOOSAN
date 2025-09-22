<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class AutoReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName;
    public $senderEmail;
    public $originalSubject;

    /**
     * Create a new message instance.
     */
    public function __construct($senderName, $senderEmail, $originalSubject)
    {
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
        $this->originalSubject = $originalSubject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you for contacting SOOSAN Egypt - We received your message',
            replyTo: [
                'support@soosanegypt.com',
            ],
            tags: ['contact-form', 'auto-reply'],
            metadata: [
                'type' => 'customer-service',
                'priority' => 'normal',
            ],
        );
    }

    /**
     * Get the message headers.
     */
    public function headers(): Headers
    {
        return new Headers(
            messageId: null,
            references: [],
            text: [
                'X-Auto-Response-Suppress' => 'OOF, DR, RN, NRN, AutoReply',
                'X-Mailer' => 'SOOSAN Egypt Customer Service System',
                'X-Priority' => '3',
                'X-MSMail-Priority' => 'Normal',
                'X-Entity-Type' => 'customer-service',
                'Precedence' => 'list',
                'Auto-Submitted' => 'auto-replied',
                'X-Report-Abuse' => 'Please report abuse to: support@soosanegypt.com',
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.auto-reply',
            with: [
                'senderName' => $this->senderName,
                'senderEmail' => $this->senderEmail,
                'originalSubject' => $this->originalSubject,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}