<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeReviewCommentsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('reviews_coment', function (Blueprint $table) {
            $table->longText('review_comments')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('reviews_coment', function (Blueprint $table) {
            $table->longText('review_comments')->nullable(false)->change();
        });
    }
}
