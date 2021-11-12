<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumnToTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('alamat')->after('email')->nullable();
            $table->string('nohp', 20)->after('alamat')->unique()->nullable();
            $table->integer('unit_id')->after('name')->nullable();
            $table->integer('username')->after('unit_id')->nullable();
            $table->smallInteger('akses')->after('nohp')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('alamat', 'nohp', 'akses', 'username', 'unit_id');
            $table->dropSoftDeletes();
        });
    }
}
