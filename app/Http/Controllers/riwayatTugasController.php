<?php

namespace App\Http\Controllers;

use App\Models\riwayat_tugas;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class riwayatTugasController extends Controller
{
    public function index(){

    }

    public function store(Request $request){
        $data   = $request->validate([
            'link_tugas'  => 'required|min:6',
            'tugas_id'    => 'required'
        ],
        // pesan error 
        [
            'link_tugas.required'   => "link tugas belum terisi",
            'link_tugas.min'        => "link tugas minimal terdiri atas 6 karakter",
        ]);

        $data['waktu_selesai'] = Carbon::now('Asia/Makassar');
        $status_id = 5;
        $task = Task::findOrFail($data['tugas_id']);
        if($request->keterangan){
            $data['keterangan'] = $request->keterangan;
            riwayat_tugas::create([
                'link_tugas'    => $data['link_tugas'],
                'keterangan'    => $data['keterangan'],
                'tugas_id'      => $data['tugas_id'],
                'waktu_selesai' => $data['waktu_selesai']
            ]);
        }else{
            riwayat_tugas::create([
                'link_tugas'    => $data['link_tugas'],
                'tugas_id'      => $data['tugas_id'],
                'waktu_selesai' => $data['waktu_selesai']
            ]);
        }

        $task->update([
            'status_id' => $status_id,
        ]);

        Alert::success('Good Job', 'Tugas berhasil disubmit!');
        return redirect()->route('my-task.show', $data['tugas_id']);
    }
    public function update(Request $request, $id){
        $data   = $request->validate([
            'link_tugas'  => 'required|min:5',
        ]);

        $data['waktu_selesai'] = Carbon::now('Asia/Makassar');
        $status_id = 5;
        $task = Task::findOrFail($id);
        if($request->keterangan){
            $riwayat_tugas = riwayat_tugas::where('tugas_id','=',$id)->first();
            $data['keterangan'] = $request->keterangan;
            $riwayat_tugas->update([
                'link_tugas'    => $data['link_tugas'],
                'keterangan'    => $data['keterangan'],
                'waktu_selesai' => $data['waktu_selesai']
            ]);
        }else{
            $riwayat_tugas = riwayat_tugas::where('tugas_id','=',$id)->first();

            $riwayat_tugas->update([
                'link_tugas'    => $data['link_tugas'],
                'waktu_selesai' => $data['waktu_selesai']
            ]);
        }

        $task->update([
            'status_id' => $status_id,
        ]);

        Alert::success('Good Job', 'Tugas revision berhasil disubmit!');
        return redirect()->route('my-task.show', $id);
    }
}
