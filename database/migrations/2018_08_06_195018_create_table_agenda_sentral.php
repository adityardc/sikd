<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgendaSentral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agenda_sentral', function(Blueprint $table){
            $table->increments('id_agenda_sentral');
            $table->integer('id_surat_keluar');
            $table->integer('id_bagian');
            $table->integer('nomor_agenda_sentral');
            $table->date('tanggal_agenda_sentral');
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
