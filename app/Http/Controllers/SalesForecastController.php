<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualanModel;
use Illuminate\Http\Request;
use Phpml\Exception\MatrixException;
use Phpml\Regression\LeastSquares;

class SalesForecastController extends Controller
{
    //
    // public function forecast()
    // {
    //     // Ambil data penjualan dari database
    //     $penjualanDetails = DetailPenjualanModel::with('penjualan')->get();

    //     // Siapkan data untuk model
    //     $samples = [];
    //     $targets = [];
    //     foreach ($penjualanDetails as $detail) {
    //         $samples[] = [$detail->created_at]; // Asumsi kolom tanggal di tabel t_penjualan
    //         $targets[] = $detail->harga;
    //     }

    //     // Buat model regresi
    //     $regression = new LeastSquares();
    //     $regression->train($samples, $targets);

    //     // Prediksi penjualan untuk hari berikutnya
    //     $nextDayTimestamp = now()->addDay()->timestamp;
    //     $predictedSales = $regression->predict([[$nextDayTimestamp]]);

    //     return response()->json([
    //         'predicted_sales' => $predictedSales,
    //     ]);
    // }
    // public function forecast()
    // {
    //     // Ambil data penjualan dari database
    //     $penjualanDetails = DetailPenjualanModel::with('penjualan')
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     // Siapkan array untuk menyimpan prediksi per barang
    //     $predictedSalesPerBarang = [];

    //     // Loop melalui setiap barang
    //     foreach ($penjualanDetails as $detail) {
    //         $barang_id = $detail->barang_id;

    //         // Siapkan array untuk menyimpan jumlah penjualan per hari
    //         $dailySales = [];

    //         // Ambil jumlah penjualan per hari untuk barang ini
    //         foreach ($penjualanDetails as $penjualan) {
    //             if ($penjualan->barang_id == $barang_id) {
    //                 $dailySales[$penjualan->created_at->toDateString()] = $penjualan->jumlah;
    //             }
    //         }

    //         // Hitung rata-rata pergerakan (Moving Average) untuk 7 hari
    //         $movingAverage = collect($dailySales)->splice(-7)->avg();

    //         // Prediksi penjualan untuk 7 hari ke depan
    //         $predictedSalesPerBarang[$barang_id] = $movingAverage * 7;
    //     }

    //     return response()->json([
    //         'predicted_sales_per_barang' => $predictedSalesPerBarang,
    //     ]);
    // }
    // public function forecast()
    // {
    //     // Ambil data penjualan dari database
    //     $penjualanDetails = DetailPenjualanModel::with('penjualan')
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     // Siapkan array untuk menyimpan prediksi per barang
    //     $predictedSalesPerBarang = [];

    //     // Loop melalui setiap barang
    //     foreach ($penjualanDetails as $detail) {
    //         $barang_id = $detail->barang_id;

    //         // Siapkan array untuk menyimpan jumlah penjualan per hari
    //         $dailySales = [];

    //         // Ambil jumlah penjualan per hari untuk barang ini
    //         foreach ($penjualanDetails as $penjualan) {
    //             if ($penjualan->barang_id == $barang_id) {
    //                 $dailySales[$penjualan->created_at->toDateString()] = $penjualan->jumlah;
    //             }
    //         }

    //         // Hitung rata-rata pergerakan (Moving Average) untuk 7 hari
    //         $movingAverage = collect($dailySales)->splice(-7)->avg();

    //         // Prediksi penjualan untuk 7 hari ke depan
    //         $predictedSales = [];
    //         $nextDayTimestamp = now()->timestamp;

    //         for ($i = 0; $i < 7; $i++) {
    //             $predictedSales[$i] = $movingAverage;
    //             $nextDayTimestamp += 86400; // Menambahkan 1 hari dalam detik (86400 detik)
    //         }

    //         // Simpan prediksi per barang
    //         $predictedSalesPerBarang[$barang_id] = $predictedSales;
    //     }

