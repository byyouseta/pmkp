<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnToDetailIndikators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_indikators', function (Blueprint $table) {
            $table->string('do')->after('nama')->nullable();
            $table->string('pengumpulan', 20)->after('do');
            $table->string('pelaporan', 20)->after('pengumpulan');
            $table->string('numerator', 100)->after('pelaporan')->nullable();
            $table->string('denumerator', 100)->after('numerator')->nullable();
            $table->string('sumberdata', 100)->after('denumerator')->nullable();
            $table->integer('user_id')->after('kategori_id');
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
            $table->dropColumn('do', 'pengumpulan', 'pelaporan', 'numerator', 'denumerator', 'sumberdata', 'user_id');
        });
    }
}
