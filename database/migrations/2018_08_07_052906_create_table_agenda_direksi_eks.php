<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgendaDireksiEks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agenda_direksi_eks', function(Blueprint $table){
            $table->increments('id_agenda_direksi_eks');
            $table->integer('id_surat_masuk');
            $table->string('nomor_agenda', 20);
            $table->date('tanggal_agenda');
            $table->text('keterangan_agenda');
            $table->integer('jenis_agenda');
            $table->integer('tujuan_direksi_agenda');
            $table->string('tujuan_bagian_agenda', 100)->nullable();
            $table->string('disposisi_direksi', 100)->nullable();
            $table->text('uraian_disposisi')->nullable();
            $table->text('file_disposisi')->nullable();
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
