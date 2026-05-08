<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class PertanyaanController extends Controller
{
    public function index(){
        $data = [
            'menu' => 'pertanyaan',
            'aksi' => 'tampil',
            'pertanyaan' => Question::orderBy('kategori')->orderBy('objek_pilihan')->orderBy('urutan')->get()
        ];
        return view('admin/pertanyaan', $data);
    }

    public function tambah(){
        $data = [
            'menu' => 'pertanyaan',
            'aksi' => 'tambah',
        ];
        return view('admin/pertanyaan', $data);
    }

    public function prosesUbah(Request $req){
        $data = [
            'kategori' => $req->kategori,
            'objek_pilihan' => $req->objek_pilihan,
            'pernyataan' => $req->pernyataan,
        ];
        Question::where('id', $req->id)->update($data);
        return to_route('pertanyaan');
    }

    public function prosesTambah(Request $req){
        Question::create([
            'kategori' => $req->kategori,
            'objek_pilihan' => $req->objek_pilihan,
            'pernyataan' => $req->pernyataan,
            'urutan' => 1,
        ]);
        return to_route('pertanyaan');
    }

    public function hapus(Request $req){
        Question::where('id', $req->id)->delete();
        return to_route('pertanyaan');
    }

    public function ubah(Request $req){
        $data = [
            'menu' => 'pertanyaan',
            'aksi' => 'ubah',
            'pertanyaan' => Question::where('id', $req->id)->get()
        ];
        return view('admin/pertanyaan', $data);
    }
}
