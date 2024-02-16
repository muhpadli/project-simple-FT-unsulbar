<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\jabatan;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Profil;
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
        $gender = Gender::all();
        $role = Role::all();
        $users = User::orderBy('updated_at', 'desc')->paginate();
        $user = DB::table('users')
        ->join('genders', 'users.genders_id', '=', 'genders.id')
        ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
        ->select('users.name', 'jabatan_id AS jabId', 'users.image', 'jabatans.name AS jabName')
        ->orderBy('users.updated_at', 'desc')
        ->get();
        
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
        $organisasi = Organization::all();
        return view('layout.Admin.listUser',[
            'organization'  => $organisasi,
            'genders'       => $gender,
            'roles'         => $role,
            'user'          => $user,
            'active'        => 'manageUser',
            'users'         => $users,
            'prioritas_tugas'   => $prioritas_tugas,
            'prioritas_status'   => $prioritas_status,
            'priority'  => 'none',
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
        ->join('genders', 'genders.id', '=', 'users.genders_id')
        ->select('users.name', 'users.email', 'profils.NIP', 'profils.kontak', 'genders.namaGender',  'users.genders_id', 
        'profils.alamat', 'users.jabatan_id', 'users.roles_id', 'users.username', 'users.password')
        ->where('users.id', '=', $id)
        ->get()->first();

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
                    

        return view('layout.Admin.UserDetail',[
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

    public function profil(string $id){
        $user = User::findOrFail($id);
        $gender = Gender::all();
        $profil = Profil::all();
        $role   = Role::all();
        $organisasi = Organization::all();
        $detail = DB::table('users')
        ->join('profils', 'profils.id', '=', 'users.profil_id')
        ->join('genders', 'genders.id', '=', 'users.genders_id')
        ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
        ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
        ->select('users.name', 'users.email', 'profils.NIP', 'profils.kontak', 'genders.namaGender',  'users.genders_id', 
        'profils.alamat', 'organizations.name AS name_organisasi', 'jabatans.name AS nama_jabatan','users.jabatan_id', 'users.roles_id', 'users.username', 'users.password')
        ->where('users.id', '=', $id)
        ->get()->first();

        $detail2 = DB::table('users')
        ->join('profils', 'profils.id', '=', 'users.profil_id')
        ->join('genders', 'genders.id', '=', 'users.genders_id')
        ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
        ->select('users.name', 'users.email', 'profils.NIP', 'profils.kontak', 'genders.namaGender',  'users.genders_id', 
        'jabatans.organisasi_id', 'profils.alamat')
        ->where('users.id', '=', $id)
        ->get()->first();
        $prioritas_tugas = Priority::all();
        $prioritas_status = Status::all();
                    

        return view('layout.profil_user',[
            'user'          => $user,
            'profil'        => $profil,
            'data'          => $detail,
            'data2'         => $detail2,
            'gender'        => $gender,
            'organisasi'    => $organisasi,
            'roles'         => $role,
            'active'        => 'none',
            'prioritas_tugas'   =>$prioritas_tugas,
            'prioritas_status'   =>$prioritas_status,
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
        return view('layout.Admin.ManageUsers',[
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
            'nip'       =>  'max:18',
            'kontak'    => 'required|min:11',
            'gender'    => 'required',
            'organisasi'=> 'required',
            'jabatan'   => 'required',
            'image'     => 'image|file|max:2048',
            'email'     => 'required|unique:users|email:dns',
            'alamat'    => 'required|min:4',
            'role'      => 'required',
            'username'  => 'required|unique:users|min:4',
            'password'  => 'required|unique:users|min:4'
        ]);

        if($request->file('image')){

            $validated['image'] = $request->file('image')->store('post-images');
        }

        $validated['password'] = Hash::make($validated['password']);
        

        Profil::create([
            'NIP'       => $validated['nip'],
            'kontak'    => $validated['kontak'],
            'alamat'    => $validated['alamat']
        ]);

        $lastIDProfil = Profil::latest()->first();
        $latestId = $lastIDProfil->id;

        User::create([
            'name'      => $validated['nama_lengkap'],
            'username'  => $validated['username'],
            'email'     => $validated['email'],
            'password'  => $validated['password'],
            'jabatan_id'=> $validated['jabatan'],
            'genders_id'=> $validated['gender'],
            'roles_id'  => $validated['role'],
            'profil_id' => $latestId,
            'image'     => $validated['image']

        ]);
        Alert::success('Good Job', 'User baru berhasil ditambahkan!');
        return redirect()->route('dashboard');

    }

    public function getJabatan($id){
        $jabatan = jabatan::where("organisasi_id",$id)->get();
        return response()->json($jabatan);
    }
    
}
