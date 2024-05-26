<?php

namespace App\Http\Controllers;

use App\Models\jabatan;
use App\Models\Level_user;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class OrganizationController extends Controller
{
    public function index()
    {
        $organisasi = Organization::with('jabatans')->get();
        $jabatan = DB::table('jabatans')->join('users', 'users.jabatan_id', '=', 'jabatans.id')->select('users.name', 'jabatans.id', 'jabatans.organisasi_id')->get();
        return view('Admin.organisasi.index', [
            'data' => $organisasi,
            'jabatan' => $jabatan,
            'active' => 'manageOrganisasi',
        ]);
    }

    public function create(){
        return view('Admin.organisasi.create',[
            'active' => 'manageOrganisasi'
        ]);
    }

    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [
            'organisasi' => 'required|min:3',
        ]);

        Organization::create([
            'name' => $request->organisasi
        ]);

        Alert::success('Good Job', 'Organisasi berhasil dibuat!');
        return redirect()->route('organisasi.index')->with(['success' => 'Data Organisasi Berhasil Disimpan!']);
    }


    public function edit(string  $id){
        $Organisasi = Organization::findOrFail($id);

        return view('Admin.organisasi.edit', [
            'organisasi' => $Organisasi,
            'active' => 'manageOrganisasi'
        ]);
    }

    public function update(Request $request, $id){
        //validate form
        $this->validate($request, [
            'organisasi' => 'required|min:3'
        ]);

        //get post by ID
        $organisasi= Organization::findOrFail($id);

        $organisasi ->update([
            'name'     => $request->organisasi
        ]);

        Alert::success('Good Job', 'Organisasi berhasil di update!');
        return redirect()->route('organisasi.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id){
        $organisasi = Organization::findOrFail($id);

        $organisasi->delete();
        Alert::success('Hore!','Organisasi berhasil terhapus!');
        return redirect()->route('organisasi.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
