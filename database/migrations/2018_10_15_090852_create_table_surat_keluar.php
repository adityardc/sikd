<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuratKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_surat_keluar', function (Blueprint $table) {
            $table->increments('id_surat_keluar');
            $table->integer('tipe_surat');
            $table->integer('id_bagian');
            $table->integer('id_klasifikasi');
            $table->string('nomor_surat', 100);
            $table->date('tanggal_surat');
            $table->integer('sifat_surat');
            $table->string('tujuan_surat', 100);
            $table->text('perihal_surat');
            $table->integer('id_pembuat');
            $table->integer('id_konseptor');
            $table->integer('id_hak_akses');
            $table->string('tindasan_surat', 50);
            $table->integer('status_agenda_sentral');
            $table->integer('status_agenda_dir');
            $table->integer('status_agenda_bagian');
            $table->text('file_surat');
            $table->date('tanggal_distribusi');
            $table->text('keterangan_distribusi');
            $table->text('tindasan_eks');
            $table->integer('jns_tujuan');
            $table->integer('status_disposisi_dir');
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
