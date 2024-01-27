<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article_id');

            $table->enum('rating_1', ['accepted', 'accepted with revision', 'declined'])->nullable();
            $table->unsignedBigInteger('reviewer_id_1')->nullable();
            $table->enum('rating_2', ['accepted', 'accepted with revision', 'declined'])->nullable();
            $table->unsignedBigInteger('reviewer_id_2')->nullable();
            $table->enum('rating_3', ['accepted', 'accepted with revision', 'declined'])->nullable();
            $table->unsignedBigInteger('reviewer_id_3')->nullable();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('reviewer_id_1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewer_id_2')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewer_id_3')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
