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
        Schema::create('reviews_coment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained();
			$table->foreignId('user_id')->constrained();
            $table->string('rating');
            $table->text('review_questions');
            $table->longText('review_comments');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews_coment');
    }
};
