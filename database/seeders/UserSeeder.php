<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate();
        
        $data = [
            [
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
            ],
        ];

        foreach ($data as $key => $value) {
            DB::table('users')->insert([
                'nama' => $value['nama'],
                'jabatan' => $value['jabatan'],
                'nip' => $value['nip'],
                'status' => $value['status'],
                'username' => $value['username'],
                'password' => Hash::make($value['password']),
                'alamat' => $value['alamat'],
                'lampiran' => $value['lampiran'],
            ]);
        }
    }
}
