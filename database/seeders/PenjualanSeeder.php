<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 3, 'penjualan_kode' => 'sell1', 'pembeli' => 'cus1', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 2, 'user_id' => 3, 'penjualan_kode' => 'sell2', 'pembeli' => 'cus2', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 3, 'user_id' => 3, 'penjualan_kode' => 'sell3', 'pembeli' => 'cus3', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 4, 'user_id' => 3, 'penjualan_kode' => 'sell4', 'pembeli' => 'cus4', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 5, 'user_id' => 3, 'penjualan_kode' => 'sell5', 'pembeli' => 'cus5', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 6, 'user_id' => 3, 'penjualan_kode' => 'sell6', 'pembeli' => 'cus6', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 7, 'user_id' => 3, 'penjualan_kode' => 'sell7', 'pembeli' => 'cus7', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 8, 'user_id' => 3, 'penjualan_kode' => 'sell8', 'pembeli' => 'cus8', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 9, 'user_id' => 3, 'penjualan_kode' => 'sell9', 'pembeli' => 'cus9', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
            ['penjualan_id' => 10, 'user_id' => 3, 'penjualan_kode' => 'sell10', 'pembeli' => 'cus10', 'penjualan_tanggal' => '2024-03-02 21:00:00'],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
