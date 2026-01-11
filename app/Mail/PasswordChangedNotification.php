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

class PasswordChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

	public string $summary = 'The password of your account has just been changed.';

    /**
     * Create a new message instance.
     */
    public function __construct(public User $receiver)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Password changed'),
			tags: ['password-changed'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.' . app()->getLocale() . '.password-changed-notification',
        );
    }
}