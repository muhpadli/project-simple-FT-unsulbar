<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\riwayat_tugas;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TaskController extends Controller
{
     public function index(){
        $prioritas_tugas    = Priority::all();
        $prioritas_status   = Status::all();
        return view('layout.Pejabat.DetailTask',[
            'active'    => 'beranda',
            'prioritas_status'  =>  $prioritas_status,
            'prioritas_tugas'  =>  $prioritas_tugas,
        ]);
    }

    public function create(){
        $department = Organization::all();
        $priority   = Priority::all();
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $jabatan = jabatan::all()->where('id', '!=', auth()->user()->jabatan_id);
        $position = jabatan::where('id','=',auth()->user()->jabatan_id)->get()->first();
        return view('layout.Pejabat.newTask',[
            'department'    => $department,
            'priority'      => $priority,
            'active'        => 'none',
            'prioritas_status'  => $prioritas_status,
            'prioritas_tugas'  => $prioritas_tugas,
            'position'      => $position,
            'jabatan'       => $jabatan
        ]
    );
    }

    public function edit(string $id){
        $department = Organization::all();
        $priority   = Priority::all();
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $tugas  = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select('tasks.id', 'tasks.title_task', 'tasks.date_start','tasks.keterangan','tasks.excerpt', 'tasks.deksripsi', 'users.name AS name_user', 'jabatans.name AS name_jabatan', 'statuses.name_status', 'priorities.id AS id_prioritas','priorities.name', 'organizations.name AS department', 'organizations.id AS id_departement', 'jabatans.id AS id_jabatan','users.id AS id_user')
            ->where('tasks.id', '=', $id)
            ->get();

            return view('layout.Pejabat.edit_tugas', [
                'department'    => $department,
                'priority'  => $priority,
                'active'    => 'none',
                'task'      => $tugas->first(),
                'prioritas_tugas'   => $prioritas_tugas,
                'prioritas_status'   => $prioritas_status,
            ]
        );
    }
    public function show(string $id){
        $priority = Priority::all()->first;
        $status   = DB::table('statuses')
        ->select('*')
        ->where('role_id','=',2)
        ->get();
        $riwayat_tugas = riwayat_tugas::where('tugas_id','=',$id)->get()->first();
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $tugas  = DB::table('tasks')
            ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
            ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->select('tasks.id', 'tasks.title_task', 'statuses.bg_color AS bg_warna', 'tasks.date_start','tasks.keterangan','tasks.excerpt', 'tasks.deksripsi', 'users.name AS name_user', 'jabatans.name AS name_jabatan', 'statuses.name_status','priorities.name', 'organizations.name AS department')
            ->where('tasks.id', '=', $id)
            ->get();

            return view('layout.Pejabat.detail_task', [
                'status'            =>  $status,
                'tugas_terkirim'    => $riwayat_tugas,
                'priority'  => $priority,
                'active'    => 'none',
                'task'      => $tugas->first(),
                'prioritas_tugas'   => $prioritas_tugas,
                'prioritas_status'  =>$prioritas_status
            ]);
        }

    public function store(Request $request){
        $validate   = $request->validate([
            'user_id'           => 'required',
            'priority_id'       => 'required',
            'title_task'        => 'required|min:3',
            'deksripsi'         => 'required|min:10'
        ]);
        
        $Status     = Status::first();
        $validate['id_creator']     = auth()->user()->id;
        $validate['status_id']      = $Status->id;
        $validate['excerpt']        = str::limit(strip_tags($request->deksripsi) , 30);
        $validate['updated_at']     = Carbon::now('Asia/Makassar');


        
        
        if($request->keterangan){
            $validate['keterangan'] = $request->keterangan;
            Task::create($validate);
        }else{
            Task::create($validate);
        }


        Alert::success('Good Job', 'Tugas berhasil dibuat!');

        return redirect()->route('dashboard_pejabat.index');

    }

    public function update(Request $request, $id) {
        $validate = $request->validate([
            'user_id'       => 'required',
            'priority_id'   => 'required',
            'title_task'    => 'required|min:3',
            'deksripsi'     => 'required|min:10',
        ]);
        $validate['updated_at']   = Carbon::now('Asia/Makassar');

    
        $validate['excerpt'] = Str::limit(strip_tags($request->deksripsi), 30);
    
        if ($request->keterangan) {
            $validate['keterangan'] = $request->keterangan;
        }
    
        // Menemukan tugas berdasarkan ID yang diterima dari URL
        $task = Task::findOrFail($id);
    
        // Memperbarui data tugas dengan data yang telah divalidasi
        $task->update($validate);
    
        Alert::success('Good Job', 'Tugas berhasil diperbarui!');
    
        return redirect()->route('DetailTask.show',$id);
    }
    
    public function destroy($id){
        $task = Task::findOrFail($id);

        $task->delete();
        Alert::success('Hore!','Tugas berhasil terhapus!');
        return redirect()->route('dashboard_pejabat.index');
    }

    public function getJabatan($id){
        $jabatan = jabatan::where([
            ["organisasi_id",$id],
            ["id",'!=', auth()->user()->jabatan_id]
        ])->get();
        return response()->json($jabatan);
    }
    public function getUser($id){
        $user = User::where("jabatan_id",$id)->get();
        return response()->json($user);
    }

    public function getTaskByPriority(){
        $task = Task::all()->where('id_creator', '=', auth()->user()->id);
        $count = [0,0,0,0,0,0];
        foreach ($task as $key => $value) {
            if($value->status_id == "1") {
                $count[0]+=1;
            }else if($value->status_id == "2"){
                $count[1]+=1;
            }else if($value->status_id == "3"){
                $count[2]+=1;
            }else if($value->status_id == "4"){
                $count[3]+=1;
            }else if($value->status_id == "5"){
                $count[4]+=1;
            }else if($value->status_id == "6"){
                $count[5]+=1;
            }
        }
        return response()->json($count);
        
    }
}
