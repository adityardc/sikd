<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKlasifikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_klasifikasi', function (Blueprint $table) {
            $table->increments('id_klas');
            $table->integer('id_top_klas');
            $table->string('kode_klas', 10);
            $table->text('nama_klas');
            $table->string('status_klas', 1);
            $table->integer('id_retensi_aktif');
            $table->integer('id_retensi_inaktif');
            $table->integer('id_retensi_ket');
            $table->integer('id_level');
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
