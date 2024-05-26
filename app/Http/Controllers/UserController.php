<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\jabatan;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Profil;
use App\Models\Riwayat_pendidikan;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use function Laravel\Prompts\select;

class UserController extends Controller
{
    public function index(){
        $users = User::join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
        ->join('profils', 'profils.id', '=', 'users.profil_id')
        ->join('roles', 'roles.id', '=', 'users.roles_id')
        ->select('users.name', 'users.id', 'jabatans.name as nama_jabatan', 'profils.NIP')
        ->where('roles_id', '!=', 1)
        ->get();
        return view('Admin.pegawai.index',[
            'users'          => $users,
            'active'        => 'manageUser',
        ]);
    }

    public function show(string $id){
        $user = User::findOrFail($id);
        $gender = Gender::all();
        $profil = Profil::all();
        $role   = Role::all();
        $organisasi = Organization::all();
        $detail = DB::table('users')
        ->join('profils', 'profils.id', '=', 'users.profil_id')
        ->join('riwayat_pendidikans', 'users.id', '=', 'riwayat_pendidikans.user_id')
        ->join('genders', 'genders.id', '=', 'users.genders_id')
        ->select('users.name', 'users.email', 'profils.NIP', 'profils.kontak', 'genders.namaGender',  'users.genders_id', 
        'profils.alamat', 'users.jabatan_id', 'users.roles_id', 'users.username', 'users.password','riwayat_pendidikans.strata_1', 'riwayat_pendidikans.strata_2', 'riwayat_pendidikans.strata_3' )
        ->where('users.id', '=', $id)
        ->get()->first();

        //riwayat_pendidikan
        $study_in_history = Riwayat_pendidikan::where('user_id', '=', auth()->user()->id)
            ->get()
            ->first();

        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $detail2 = DB::table('users')
        ->join('profils', 'profils.id', '=', 'users.profil_id')
        ->join('genders', 'genders.id', '=', 'users.genders_id')
        ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
        ->select('users.name', 'users.email', 'profils.NIP', 'profils.kontak', 'genders.namaGender',  'users.genders_id', 
        'jabatans.organisasi_id', 'profils.alamat')
        ->where('users.id', '=', $id)
        ->get()->first();

                    

        return view('Admin.pegawai.show',[
            'story_study'   => $study_in_history,
            'user'          => $user,
            'profil'        => $profil,
            'data'          => $detail,
            'data2'         => $detail2,
            'gender'        => $gender,
            'organisasi'    => $organisasi,
            'roles'         => $role,
            'active'        => 'manageUser',
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'  => $prioritas_status,
            'priority'  => 'none',
        ]);
    }

    public function create(){
        $gender = Gender::all();
        $role = Role::all();
        $user = DB::table('users')
        ->join('genders', 'users.genders_id', '=', 'genders.id')
        ->select('users.name', 'jabatan_id')
        ->get();
        $prioritas_tugas = Priority::all();

        $organisasi = Organization::all();
        return view('Admin.pegawai.create',[
            'organization' => $organisasi,
            'genders' => $gender,
            'roles' => $role,
            'active' => 'manageUser',
            'prioritas_tugas'   => $prioritas_tugas,
            'priority'  => 'none',
        ]);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'nama_lengkap'  => 'required|min:4',
            'nip'       => 'nullable|max:18|min:15',
            'kontak'    => 'required|min:11',
            'gender'    => 'required',
            'jabatan'   => 'required',
            'email'     => 'required|unique:users|email:dns',
            'alamat'    => 'required|min:5',
            'role'      => 'required',
            'username'  => 'required|unique:users|min:5',
            'password'  => 'required|unique:users|min:5'
        ],[
            'nama_lengkap.required' => 'nama lengkap tidak boleh dikosong',
            'nama_lengkap.min'  => 'nama kurang dari 4 karakter',
            'nip.min'           => 'nip minimal terdiri atas 15 karakter',
            'nip.max'           => 'nip maksimal terdiri atas  18 karakter',
            'kontak.required'   => 'kontak tidak boleh dikosongkan',
            'kontak.min'        => 'panjang kontak minimal 11 karakter',
            'email.required'    => 'email tidak boleh dikosongkan',
            'email.unique'      => 'email tidak boleh sama dengan pegawai lain',
            'alamat.required'   => 'alamat tdiak bole dikosongkan' ,
            'alamat.min'        => 'alamat minimal berisi 5 karakter',
            'username.required' => 'username tidak boleh dikosongkan',
            'username.unique'   => 'username tidak boleh sama dengan pengguna lain',
            'username.min'      => 'username minimal berisi 5 karakter',
            'password.required' => 'password tidak boleh dikosongkan',
            'password.unique'   => 'password tidak boleh sama dengan pengguna lain',
            'password.min'   => 'password minimal berisi 5 karakter',
        ]
    );

        if($request->file('image')){
            $validated['image'] = $request->file('image')->store('post-images');
        }

        $validated['password'] = Hash::make($validated['password']);
        $nip = (!empty($request->nip))? $request->nip : '-';

        Profil::create([
            'NIP'       => $nip,
            'kontak'    => $validated['kontak'],
            'alamat'    => $validated['alamat']
        ]);

        $lastIDProfil = Profil::latest()->first();
        $latestId = $lastIDProfil->id;

        User::create([
            'name'      => $validated['nama_lengkap'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'jabatan_id'     => $validated['jabatan'],
            'password'  => $validated['password'],
            'genders_id'=> $validated['gender'],
            'roles_id'  => $validated['role'],
            'profil_id' => $latestId,
        ]);

        $lastIDUser = User::latest()->first();
        $latestIdUser = $lastIDUser->id;

        Riwayat_pendidikan::create([
            'user_id' => $latestIdUser
        ]);
        
        Alert::success('Good Job', 'User baru berhasil ditambahkan!');
        return redirect('/users/pegawai');

    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $oldImage = $user->image;
        if(!empty($oldImage)){
            Storage::delete($oldImage);
        }
        $user->delete();
        
        Alert::success('Good Job', 'User berhasil dihapus!');

        return back();
    }
    public function getJabatan($id){
        $jabatan = jabatan::where("organisasi_id",$id)->get();
        return response()->json($jabatan);
    }
    
}
