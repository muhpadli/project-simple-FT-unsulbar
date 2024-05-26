<?php

namespace App\Http\Controllers;

use App\Charts\OrganisasiFakultasChart;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(OrganisasiFakultasChart $organisasiFakultasChart)
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail($user_id);

        if ($user->roles_id == 1) {
            $countPegawai = User::where('roles_id','=',2)->count();
            return view('Admin.layout.Dashboard', [
                'users' => User::all(),
                'Organization' => Organization::all(),
                'active' => 'beranda',
                'countPegawai' => $countPegawai,
                'Chart' => $organisasiFakultasChart->build()
            ]);
        } else {
            $level_user_id = DB::table('users')->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')->join('level_users', 'level_users.id', '=', 'jabatans.level_users_id')->select('level_users.tingkat')->where('users.id', '=', $user_id)->get()->first();

            if ($level_user_id->tingkat == 6) {
                $prioritas_tugas = Priority::all();
                $prioritas_status = Status::all();
                return view('layout.Staf.Dashboard', [
                    'active' => 'beranda',
                    'priority' => 'none',
                    'prioritas_tugas' => $prioritas_tugas,
                    'prioritas_status' => $prioritas_status,
                ]);
            } else {
                $tugas = DB::table('tasks')->join('statuses', 'statuses.id', '=', 'tasks.status_id')->join('priorities', 'priorities.id', '=', 'tasks.priority_id')->join('users', 'users.id', '=', 'tasks.user_id')->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')->select('tasks.id', 'tasks.title_task', 'tasks.excerpt', 'statuses.name_status', 'priorities.name', 'organizations.name AS department')->get();

                $task = Task::all()->where('id_creator', '=', auth()->user()->id);
                $prioritas_tugas = Priority::all();
                $prioritas_status = status::all();
                return view('layout.Pejabat.Dashboard', [
                    'active' => 'beranda',
                    'task' => $task,
                    'priority' => 'none',
                    'prioritas_tugas' => $prioritas_tugas,
                    'prioritas_status' => $prioritas_status,
                ]);
            } 
        }
    }
}
