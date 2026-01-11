<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace App\Models\Records;

use Illuminate\Database\Eloquent\Model;

class MailingRecord extends Model
{
	protected $table = 'email_history';

	protected $fillable = [
		'recipient',
		'subject'
	];
}