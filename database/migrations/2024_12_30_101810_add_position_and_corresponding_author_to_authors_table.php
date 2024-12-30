<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->integer('position')->nullable(); // Поле за позицията
            $table->boolean('is_corresponding_author')->default(false); // Чекбокс за кореспондиращ автор
        });
    }

    public function down()
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn(['position', 'is_corresponding_author']);
        });
    }


};
