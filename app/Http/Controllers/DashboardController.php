<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\jabatan;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        if(auth()->user()->roles_id == 1){
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();
        return view('layout.Admin.Dashboard',[
            'users' => User::all(),
            'Organization' => Organization::all(),
            "active" => "beranda",
            'priority'  => 'none',
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'  => $prioritas_status
        ]);
        }elseif(auth()->user()->roles_id == 2){
            $tugas = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select('tasks.id', 'tasks.title_task', 'tasks.excerpt', 'statuses.name_status','priorities.name', 'organizations.name AS department')
            ->get();

            $task = Task::all()->where('id_creator','=',auth()->user()->id); 
            $prioritas_tugas = Priority::all();
            $prioritas_status = status::all();
            return view('layout.Pejabat.Dashboard', [
                'active'    => 'beranda',
                'task'      => $task,
                'priority'  => 'none',
                'prioritas_tugas'   => $prioritas_tugas,
                'prioritas_status'   => $prioritas_status
            ]);
        }else{
            $prioritas_tugas = Priority::all();
            $prioritas_status = Status::all();
            return view('layout.Staf.Dashboard',[
                'active'    => 'beranda',
                'priority'  => 'none',
                'prioritas_tugas'   => $prioritas_tugas,
                'prioritas_status'   => $prioritas_status
            ]);
        }

        
    }

    public function organisasi(){

        // $organisasi = Organization::with('jabatans')->get();
        $organisasi = Organization::with('jabatans')->get();
        // $jabatan = jabatan::with('users')->get();
        
        $jabatan = DB::table('jabatans')
                    ->join('users', 'users.jabatan_id', '=', 'jabatans.id')
                    ->select('users.name', 'jabatans.id', 'jabatans.organisasi_id')
                    ->get();
                    
                    
        return view('layout.Admin.Organisasi',[
            'data' => $organisasi,
            'jabatan' => $jabatan,
            "active" => "manageOrganisasi"
        ]);
    }
}
