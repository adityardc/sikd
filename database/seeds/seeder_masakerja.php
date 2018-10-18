<?php

use Illuminate\Database\Seeder;

class seeder_masakerja extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_masakerja')->insert([
            'nama_masakerja' => '< 3 TAHUN',
            'status_masakerja' => 'Y'
        ]);
    }
}
