<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class jabatanController extends Controller
{
    public function store(Request $request){
        $data   = $request->validate([
            'jabatan'   =>  'required|min:3',
            'role'      =>  'required'
        ]);

        $data['organisasi_id']  = $request->id_organisasi;
        
        jabatan::create([
            'name'          => $data['jabatan'],
            'organisasi_id' => $data['organisasi_id'],
            'role_id'       => $data['role']
        ]);

        Alert::success('Good Job', 'Jabatan Berhasil Ditambah!');
        return redirect()->route('viewJabatan', $request->id_organisasi)->with(['success' => 'Jabatan Berhasil Ditambah!']);
    }

    public function update(Request $request, $id){
        $data   = $request->validate([
            'jabatan'   => 'required|min:3',
            'role'      =>  'required'
        ]);

        $jabatan    = jabatan::findOrFail($id);
        
        $jabatan->update([
            'name'  =>  $data['jabatan'],
            'role_id'       => $data['role']
        ]);

        Alert::success('Good Job', 'Jabatan berhasil di update!');

        return redirect()->route('viewJabatan', $request->id_organisasi)->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function show($id){
        $jabatan = jabatan::with('organizations')->findOrFail($id);
        $users      = DB::table('users')
        ->join('profils', 'profils.id' ,'=','users.profil_id')
        ->join('roles', 'roles.id','=', 'users.roles_id')
        ->select('users.id', 'users.image', 'users.name', 'profils.NIP', 'profils.alamat', 'users.email')
        ->where([
            ['jabatan_id', '=', null],
            ['users.roles_id', '=', $jabatan->role_id ]
        ])
        ->get();

        $organisasi = Organization::all();
        
        return view('layout.Admin.tambah_user_jabatan',[
            'active'    => 'manageOrganisasi',
            'jabatan'   => $jabatan,
            'organisasi'=> $organisasi,
            'users'      => $users
        ]);
    }
}
