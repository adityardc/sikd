<?php

use Illuminate\Database\Seeder;

class seeder_hakakses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_hakakses')->insert([
            'nama_hakakses' => 'ADMINISTRATOR',
            'status_hakakses' => 'Y'
        ]);
    }
}
