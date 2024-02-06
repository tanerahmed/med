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
        Schema::table('invited_reviewers', function (Blueprint $table) {
            $table->boolean('rejected')->default(false)->after('article_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invited_reviewers', function (Blueprint $table) {
            $table->dropColumn('rejected');
        });
    }
};
