<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Profil;
use App\Models\Riwayat_pendidikan;
use App\Models\riwayat_tugas;
use App\Models\Role;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\String_;
use RealRashid\SweetAlert\Facades\Alert;

class PejabatController extends Controller
{

    public function beranda(){
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();
        $task = Task::all()->where('id_creator','=',auth()->user()->id);
        return view('layout.Pejabat.Dashboard', [
            'open'      => '',
            'active'    => 'beranda',
            'priority'  => 'none',
            'task'      => $task,
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'   => $prioritas_status,
        ]);
    }

    public function get_task_by_priority($id){
        // $tugas = Task::all();
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();

        $tugas = DB::table('tasks')
                    ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
                    ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
                    ->join('users', 'users.id', '=', 'tasks.user_id')
                    ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
                    ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
                    ->select('tasks.id', 'tasks.status_id', 'users.name AS nameUser','statuses.bg_color','priorities.bg_color AS bg_warna','tasks.title_task', 'tasks.excerpt', 'statuses.name_status','priorities.name', 'organizations.name AS department')
                    ->where([
                        ['id_creator', '=', auth()->user()->id],
                        ['priority_id', '=', $id]
                    ])
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

                    $priority = Priority::where('id','=',$id)->first();
                    $tugasAll  = Task::all();
        return view('layout.Pejabat.index', [
            'open'      => 'filter-priority',
            'active'    => 'task',
            'task'      => $tugas,
            'priority'  => $priority->name,
            'prioritas_tugas'   =>  $prioritas_tugas,
            'prioritas_status'   =>  $prioritas_status,
            'tugasAll'  => $tugasAll
        ]);
    }

    public function get_task_by_status($id){
        // $tugas = Task::all();
        $tugasAll  = Task::all();
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $tugas = DB::table('tasks')
                    ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
                    ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
                    ->join('users', 'users.id', '=', 'tasks.user_id')
                    ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
                    ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
                    ->select('tasks.id', 'tasks.title_task', 'users.name AS nameUser', 'tasks.excerpt', 'statuses.bg_color','priorities.bg_color AS bg_warna', 'statuses.name_status','priorities.name', 'organizations.name AS department')
                    ->where([
                        ['id_creator', '=', auth()->user()->id],
                        ['status_id', '=', $id]
                    ])
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

                    $priority = Status::where('id','=',$id)->first();
        return view('layout.Pejabat.index', [
            'active'    => 'task',
            'open'      => 'filter-status',
            'task'      => $tugas,
            'priority'  => $priority->name_status,
            'prioritas_status' => $prioritas_status,
            'prioritas_tugas' => $prioritas_tugas,
            'tugasAll'  => $tugasAll
        ]);
    }

    public function index(){
        // $tugas = Task::all();
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $tugasAll  = Task::all();


        $tugas = DB::table('tasks')
                    ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
                    ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
                    ->join('users', 'users.id', '=', 'tasks.user_id')
                    ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
                    ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
                    ->select('tasks.id','tasks.status_id', 'users.name AS nameUser', 'tasks.title_task', 'tasks.excerpt', 'statuses.name_status', 'statuses.bg_color','priorities.name','priorities.bg_color AS bg_warna', 'organizations.name AS department')
                    ->where([
                        ['id_creator', '=', auth()->user()->id]
                    ])
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

        return view('layout.Pejabat.index', [
            'active'    => 'task',
            'open'      => '',
            'task'      => $tugas,
            'priority'  => 'none',
            'prioritas_status'  => $prioritas_status,
            'prioritas_tugas'  => $prioritas_tugas,
            'tugasAll'  => $tugasAll
        ]);
    }

    // public function update(Request $request, $id){
    //     $validasi_data = $request->validate([
    //         'status_id'    => 'required'
    //     ]);

    //     $task = Task::findOrFail($id);
    //     // Memperbarui data tugas dengan data yang telah divalidasi
    //     $task->update($validasi_data);
    
    //     Alert::success('Good Job', 'Status Tugas diperbarui!');
    //     return redirect()->route('DetailTask.show', $id);
    // }
    public function create(){
        $user_id = auth()->user()->id;
        $level_user_id = DB::table('users')
            ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('level_users', 'level_users.id', '=', 'jabatans.level_users_id')
            ->select('level_users.tingkat')
            ->where('users.id', '=', $user_id)
            ->get()
            ->first();
        $department = Organization::all();
        $priority   = Priority::all();
        // $jabatan = jabatan::all()->where('id', '!=', auth()->user()->jabatan_id);
        $jabatan = jabatan::join('level_users', 'level_users.id', '=', 'level_users_id')
        ->select('jabatans.*', 'level_users.tingkat')
        ->where('level_users.tingkat', '>', $level_user_id->tingkat)
        ->get();
        $position = jabatan::where('id','=',auth()->user()->jabatan_id)->get()->first();
        return view('layout.Pejabat.newTask',[
            'department'    => $department,
            'priority'      => $priority,
            'active'        => 'task',
            'position'      => $position,
            'jabatan'       => $jabatan
        ]
    );
    }

