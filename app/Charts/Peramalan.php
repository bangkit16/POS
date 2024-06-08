<?php

namespace App\Charts;

use App\Http\Controllers\SalesForecastController;
use App\Models\BarangModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Peramalan extends SalesForecastController
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $sales = SalesForecastController::forecast();
        
        $lineChart = $this->chart->lineChart()
            ->setTitle('Peramalan 7 hari kedepan')
            ->setSubtitle('peramalan per barang')
            ->setXAxis(['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'])
            ;

        foreach ($sales as $barang_id => $predictedSales) {
            $barang_nama = BarangModel::select('barang_nama')->where('barang_id', $barang_id)->first()->barang_nama;
            $lineChart->addData($barang_nama, array_values($predictedSales));
        }

        return $lineChart;
    }
}
