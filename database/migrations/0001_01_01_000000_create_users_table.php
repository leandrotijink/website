<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('username', 70)->unique();
			$table->string('nickname', 50);
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('locale_id')->nullable();
			$table->rememberToken();
			$table->timestamp('active_at')->nullable();
            $table->timestamps();
        });
		
		Schema::create('user_meta', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('type', 20)->default('string');
			$table->string('name', 50);
			$table->text('value');
			$table->timestamps();
		});

		Schema::create('user_suspensions', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('code', 20);
			$table->string('reason', 200);
			$table->timestamp('expires_at')->nullable();
			$table->timestamps();
		});

		Schema::create('user_tokens', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('client', 200);
			$table->string('hash', 100);
			$table->boolean('is_used')->default(false);
			$table->timestamp('expires_at')->nullable();
			$table->timestamps();
		});

		Schema::create('user_guards', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('type', 20);
			$table->text('content')->nullable();
			$table->boolean('is_encrypted')->default(false);
			$table->boolean('is_preferred')->default(false);
			$table->timestamps();
		});

		Schema::create('user_activity', function (Blueprint $table) {
			$table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->string('type', 50);
			$table->string('ip_address', 45)->nullable();
			$table->json('context')->nullable();
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('user_activity');
		Schema::dropIfExists('user_guards');
		Schema::dropIfExists('user_tokens');
		Schema::dropIfExists('user_suspensions');
		Schema::dropIfExists('user_meta');
		Schema::dropIfExists('users');
    }
};