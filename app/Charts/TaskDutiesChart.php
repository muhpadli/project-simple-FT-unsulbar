<?php

namespace App\Charts;

use App\Models\Task;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class TaskDutiesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $tasksDutiesGroup = Task::select('user_id')->where('id_creator', auth()->user()->id)->groupBy('user_id')->get();
        $taskDutiesme = Task::select('user_id')->where('id_creator', auth()->user()->id)->get();
        $data = [];
        $label = [];
        foreach ($tasksDutiesGroup as $key => $task) {
            $sum = 0;
            foreach ($taskDutiesme as $key => $taskme) {
                if($task->user_id == $taskme->user_id){
                    $sum++;
                }
            }
            $data[] = $sum;
            $user = User::findOrFail($task)->first();
            $label[] = $user->name;
        }
        return $this->chart->donutChart()
            ->setTitle('Percentage of staff duties')
            ->setSubtitle(date('Y'))
            ->setWidth(335)
            ->setHeight(335)
            ->addData($data)
            ->setLabels($label);
    }
}