    //     return response()->json([
    //         'predicted_sales_per_barang' => $predictedSalesPerBarang,
    //     ]);
    // }
    // public function forecast()
    // {
    //     // Ambil data penjualan dari database
    //     $penjualanDetails = DetailPenjualanModel::with('penjualan')
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     // Siapkan array untuk menyimpan prediksi per barang
    //     $predictedSalesPerBarang = [];

    //     // Loop melalui setiap barang
    //     foreach ($penjualanDetails as $detail) {
    //         $barang_id = $detail->barang_id;

    //         // Siapkan array untuk menyimpan jumlah penjualan per hari
    //         $dailySales = [];

    //         // Ambil jumlah penjualan per hari untuk barang ini
    //         foreach ($penjualanDetails as $penjualan) {
    //             if ($penjualan->barang_id == $barang_id) {
    //                 $dailySales[$penjualan->created_at->toDateString()] = $penjualan->jumlah;
    //             }
    //         }

    //         // Hitung prediksi penjualan untuk 7 hari ke depan
    //         $predictedSales = [];
    //         $lastSevenDays = array_slice($dailySales, -7, 7, true);

    //         foreach ($lastSevenDays as $date => $sales) {
    //             // Hitung rata-rata penjualan pada 6 hari sebelumnya
    //             $averageSales = array_sum(array_slice($lastSevenDays, 0, -1, true)) / 6;

    //             // Prediksi penjualan untuk hari ini berdasarkan rata-rata 6 hari sebelumnya
    //             $predictedSales[$date] = $averageSales;

    //             // Hapus data penjualan tertua dari array
    //             array_shift($lastSevenDays);
    //         }

    //         // Simpan prediksi per barang
    //         $predictedSalesPerBarang[$barang_id] = $predictedSales;
    //     }

    //     return response()->json([
    //         'predicted_sales_per_barang' => $predictedSalesPerBarang,
    //     ]);
    // }
    public function forecast()
    {
        // Ambil data penjualan dari database
        // Ambil data penjualan dari database
        $penjualanDetails = DetailPenjualanModel::with('penjualan')
            ->orderBy('created_at', 'asc')
            ->get();

        // Siapkan array untuk menyimpan prediksi per barang
        $predictedSalesPerBarang = [];

        // Loop melalui setiap barang
        foreach ($penjualanDetails as $detail) {
            $barang_id = $detail->barang_id;

            // Siapkan array untuk menyimpan jumlah penjualan per hari
            $dailySales = [];

            // Ambil jumlah penjualan per hari untuk barang ini
            foreach ($penjualanDetails as $penjualan) {
                if ($penjualan->barang_id == $barang_id) {
                    $dailySales[$penjualan->created_at->toDateString()] = $penjualan->jumlah;
                }
            }

            // Hitung prediksi penjualan untuk 7 hari ke depan
            $predictedSales = [];
            $startDate = now(); // Tanggal mulai dari hari ini

            for ($i = 0; $i < 7; $i++) {
                // Hitung rata-rata penjualan pada 6 hari sebelumnya
                $averageSales = array_sum(array_slice($dailySales, -6, 6, true)) / 6;

                // Prediksi penjualan untuk hari ini berdasarkan rata-rata 6 hari sebelumnya
                $predictedSales[$startDate->toDateString()] = round($averageSales,3);

                // Maju ke hari berikutnya
                $startDate->addDay();

                // Tambahkan penjualan hari ini ke data penjualan
                $dailySales[$startDate->toDateString()] = $averageSales;

                // $angka = 123.4567890123;
                // $predictedSales = number_format($predictedSales, 3);
            }

            // Simpan prediksi per barang
            $predictedSalesPerBarang[$barang_id] =  $predictedSales;
        }
        // dd($predictedSalesPerBarang);

        return $predictedSalesPerBarang;
    }
}
