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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle');
            $table->date('date');
            $table->time('time');
            $table->string('location');
            $table->text('description');
            $table->string('poster');
            $table->string('video')->nullable();
            $table->json('themes');
            $table->json('pricing');
            $table->json('phones');
            $table->enum('status', ['a-venir', 'passe'])->default('a-venir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
