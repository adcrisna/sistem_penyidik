<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Penyidik',
            'jabatan' => 'Penyidik',
            'nip' => '1404569',
            'status' => 'Aktif',
            'username' => 'penyidik',
            'password' => bcrypt('password'),
            'alamat' => 'alamat',
            'lampiran' => 'lampiran',
        ],
        [
            'nama' => 'Agung',
            'jabatan' => 'Petugas',
            'nip' => '1404568',
            'status' => 'Aktif',
            'username' => 'petugas',
            'password' => 'password',
            'alamat' => 'alamat',
            'lampiran' => 'lampiran',
        ]
    );
    }
}
