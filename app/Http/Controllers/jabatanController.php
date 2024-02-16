<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Organization;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class jabatanController extends Controller
{
    public function store(Request $request){
        $data   = $request->validate([
            'jabatan'   =>  'required|min:3'
        ]);

        $data['organisasi_id']  = $request->id_organisasi;
        
        jabatan::create([
            'name'      => $data['jabatan'],
            'organisasi_id' =>  $data['organisasi_id']
        ]);

        Alert::success('Good Job', 'Jabatan Berhasil Ditambah!');
        return redirect()->route('viewJabatan', $request->id_organisasi)->with(['success' => 'Jabatan Berhasil Ditambah!']);
    }

    public function update(Request $request, $id){
        $data   = $request->validate([
            'jabatan'   => 'required|min:3'
        ]);

        $jabatan    = jabatan::findOrFail($id);
        
        $jabatan->update([
            'name'  =>  $data['jabatan']
        ]);

        Alert::success('Good Job', 'Jabatan berhasil di update!');

        return redirect()->route('viewJabatan', $request->id_organisasi)->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function show($id){
        $organisasi = Organization::all();
        $jabatan = jabatan::with('organizations')->findOrFail($id);
        return view('layout.Admin.tambah_user_jabatan',[
            'active'    => 'manageOrganisasi',
            'jabatan'   => $jabatan,
            'organisasi'=> $organisasi
        ]);
    }
}
