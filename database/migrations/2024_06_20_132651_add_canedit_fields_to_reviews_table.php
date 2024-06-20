<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('reviewer_id_1_canedit')->default(true)->after('reviewer_id_1');
            $table->boolean('reviewer_id_2_canedit')->default(true)->after('reviewer_id_2');
            $table->boolean('reviewer_id_3_canedit')->default(true)->after('reviewer_id_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('reviewer_id_1_canedit');
            $table->dropColumn('reviewer_id_2_canedit');
            $table->dropColumn('reviewer_id_3_canedit');
        });
    }
};
