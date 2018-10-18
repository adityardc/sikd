<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTopKlasifikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_top_klasifikasi', function (Blueprint $table) {
            $table->increments('id_parent');
            $table->string('kode_parent', 10);
            $table->string('deskripsi_parent', 150);
            $table->string('status_top_klas', 1);
            $table->integer('id_bagian');
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
