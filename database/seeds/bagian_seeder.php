<?php

use Illuminate\Database\Seeder;

class bagian_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_bagian')->insert([
            'nama_bagian' => 'DIREKTUR UTAMA',
            'kode_bagian' => 'D.U',
            'tindasan' => 1,
            'grup_bagian' => 0,
            'status_bagian' => 'Y'
        ]);
    }
}
