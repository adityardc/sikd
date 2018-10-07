<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDisposisiBagian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_jenis_disposisi_bagian', function(Blueprint $table){
            $table->increments('id_jenis_disposisi_bagian');
            $table->integer('id_bagian');
            $table->string('nama_disposisi_bagian', 150);
            $table->string('status_disposisi_bagian', 1);
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
