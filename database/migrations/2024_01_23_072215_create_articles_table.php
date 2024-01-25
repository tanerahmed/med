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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['original article', 'review', 'letter to the editor', 'case of the month/how do I do it']);
            $table->string('specialty');
            $table->string('scientific_area')->nullable();
            $table->text('title');
            $table->text('abstract');
            $table->string('keywords', 500);
            $table->string('funding_name')->nullable();
            $table->string('grant_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
