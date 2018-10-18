<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	bagian_seeder::class,
        	seeder_golongan::class,
        	seeder_hakakses::class,
        	seeder_jabatan::class,
        	seeder_karyawan::class,
        	seeder_masakerja::class,
        	seeder_pendidikan::class,
        	seeder_user::class
        ]);
    }
}
