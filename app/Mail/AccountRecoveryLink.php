<?php

namespace App\Mail;

use App\Models\Identity\Token;
use App\Models\Identity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountRecoveryLink extends Mailable
{
    use Queueable, SerializesModels;

	public string $summary = 'Here is the link you need in order to change your password.';

	public string $url;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $receiver, Token $token)
    {
        $this->url = route('auth.recovery.token', ['token' => $token->hash]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Account Recovery'),
			tags: ['account-recovery'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.' . app()->getLocale() . '.account-recovery-link',
        );
    }
}