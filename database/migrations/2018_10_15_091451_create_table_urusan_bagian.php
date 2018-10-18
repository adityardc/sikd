<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUrusanBagian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_urusan_bagian', function (Blueprint $table) {
            $table->increments('id_urusan_bagian');
            $table->integer('id_bagian');
            $table->string('nama_urusan_bagian', 150);
            $table->string('status_urusan_bagian', 1);
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
        //
    }
}
