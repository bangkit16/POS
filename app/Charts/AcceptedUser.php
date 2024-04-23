<?php

namespace App\Charts;

use App\Models\UserModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AcceptedUser
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $acc = UserModel::where('status' , '=' , 1)->count();
        $ucc = UserModel::where('status' , '=' , 0)->count();
        return $this->chart->donutChart()
            ->setTitle('User yang telah di Validasi')
            ->setSubtitle('User dari website.')
            ->addData([
                $acc , $ucc
            ])
            ->setLabels(['Tervalidasi', 'Belum Validasi']);
    }
}
