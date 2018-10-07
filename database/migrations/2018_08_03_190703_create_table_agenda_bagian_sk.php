<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgendaBagianSk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_agenda_bagian_sk', function(Blueprint $table){
            $table->increments('id_agenda_bagian_sk');
            $table->integer('id_bagian');
            $table->string('nomor_agenda_bagian', 50)->nullable();
            $table->date('tanggal_agenda_bagian')->nullable();
            $table->string('id_disposisi_bagian', 50)->nullable();
            $table->string('id_disposisi_tujuan_bagian', 15)->nullable();
            $table->text('uraian_disposisi_bagian')->nullable();
            $table->text('file_disposisi_bagian')->nullable();
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
