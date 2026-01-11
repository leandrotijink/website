<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Listeners;

use App\Models\Records\MailingRecord;
use Illuminate\Mail\Events\MessageSent;

class SaveDispatchedMailable
{
    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
		$mail = $event->message;

		$record = new MailingRecord([
			'recipient' => $mail->getTo()[0]->getAddress(),
			'subject' => $mail->getSubject()
		]);

		$record->save();
    }
}