    public function edit(string $id){
        $department = Organization::all();
        $priority   = Priority::all();
        $position = jabatan::where('id','=',auth()->user()->jabatan_id)->get()->first();
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
                'position'  => $position,
                'active'    => 'task',
                'task'      => $tugas->first(),
            ]
        );
    }
    public function show(string $id){
        $priority = Priority::all()->first;
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
                'tugas_terkirim'    => $riwayat_tugas,
                'priority'  => $priority,
                'active'    => 'task',
                'task'      => $tugas->first(),
                'prioritas_tugas'   => $prioritas_tugas,
                'prioritas_status'  =>$prioritas_status
            ]);
        }
    public function update_user(Request $request, $id){
        
        $data = $request->validate([
            'nama'      =>  'required|min:5',
            'nip'       =>  'max:18',
            'kontak'    =>  'required|min:11',
            'email'     =>  'email',
            'gender'    =>  'required',
            'jabatan'   =>  'required',
            'alamat'    =>  'required|min:5',
            'image'     =>  'image|file|max:2048',
        ]);

        $data['updated_at']   = Carbon::now('Asia/Makassar');

        $user = User::findOrFail($id);
        $profil = Profil::findOrFail($request->id_profil);


        if($request->hasFile('image')){
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $data['image']  = $request->file('image')->store('post-images');


            $user->update([
                'name'      =>  $data['nama'],
                'email'     =>  $data['email'],
                'genders_id'=>  $data['gender'],
                'jabatan_id'=>  $data['jabatan'],
                'image'     =>  $data['image'],
                'updated_at'=>  $data['updated_at']
            ]);

            $profil->update([
                'NIP'   => $data['nip'],
                'kontak'=> $data['kontak'],
                'alamat'=> $data['alamat']
            ]);

            //update data riwayat pendidikan
            if ($request->strata_1) {
                $strata_1 = $request->strata_1;
                $riwayat_study_id = Riwayat_pendidikan::where('user_id', '=', $id)->get()->first();
                $riwayat_study_user = Riwayat_pendidikan::findOrFail($riwayat_study_id->id);
                if ($request->strata_2){
                    $strata_2 = $request->strata_2;
                    if ($request->strata_3){
                        $strata_3 = $request->strata_3;
                        $riwayat_study_user->update([
                            'strata_1' => $strata_1,
                            'strata_2' => $strata_2,
                            'strata_3' => $strata_3
                        ]);
                    } else{
                        $riwayat_study_user->update([
                            'strata_1' => $strata_1,
                            'strata_2' => $strata_2
                        ]);
                    }
                } else{
                    $riwayat_study_user->update([
                        'strata_1' => $strata_1
                    ]);
                } 
            }
        }else{
            $user->update([
                'name'      => $data['nama'],
                'email'     => $data['email'],
                'genders_id'=> $data['gender'],
                'jabatan_id'=> $data['jabatan'],
                'updated_at'=>  $data['updated_at']

            ]);

            $profil->update([
                'NIP'   => $data['nip'],
                'kontak'=> $data['kontak'],
                'alamat'=> $data['alamat']
            ]);

            //update data riwayat pendidikan
            if ($request->strata_1) {
                $strata_1 = $request->strata_1;
                $riwayat_study_id = Riwayat_pendidikan::where('user_id', '=', $id)->get()->first();
                $riwayat_study_user = Riwayat_pendidikan::findOrFail($riwayat_study_id->id);
                if ($request->strata_2){
                    $strata_2 = $request->strata_2;
                    if ($request->strata_3){
                        $strata_3 = $request->strata_3;
                        $riwayat_study_user->update([
                            'strata_1' => $strata_1,
                            'strata_2' => $strata_2,
                            'strata_3' => $strata_3
                        ]);
                    } else{
                        $riwayat_study_user->update([
                            'strata_1' => $strata_1,
                            'strata_2' => $strata_2
                        ]);
                    }
                } else{
                    $riwayat_study_user->update([
                        'strata_1' => $strata_1
                    ]);
                } 
            }
        }

        return redirect()->route('pegawai.show', $id)->with(['success' => 'Data Profil Berhasil Diubah!']);

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
    
        return redirect()->route('task-duties.show',$id);
    }

    public function get_task_by_duties($id){
        // $tugas = Task::all();
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();

        $tugas = DB::table('tasks')
                    ->join('statuses', 'statuses.id', '=', 'tasks.status_id')
                    ->join('priorities', 'priorities.id', '=', 'tasks.priority_id')
                    ->join('users', 'users.id', '=', 'tasks.user_id')
                    ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
                    ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
                    ->select('tasks.id', 'tasks.status_id', 'users.name AS nameUser','statuses.bg_color','priorities.bg_color AS bg_warna','tasks.title_task', 'tasks.excerpt', 'statuses.name_status','priorities.name', 'organizations.name AS department')
                    ->where([
                        ['id_creator', '=', auth()->user()->id],
                        ['user_id', '=', $id]
                    ])
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

                    $priority = Priority::where('id','=',$id)->first();
                    $tugasAll  = Task::all();
        return view('layout.Pejabat.index', [
            'open'      => 'none',
            'active'    => 'task',
            'task'      => $tugas,
            'priority'  => "",
            'prioritas_tugas'   =>  $prioritas_tugas,
            'prioritas_status'   =>  $prioritas_status,
            'tugasAll'  => $tugasAll
        ]);
    }
   
}
