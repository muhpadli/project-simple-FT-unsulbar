<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use App\Models\Profil;
use App\Models\Riwayat_pendidikan;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class profilUserControlller extends Controller
{
    public function index()
    {
        //variabel untuk komponen sidebar
        $prioritas_status = Status::all();
        $prioritas_tugas = Priority::all();
        //query join mengambil data user
        $profil = DB::table('users')
            ->join('profils', 'profils.id', '=', 'users.profil_id')
            ->join('riwayat_pendidikans', 'users.id', '=', 'riwayat_pendidikans.user_id')
            ->join('jabatans', 'jabatans.id', '=', 'users.jabatan_id')
            ->join('organizations', 'organizations.id', '=', 'jabatans.organisasi_id')
            ->join('genders', 'genders.id', '=', 'users.genders_id')
            ->select('users.name', 'profils.NIP', 'profils.kontak', 'users.email', 'genders.namaGender AS jk', 'organizations.name AS nama_organisasi', 'jabatans.name AS nama_jabatan', 'users.jabatan_id', 'profils.alamat', 'users.image', 'riwayat_pendidikans.strata_1', 'riwayat_pendidikans.strata_2', 'riwayat_pendidikans.strata_3')
            ->where('users.id', '=', auth()->user()->id)
            ->get()
            ->first();
        //riwayat_pendidikan
        $study_in_history = Riwayat_pendidikan::where('user_id', '=', auth()->user()->id)
            ->get()
            ->first();

        if (auth()->user()->jabatan_id == null) {
            $profil = DB::table('users')
                ->join('profils', 'profils.id', '=', 'users.profil_id')
                ->join('riwayat_pendidikans', 'users.id', '=', 'riwayat_pendidikans.user_id')
                ->join('genders', 'genders.id', '=', 'users.genders_id')
                ->select('users.name', 'profils.NIP', 'profils.kontak', 'users.email', 'genders.namaGender AS jk', 'users.jabatan_id', 'profils.alamat', 'users.image', 'riwayat_pendidikans.strata_1', 'riwayat_pendidikans.strata_2', 'riwayat_pendidikans.strata_3')
                ->where('users.id', '=', auth()->user()->id)
                ->get()
                ->first();
        }

        return view('layout.profil_user', [
            'story_study' => $study_in_history,
            'data' => $profil,
            'active' => 'none',
            'priority' => 'none',
            'prioritas_tugas' => $prioritas_tugas,
            'prioritas_status' => $prioritas_status,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|min:3',
            'nip' => 'max:18',
            'kontak' => 'required|min:11',
            'email' => 'email',
            'alamat' => 'required|min:5',
            'image' => 'image|file|max:2048',
        ]);

        $user = User::findOrFail($id);
        $profil = Profil::findOrFail(auth()->user()->profil_id);

        if ($request->hasFile('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $data['image'] = $request->file('image')->store('post-images');

            $user->update([
                'name' => $data['nama'],
                'email' => $data['email'],
                'image' => $data['image'],
            ]);

            $profil->update([
                'NIP' => $data['nip'],
                'kontak' => $data['kontak'],
                'alamat' => $data['alamat'],
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
        } else {
            $user->update([
                'name' => $data['nama'],
                'email' => $data['email'],
            ]);

            $profil->update([
                'NIP' => $data['nip'],
                'kontak' => $data['kontak'],
                'alamat' => $data['alamat'],
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

        return redirect()
            ->route('profil.index')
            ->with(['success' => 'Data Berhasil Diubah!']);
    }
}
