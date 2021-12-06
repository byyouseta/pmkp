<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLokalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lokals', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('nama');
            $table->integer('tahun_id');
            $table->integer('unit_id');
            $table->integer('user_id');
            $table->string('keterangan')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('catatan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lokals');
    }
}
