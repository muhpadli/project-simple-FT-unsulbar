<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class OrganizationController extends Controller
{
    public function index(){
        return view('layout.Admin.ManageOrganisasi',[
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
        return redirect()->route('organisasi')->with(['success' => 'Data Organisasi Berhasil Disimpan!']);
    }

    public function edit(string  $id){
        $Organisasi = Organization::findOrFail($id);

        return view('layout.Admin.editOrganisasi', [
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

        return redirect()->route('organisasi')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id){
        $organisasi = Organization::findOrFail($id);

        $organisasi->delete();
        Alert::success('Hore!','Organisasi berhasil terhapus!');
        return redirect()->route('organisasi')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
