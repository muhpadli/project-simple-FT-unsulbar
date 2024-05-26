<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Level_user;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class jabatanController extends Controller
{
    
    //function create new record
    public function store(Request $request){
        // Validasi inputan form tambah jabatan
        $data   = $request->validate([
            // rules
            'jabatan'   =>  'required|min:6',
            'level_user'   =>  'required',
        ],[
            // messages
            'jabatan.required'  => 'field jabatan belum terisi',
            'jabatan.min'  => 'field berisi minimal terdiri atas 6 karakter',
            'level_user.required'  => 'field level user belum dipilih',
        ]);
        // nilai field organisasi_id inputan hidden
        $data['organisasi_id']  = $request->id_organisasi;
        //membuat data jabatan baru
        jabatan::create([
            'name'          => $data['jabatan'],
            'organisasi_id' => $data['organisasi_id'],
            'level_users_id' => $data['level_user'],
        ]);
        //menampilkan alert konfirmasi sukses
        Alert::success('Good Job', 'Jabatan Berhasil Ditambah!');
        // mengembalikan ke halaman daftar jabatan
        return redirect('/users/organisasi/jabatan/'. $request->id_organisasi)->with(['success' => 'Jabatan Berhasil Ditambah!']);
    }

    //function update record
    public function update(Request $request, $id){
        //validasi inputan edit jabatan
        $data   = $request->validate([
            // rules
            'jabatan'       => 'required|min:6',
            'level_user'    => 'required',
        ],[
            //messages
            'jabatan.required'  => 'field jabatan belum terisi',  
            'jabatan.min'  => 'field jabatan berisi minimal terdiri atas 6 karakter',  
            'level_user.required'  => 'field level user belum dipilih',  
        ]);
        //mengambil data jabatan yang akan diupdate
        $jabatan    = jabatan::findOrFail($id);
        //mengupdate data jabatan
        $jabatan->update([
            'name'  =>  $data['jabatan'],
            'level_users_id'  =>  $data['level_user']
        ]);
        //alert konfirmasi sukses mengupdate data
        Alert::success('Good Job', 'Jabatan berhasil di update!');
        //mengembalikan kehalaman daftar jabatan
        return redirect('/users/organisasi/jabatan/'. $request->id_organisasi)->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function show($id){
        $organisasi = Organization::findOrFail($id);
        $users = User::orderBy('created_at', 'desc')->paginate();
        $user = DB::table('users')
        ->join('profils', 'users.profil_id', '=', 'profils.id')
        ->join('genders', 'users.genders_id', '=', 'genders.id')
        ->join('jabatans', 'users.jabatan_id', '=', 'jabatans.id')
        ->select('users.name', 'users.id', 'users.jabatan_id', 'users.image', 'jabatans.name AS jabName', 'profils.NIP')
        ->orderBy('users.updated_at', 'desc')
        ->where('jabatans.organisasi_id','=',$id)
        ->get();
        $data_jabatan = jabatan::all()->where('organisasi_id', '=', $id);
        $level_users = Level_user::all()->where('tingkat','!=',0);
        return view('Admin.organisasi.jabatan',[
            'organisasi'    => $organisasi,
            'users'         => $users,
            'user'          => $user,
            'active'        => 'manageOrganisasi',
            'data'          => $data_jabatan,  
            'level_users'   => $level_users
        ]);
    }

    //function deleted record
    public function destroy($id){
        //mengambil data jabatan yang akan dihapus
        $jabatan = jabatan::findOrFail($id);
        //mwnghapus data jabatan
        $jabatan->delete();
        //alert konfirmasi menghapus data
        Alert::success('Good Job', 'Jabatan berhasil di hapus!');
        //mengembalikan kehalaman sebelumnya
        return back();
    }
}
