<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnAgainToDetailIndikators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_indikators', function (Blueprint $table) {
            $table->Integer('sub_kategori_id')->after('kategori_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_indikators', function (Blueprint $table) {
            $table->dropColumn('sub_indikator_id');
        });
    }
}
