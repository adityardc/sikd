<?php

use Illuminate\Database\Seeder;

class seeder_pendidikan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_pendidikan')->insert([
            'nama_pendidikan' => 'SD',
            'status_pendidikan' => 'Y'
        ]);
    }
}
