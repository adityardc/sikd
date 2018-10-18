<?php

use Illuminate\Database\Seeder;

class seeder_golongan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_golongan')->insert([
            'nama_golongan' => 'DIREKSI',
            'status_golongan' => 'Y'
        ]);
    }
}
