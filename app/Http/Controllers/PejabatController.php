<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Profil;
use App\Models\riwayat_tugas;
use App\Models\Role;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                    ->select('tasks.id', 'tasks.status_id','statuses.bg_color','priorities.bg_color AS bg_warna','tasks.title_task', 'tasks.excerpt', 'statuses.name_status','priorities.name', 'organizations.name AS department')
                    ->where([
                        ['id_creator', '=', auth()->user()->id],
                        ['priority_id', '=', $id]
                    ])
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

                    $priority = Priority::where('id','=',$id)->first();
                    $tugasAll  = Task::all();
        return view('layout.Pejabat.index', [
            'active'    => 'filter-priority',
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
                    ->select('tasks.id', 'tasks.title_task', 'tasks.excerpt', 'statuses.bg_color','priorities.bg_color AS bg_warna', 'statuses.name_status','priorities.name', 'organizations.name AS department')
                    ->where([
                        ['id_creator', '=', auth()->user()->id],
                        ['status_id', '=', $id]
                    ])
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

                    $priority = Status::where('id','=',$id)->first();
        return view('layout.Pejabat.index', [
            'active'    => 'filter-status',
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
                    ->select('tasks.id','tasks.status_id', 'tasks.title_task', 'tasks.excerpt', 'statuses.name_status', 'statuses.bg_color','priorities.name','priorities.bg_color AS bg_warna', 'organizations.name AS department')
                    ->orderBy('tasks.updated_at', 'desc')
                    ->get();

        return view('layout.Pejabat.index', [
            'active'    => 'task',
            'task'      => $tugas,
            'priority'  => 'none',
            'prioritas_status'  => $prioritas_status,
            'prioritas_tugas'  => $prioritas_tugas,
            'tugasAll'  => $tugasAll
        ]);
    }

    public function update(Request $request, $id){
        $validasi_data = $request->validate([
            'status_id'    => 'required'
        ]);

        $task = Task::findOrFail($id);
        // Memperbarui data tugas dengan data yang telah divalidasi
        $task->update($validasi_data);
    
        Alert::success('Good Job', 'Status Tugas diperbarui!');
        return redirect()->route('DetailTask.show', $id);
    }

    public function update_user(Request $request, $id){
        
        $data = $request->validate([
            'nama'      =>  'required|min:3',
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
        }

        return redirect()->route('ManageUsers.show', $id)->with(['success' => 'Data Profil Berhasil Diubah!']);

    }

    public function draft_jabatan($id){
        $organisasi = Organization::findOrFail($id);
        $users = User::orderBy('created_at', 'desc')->paginate();
        $user = DB::table('users')
        ->join('genders', 'users.genders_id', '=', 'genders.id')
        ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
        ->select('users.name', 'users.id', 'users.jabatan_id', 'users.image', 'jabatans.name AS jabName')
        ->orderBy('users.updated_at', 'desc')
        ->where('jabatans.organisasi_id','=',$id)
        ->get();
        $roles = Role::all();
        $data_jabatan = jabatan::all()->where('organisasi_id', '=', $id);
        return view('layout.Admin.listJabatan',[
            'organisasi'=> $organisasi,
            'users'     => $users,
            'user'      => $user,
            'active'    => 'manageOrganisasi',
            'data'      => $data_jabatan, 
            'roles'     => $roles     
        ]);
    }
   
}
