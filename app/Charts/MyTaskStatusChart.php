<?php

namespace App\Charts;

use App\Models\Task;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MyTaskStatusChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $myTaskByStatus = Task::join('statuses', 'statuses.id', '=', 'tasks.status_id')
        ->select('statuses.name_status')
        ->where('user_id', auth()->user()->id)->groupBy('status_id')->get();
        $myTask = Task::join('statuses', 'statuses.id', '=', 'tasks.status_id')
        ->select('statuses.name_status')
        ->where('user_id', auth()->user()->id)->get();
        $data = [];
        $label = [];
        foreach ($myTaskByStatus as $key => $value) {
            $jml = 0;
            foreach ($myTask as $key2 => $task) {
                if ($value->name_status == $task->name_status) {
                    $jml++;
                }
            }
            $data[] = $jml;
            $label[] = $value->name_status;
        }
        
        return $this->chart->pieChart()
            ->setTitle('Percentage of my tasks by status')
            ->setSubtitle(date('Y'))
            ->setWidth(335)
            ->setHeight(335)
            ->addData($data)
            ->setLabels($label);
    }
}
