<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agent_conversations', function (Blueprint $table) {
            $table->foreignId('generated_post_id')
                ->nullable()
                ->constrained('generated_posts')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('agent_conversations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('generated_post_id');
        });
    }
};
