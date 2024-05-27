<?php

namespace App\Charts;

use App\Models\jabatan;
use App\Models\Organization;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use PhpParser\Node\Stmt\Label;

class OrganisasiFakultasChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $jabatanOrganisasi = jabatan::get();
        $data = [
            $jabatanOrganisasi->where('organisasi_id',1)->count(),
            $jabatanOrganisasi->where('organisasi_id',2)->count(),
            $jabatanOrganisasi->where('organisasi_id',3)->count(),
            $jabatanOrganisasi->where('organisasi_id',6)->count(),
            $jabatanOrganisasi->where('organisasi_id',8)->count(),
            $jabatanOrganisasi->where('organisasi_id',9)->count(),
            $jabatanOrganisasi->where('organisasi_id',10)->count(),
        ];
        $label = [
            Organization::findOrFail(1)->name,
            Organization::findOrFail(2)->name,
            Organization::findOrFail(3)->name,
            Organization::findOrFail(6)->name,
            Organization::findOrFail(8)->name,
            Organization::findOrFail(9)->name,
            Organization::findOrFail(10)->name,
        ];

        return $this->chart->pieChart()
            ->setTitle('Persentase Jabatan Organisasi')
            ->setSubtitle(date('Y'))
            ->addData($data)
            ->setLabels($label);
    }
}
