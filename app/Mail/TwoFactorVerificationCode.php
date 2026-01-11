<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Mail;

use App\Models\Identity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

	public string $summary = 'Here is the 6-digit code you need to sign in.';

    /**
     * Create a new message instance.
     */
    public function __construct(public User $receiver, public string $code)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Two-Factor Verification'),
			tags: ['two-factor-code'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.' . app()->getLocale() . '.two-factor-verification-code',
        );
    }
}