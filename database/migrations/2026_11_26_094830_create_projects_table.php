<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tagline');
            $table->text('description');
            $table->text('challenge');
            $table->text('solution');
            $table->json('tags');
            $table->json('categories');
            $table->string('status');
            $table->string('visibility');
            $table->string('image');
            $table->string('logo');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};
