<?php

use Illuminate\Database\Seeder;

class seeder_jabatan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_jabatan')->insert([
            'nama_jabatan' => 'DIREKTUR UTAMA',
            'status_jabatan' => 'Y'
        ]);
    }
}
