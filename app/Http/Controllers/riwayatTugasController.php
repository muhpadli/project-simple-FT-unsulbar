<?php

namespace App\Http\Controllers;

use App\Models\riwayat_tugas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class riwayatTugasController extends Controller
{
    public function index(){

    }

    public function store(Request $request){
        $data   = $request->validate([
            'link_tugas'  => 'required|min:5',
            'tugas_id'    => 'required'
        ]);
        
        riwayat_tugas::create($data);

        Alert::success('Good Job', 'Tugas berhasil dibuat!');

        return redirect()->route('user_staf.show', $data['tugas_id']);
    }
}
