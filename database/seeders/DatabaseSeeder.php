<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('11221122'),
            'role' => 'Admin',
        ]);

        $kategoriData = [
            ['nama' => 'Makanan', 'jenis' => 'Menu'],
            ['nama' => 'Minuman', 'jenis' => 'Menu'],
            ['nama' => 'Tiket', 'jenis' => 'Menu'],
            ['nama' => 'Bahan baku utama', 'jenis' => 'Barang'],
            ['nama' => 'Bahan baku tambahan', 'jenis' => 'Barang'],
            ['nama' => 'Bumbu Dapur', 'jenis' => 'Barang'],
            ['nama' => 'Lain-lain', 'jenis' => 'Barang'],
        ];

        DB::table('kategoris')->insert($kategoriData);

        $unitData = [
            ['nama' => 'Buah'],
            ['nama' => 'Set'],
            ['nama' => 'Box'],
            ['nama' => 'Pcs'],
            ['nama' => 'Botol'],
            ['nama' => 'Unit'],
        ];

        DB::table('units')->insert($unitData);
    }
}