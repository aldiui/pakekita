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
        $userData = [
            [
                'nama' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('11221122'),
                'role' => 'admin',
            ],
            [
                'nama' => 'kasir',
                'email' => 'kasir@gmail.com',
                'password' => bcrypt('11221122'),
                'role' => 'kasir',
            ],
        ];

        DB::table('users')->insert($userData);

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
            ['nama' => 'Kg'],
        ];

        DB::table('units')->insert($unitData);

        $menuData = [
            ['nama' => 'Nasi Goreng', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '10000'],
            ['nama' => 'Ayam Goreng', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '12000'],
            ['nama' => 'Mie Goreng', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '11000'],
            ['nama' => 'Sate Ayam', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '15000'],
            ['nama' => 'Bakso', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '13000'],
            ['nama' => 'Soto Ayam', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '14000'],
            ['nama' => 'Nasi Kuning', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '12000'],
            ['nama' => 'Rendang', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '20000'],
            ['nama' => 'Gado-Gado', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '15000'],
            ['nama' => 'Capcay', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '13000'],
            ['nama' => 'Ikan Bakar', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '18000'],
            ['nama' => 'Sayur Asem', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '12000'],
            ['nama' => 'Rawon', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '16000'],
            ['nama' => 'Sambal Goreng', 'kategori_id' => '1', 'image' => 'makanan.webp', 'harga' => '17000'],
            ['nama' => 'Es Teh Manis', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '5000'],
            ['nama' => 'Es Jeruk', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '6000'],
            ['nama' => 'Es Campur', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '8000'],
            ['nama' => 'Es Cincau', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '7000'],
            ['nama' => 'Es Doger', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '10000'],
            ['nama' => 'Es Buah', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '12000'],
            ['nama' => 'Es Teler', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '11000'],
            ['nama' => 'Es Kelapa Muda', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '9000'],
            ['nama' => 'Es Kopyor', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '15000'],
            ['nama' => 'Es Campina', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '13000'],
            ['nama' => 'Es Blewah', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '8000'],
            ['nama' => 'Es Kacang Hijau', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '7000'],
            ['nama' => 'Es Selendang Mayang', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '10000'],
            ['nama' => 'Es Degan', 'kategori_id' => '2', 'image' => 'minuman.webp', 'harga' => '6000'],
        ];

        DB::table('menus')->insert($menuData);

        $pembayaranData = [
            ['nama' => 'OVO', 'jenis' => 'E-Wallet', 'no_rekening' => '08'],
            ['nama' => 'GOPAY', 'jenis' => 'E-Wallet', 'no_rekening' => '08'],
            ['nama' => 'DANA', 'jenis' => 'E-Wallet', 'no_rekening' => '08'],
        ];

        DB::table('pembayarans')->insert($pembayaranData);
    }
}
