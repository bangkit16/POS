<?php

namespace App\Charts;

use App\Models\BarangModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class Sell
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $i = 0;
        foreach(BarangModel::All() as $b){
            $jual[$i] = $b->harga_jual;
            $beli[$i] = $b->harga_beli;
            $brg[$i] = $b->barang_nama;
            $i++;
        }

        return $this->chart->barChart()
            ->setTitle('Harga jual vs Harga Beli')
            ->setSubtitle('Harga jual dan harga beli per barang')
            ->addData('Harga Jual', $jual)
            ->addData('Harga Beli', $beli)
            ->setXAxis($brg);
    }
}
