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

        return redirect()->route('task-duties.index');

    }

   
    
    public function destroy($id){
        $task = Task::findOrFail($id);

        $task->delete();
        Alert::success('Hore!','Tugas berhasil terhapus!');
        return redirect()->route('dashboard_pejabat.index');
    }

    public function getJabatan($id){
        $user_id = auth()->user()->id;
        $level_user_id = DB::table('users')
            ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_users', 'level_users.id', '=', 'jabatans.level_users_id')
            ->select('level_users.tingkat')
            ->where('users.id', '=', $user_id)
            ->get()
            ->first();
        $jabatan = jabatan::join('level_users', 'level_users.id', '=', 'level_users_id')
        ->select('jabatans.*', 'level_users.tingkat')
        ->where([
            ["jabatans.organisasi_id",$id],
            ["jabatans.id",'!=', auth()->user()->jabatan_id],
            ["level_users.tingkat",'>', $level_user_id->tingkat]
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
