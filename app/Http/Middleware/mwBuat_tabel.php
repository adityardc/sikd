<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Closure;

class mwBuat_tabel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tahun = date('Y');
        if(Schema::hasTable('tbl_agenda_dir_'.$tahun)){
            return $next($request);
        }else{
            Schema::create('tbl_agenda_dir_'.$tahun, function(Blueprint $table){
                $table->increments('id_agenda_dir');
                $table->integer('id_jenis_surat');
                $table->integer('id_tujuan');
                $table->date('tanggal_agenda');
                $table->integer('nomor_urut');
                $table->string('nomor_agenda', 20);
                $table->string('nomor_surat', 100);
                $table->date('tanggal_surat');
                $table->string('pengirim', 150);
                $table->integer('sifat_surat');
                $table->string('perihal', 150);
                $table->timestamps();
            });
            return $next($request);
        }
    }
}
