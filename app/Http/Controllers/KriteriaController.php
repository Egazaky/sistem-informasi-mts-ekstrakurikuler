<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KriteriaModel;

class KriteriaController extends Controller
{
    //
    public function index(){
        $data = [
                    'menu' => 'kriteria',
                    'aksi' => 'tampil',
                    'kriteria' => KriteriaModel::where('is_active', '1')->get()
                ];
        return view('admin/kriteria', $data);
    }
    public function tambah(){
        $data = [
                    'menu' => 'kriteria',
                    'aksi' => 'tambah',
                ];
        return view('admin/kriteria', $data);
    }
    public function prosesTambah(Request $req){
        KriteriaModel::create(['nama_kriteria' => $req->nama,'bobot' => $req->bobot, 'is_active' => '1']);
        return to_route('data-kriteria');
    }
    public function hapus(Request $req){
        KriteriaModel::where('id', $req->id)->update(['is_active' => '0']);
        return to_route('data-kriteria');
    }
}
