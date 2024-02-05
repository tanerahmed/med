<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('authors', function (Blueprint $table) {
            // Добавяне на полето "approved" към таблицата "authors"
            $table->boolean('approved')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors', function (Blueprint $table) {
            // Премахване на полето "approved" от таблицата "authors"
            $table->dropColumn('approved');
        });
    }
};
