<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRangeIkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('range_ikus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumInteger('awal');
            $table->mediumInteger('akhir');
            $table->decimal('nilai', 3, 2);
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
        Schema::dropIfExists('range_ikus');
    }
}
