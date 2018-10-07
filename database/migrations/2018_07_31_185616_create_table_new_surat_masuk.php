<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNewSuratMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_surat_masuk', function(Blueprint $table){
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
            $table->integer('id_tujuan_agenda_dir')->nullable();
            $table->integer('id_asal_agenda_dir')->nullable();
            $table->string('nomor_agenda_dir', 50)->nullable();
            $table->date('tanggal_agenda_dir')->nullable();
            $table->text('ket_agenda_dir')->nullable();
            $table->string('id_disposisi_dir', 50)->nullable();
            $table->string('id_disposisi_tujuan_dir', 100)->nullable();
            $table->text('uraian_disposisi_dir')->nullable();
            $table->date('tanggal_distribusi_disposisi_dir')->nullable();
            $table->text('file_surat')->nullable();
            $table->text('file_disposisi_dir')->nullable();
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
