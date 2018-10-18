<?php

use Illuminate\Database\Seeder;

class seeder_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ADMINISTRATOR',
            'email' => 'admin@ptpn9.co.id',
            'password' => bcrypt('ptpn9jaya'),
            'id_role' => 1,
            'id_karyawan' => 1,
            'id_bagian' => 1,
            'status_pengguna' => 'Y',
            'grup_bagian' => 1
        ]);
    }
}
