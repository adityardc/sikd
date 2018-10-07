<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;
use Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => $detailKaryawan->nama_karyawan,
            'email' => $detailKaryawan->email,
            'password' => Hash::make("ptpn9jaya"),
            'id_role' => $request->role,
            'id_karyawan' => $request->karyawan,
            'id_bagian' => $detailKaryawan->id_bagian,
            'status_pengguna' => $request->status_pengguna,
            'grup_bagian' => $detailKaryawan->grup_bagian,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
