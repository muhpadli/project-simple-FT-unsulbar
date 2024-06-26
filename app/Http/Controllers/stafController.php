<?php
namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\riwayat_tugas;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class stafController extends Controller
{
    
    
    public function dashboard_staff(){
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $status = User::all();
        return view('layout.Staf.Dashboard',[
            'active' => 'beranda',
            'open'  => '',
            'status' => $status,
            'priority'  => 'none',
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'  => $prioritas_status
        ]);
    }
    public function index(){
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();
        $tugas = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users as creators', 'tasks.id_creator', '=', 'creators.id') // Join untuk creator
            ->join('jabatans', 'creators.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select(
                'tasks.id',
                'tasks.id_creator',
                'tasks.title_task',
                'tasks.excerpt',
                'statuses.name_status',
                'priorities.name',
                'statuses.bg_color',
                'priorities.bg_color AS bg_warna',
                'organizations.name AS department_name',
                'creators.name AS name_user', // Menambahkan field untuk name_user
                'jabatans.name AS name_jabatan' // Menambahkan field untuk name_jabatan
            )
            ->where('user_id', auth()->user()->id)
            ->orderBy('tasks.updated_at', 'desc')
            ->get();
            
        return view('layout.Staf.index', [
            'active'    => 'my-task',
            'open'      => '',
            'task'      => $tugas,
            'priority'  => 'none',
            'prioritas_tugas' => $prioritas_tugas,
            'prioritas_status'  => $prioritas_status
        ]);
    }

    public function filter_by_priority($id){
        $tugas = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users as creators', 'tasks.id_creator', '=', 'creators.id') // Join untuk creator
            ->join('jabatans', 'creators.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select(
                'tasks.id',
                'tasks.id_creator',
                'tasks.title_task',
                'tasks.excerpt',
                'statuses.bg_color',
                'priorities.bg_color AS bg_warna',
                'statuses.name_status',
                'priorities.name',
                'organizations.name AS department_name',
                'creators.name AS name_user', // Menambahkan field untuk name_user
                'jabatans.name AS name_jabatan' // Menambahkan field untuk name_jabatan
            )
            ->where([
                ['user_id', '=', auth()->user()->id],
                ['priority_id', '=', $id]
            ])
            ->get();

            $prioritas_tugas = Priority::all();
            $prioritas_status = Status::all();

            $priority = Priority::where('id','=',$id)->first();
            return view('layout.Staf.index', [
                'active'    => 'my-task',
                'open'      => 'filter-priority',
                'task'      => $tugas,
                'priority'  => $priority->name,
                'prioritas_tugas'   => $prioritas_tugas,
                'prioritas_status' => $prioritas_status
            ]
        );
    }
    public function filter_by_status($id){
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();
        $tugas = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users as creators', 'tasks.id_creator', '=', 'creators.id') // Join untuk creator
            ->join('jabatans', 'creators.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select(
                'tasks.id',
                'tasks.id_creator',
                'tasks.title_task',
                'tasks.excerpt',
                'statuses.bg_color',
                'priorities.bg_color AS bg_warna',
                'statuses.name_status',
                'priorities.name',
                'organizations.name AS department_name',
                'creators.name AS name_user', // Menambahkan field untuk name_user
                'jabatans.name AS name_jabatan' // Menambahkan field untuk name_jabatan
            )
            ->where([
                ['user_id', '=', auth()->user()->id],
                ['status_id', '=', $id]
            ])
            ->orderBy('tasks.updated_at', 'desc')
            ->get();
            $priority = Status::where('id','=',$id)->first();

        return view('layout.Staf.index', [
            'active'    => 'my-task',
            'open'      => 'filter-status',
            'task'      => $tugas,
            'priority'  => $priority->name_status,
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'  => $prioritas_status
        ]);
    }
    public function update(Request $request, $id){
        $validasi_data = $request->validate([
            'status_id'    => 'required'
        ]);
        $validasi_data['updated_at']   = Carbon::now('Asia/Makassar');


        $task = Task::findOrFail($id);
        $id_riwayat_tugas = DB::table('riwayat_tugas')
        ->join('tasks', 'tasks.id', '=', 'riwayat_tugas.tugas_id')
        ->select('riwayat_tugas.id')
        ->where('riwayat_tugas.tugas_id', '=', $id)
        ->get();

        
        
        if ($validasi_data['status_id'] == 2) {
            $validasi_data['date_start']   = Carbon::now('Asia/Makassar');
            $task->update($validasi_data);
        }elseif($validasi_data['status_id'] == 5){
            $riwayat_tugas  = riwayat_tugas::findOrFail($id_riwayat_tugas->first()->id);
            $tugas['waktu_selesai']   = Carbon::now('Asia/Makassar');
            $riwayat_tugas->update($tugas);
            $task->update($validasi_data);
        }else{
            $task->update($validasi_data);
        }

        // Memperbarui data tugas dengan data yang telah divalidasi
        
    
        Alert::success('Good Job', 'Status Tugas diperbarui!');
    
        return redirect()->route('user_staf.show', $id);
    }

    public function show(string $id){
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();
        $priority = Priority::all()->first;
        $riwayat_tugas = riwayat_tugas::where('tugas_id','=',$id)->get()->first();

        $tugas = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users as creators', 'tasks.id_creator', '=', 'creators.id') // Join untuk creator
            ->join('jabatans', 'creators.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select(
                'tasks.keterangan',
                'tasks.date_start',
                'tasks.id',
                'tasks.id_creator',
                'statuses.bg_color',
                'statuses.id AS id_status',
                'priorities.bg_color AS bg_warna',
                'tasks.title_task',
                'tasks.excerpt',
                'tasks.deksripsi',
                'statuses.name_status',
                'priorities.name',
                'organizations.name AS department_name',
                'creators.name AS name_user', // Menambahkan field untuk name_user
                'jabatans.name AS name_jabatan' // Menambahkan field untuk name_jabatan
            )
            ->where('tasks.id', '=', $id)
            ->get();
    
        return view('layout.Staf.DetailTask', [
            'tugas_terkirim'    => $riwayat_tugas,
            'priority'          =>  $priority,
            'active'            => 'my-task',
            'task'              => $tugas->first(),
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'  => $prioritas_status
        ]);
    }

    public function pending_task($id){
        $status_id = 3;
        $task = Task::findOrFail($id);
        $task->update([
            'status_id' => $status_id
        ]);

        Alert::success('Good Job', 'Tugas Berhasil dipending');
    
        return redirect()->route('my-task.show', $id);

    }
    
    public function start_working_task($id){
        $status_id = 2;
        $task = Task::findOrFail($id);
        $date_start  = Carbon::now('Asia/Makassar');
        $task->update([
            'status_id' => $status_id,
            'date_start'    => $date_start
        ]);

        Alert::success('Good Job', 'Tugas Siap Dikerjakan');
    
        return redirect()->route('my-task.show', $id);

    }

    public function accepted_task($id){
        $status_id = 6;
        $task = Task::findOrFail($id);
        $task->update([
            'status_id' => $status_id
        ]);
    
        return redirect()->route('task-duties.show', $id)->with(['success' => 'Task Was Approved']);

    }

    public function revision_task(Request $request){
        $data = $request->validate([
            'riwayat_tugas_id' => 'required',
            'tugas_id'  => 'required',
            'revision'  =>  'required|min:5'
        ]);

        $status_id = 4;
        $task = Task::findOrFail($data['tugas_id']);
        $riwayat_tugas = riwayat_tugas::findOrFail($data['riwayat_tugas_id']);
        $task->update([
            'status_id' => $status_id
        ]);
        $riwayat_tugas->update([
            'revision'  => $data['revision']
        ]);
        return redirect()->route('task-duties.show', $data['tugas_id'])->with(['success' => 'submission needs to be revised']);
    }
}
