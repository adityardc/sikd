<?php

use Illuminate\Database\Seeder;

class seeder_karyawan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_karyawan')->insert([
            'nama_karyawan' => 'ADMINISTRATOR',
            'tanggal_lahir' => '2014-4-1',
            'tanggal_karyawan' => '2014-4-1',
            'jenis_kelamin' => 1,
            'id_bagian' => 1,
            'id_jabatan' => 1,
            'id_golongan' => 1,
            'id_pendidikan' => 1,
            'status_karyawan' => 1,
            'status_konseptor' => 1,
            'email' => 'admin@ptpn9.co.id'
        ]);
    }
}
