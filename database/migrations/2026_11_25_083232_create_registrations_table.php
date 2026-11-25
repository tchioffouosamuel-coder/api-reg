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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->enum('type', ['event', 'formation']);
            $table->string('reference_slug');
            $table->string('reference_label');
            $table->string('nom');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->string('participant_type')->nullable();
            $table->string('amount_label')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'cancelled'])->default('pending');
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('attestation_generated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
