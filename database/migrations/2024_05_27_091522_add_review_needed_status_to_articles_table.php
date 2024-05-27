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
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'accepted',
                'accepted with revision',
                'declined',
                'review_needed' // Добавяме новия статус тук
            ])->default('review_needed')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'accepted',
                'accepted with revision',
                'declined'
            ])->default('pending')->change();
        });
    }
};
