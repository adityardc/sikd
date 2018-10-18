<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuratMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_surat_masuk', function (Blueprint $table) {
            $table->increments('id_surat_masuk');
            $table->integer('id_klasifikasi');
            $table->string('nomor_surat', 50);
            $table->date('tanggal_surat');
            $table->text('nama_pengirim');
            $table->string('tujuan_surat', 100);
            $table->text('perihal_surat');
            $table->string('tindasan_surat', 100);
            $table->date('tanggal_agenda_sentral');
            $table->integer('nomor_agenda_sentral');
            $table->integer('status_agenda_dir');
            $table->text('file_surat');
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
