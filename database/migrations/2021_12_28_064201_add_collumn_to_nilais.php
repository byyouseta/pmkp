<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnToNilais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilais', function (Blueprint $table) {
            // $table->smallInteger('nilai')->nullable()->change();
            $table->integer('nilai_n')->after('nilai')->nullable();
            $table->integer('nilai_d')->after('nilai_n')->nullable();
            $table->string('file', 20)->after('nilai_d')->nullable();
            $table->boolean('lock')->after('file')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn('nilai_n', 'nilai_d', 'file', 'lock');
        });
    }
}
