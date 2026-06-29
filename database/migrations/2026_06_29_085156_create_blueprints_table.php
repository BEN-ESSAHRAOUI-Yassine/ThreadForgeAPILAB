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
        Schema::create('blueprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('rules')->nullable();
            $table->string('target_audience')->nullable();
            $table->string('tone')->nullable();
            $table->integer('max_hashtags')->nullable();
            $table->integer('max_caracteres')->nullable();
            $table->boolean('allow_emojis')->default(true);
            $table->json('forbidden_words')->nullable();
            $table->text('regles_supplementaires')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blueprints');
    }
};
