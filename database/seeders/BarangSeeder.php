<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data=[
            ['barang_id'=>1, 'kategori_id'=>1, 'barang_kode'=>'br1', 'barang_nama'=>'Nasi Goreng', 'harga_beli'=>10000, 'harga_jual'=>13000],
            ['barang_id'=>2, 'kategori_id'=>1, 'barang_kode'=>'br2', 'barang_nama'=>'Mie Goreng', 'harga_beli'=>10000, 'harga_jual'=>13000],
            ['barang_id'=>3, 'kategori_id'=>2, 'barang_kode'=>'br3', 'barang_nama'=>'Skincare Ms Glow', 'harga_beli'=>100000, 'harga_jual'=>120000],
            ['barang_id'=>4, 'kategori_id'=>2, 'barang_kode'=>'br4', 'barang_nama'=>'Skincare The Originote', 'harga_beli'=>50000, 'harga_jual'=>100000],
            ['barang_id'=>5, 'kategori_id'=>3, 'barang_kode'=>'br5', 'barang_nama'=>'Sapu Kinclonk', 'harga_beli'=>25000, 'harga_jual'=>40000],
            ['barang_id'=>6, 'kategori_id'=>3, 'barang_kode'=>'br6', 'barang_nama'=>'Pel Super Licin', 'harga_beli'=>35000, 'harga_jual'=>50000],
            ['barang_id'=>7, 'kategori_id'=>4, 'barang_kode'=>'br7', 'barang_nama'=>'Minyak Telon Caplang', 'harga_beli'=>30000, 'harga_jual'=>50000],
            ['barang_id'=>8, 'kategori_id'=>4, 'barang_kode'=>'br8', 'barang_nama'=>'Bedak My Baby', 'harga_beli'=>40000, 'harga_jual'=>70000],
            ['barang_id'=>9, 'kategori_id'=>5, 'barang_kode'=>'br9', 'barang_nama'=>'Gatsby Pomade', 'harga_beli'=>50000, 'harga_jual'=>100000],
            ['barang_id'=>10, 'kategori_id'=>5, 'barang_kode'=>'br10', 'barang_nama'=>'Minyak Rambut Kelapa Sawit', 'harga_beli'=>70000, 'harga_jual'=>120000],
        ];
        DB::table('m_barang')->insert($data);
    }
}
