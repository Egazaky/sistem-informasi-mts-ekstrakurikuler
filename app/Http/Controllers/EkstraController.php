<?php

namespace App\Http\Controllers;

use App\Models\EkstraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EkstraController extends Controller
{
    public function index(){
        $data = [
                    'menu'      => 'ekstra',
                    'aksi'      => 'tampil',
                    'ekstra'    => EkstraModel::where('is_active', '1')->get()
                ];
        return view('admin/ekstra', $data);
    }
    public function tambah(){
        $data = [
                    'menu'      => 'ekstra',
                    'aksi'      => 'tambah'
                ];
        return view('admin/ekstra', $data);
    }
    public function edit(Request $req){
        $ekstra = EkstraModel::where('is_active', '1')->where('id', $req->id)->get();
        $data = [
                    'menu'      => 'ekstra',
                    'aksi'      => 'edit',
                    'ekstra'    => $ekstra
                ];
        return view('admin/ekstra', $data);
    }

    public function prosesTambah(Request $req){
        $this->validate($req, [
            'gambar' => 'required|file|max:7000',
        ]);
        $imageName = time().'.'.$req->gambar->extension();
        $image_path = $req->file('gambar')->storeAs('public/images', $imageName);

        EkstraModel::create([
            'nama_ekstra' => $req->nama,
            'deskripsi' => $req->deskripsi,
            'kategori' => $req->kategori,
            'objek_pilihan' => $req->objek_pilihan,
            'jadwal_hari' => $req->jadwal_hari,
            'jadwal_jam' => $req->jadwal_jam,
            'nm_guru' => $req->nm_guru,
            'gambar' =>  $imageName,
            'is_active' => '1'
        ]);
        return to_route('data-ekstra');
    }
    public function prosesEdit(Request $req){
        if (empty($req->gambar)) {
            EkstraModel::where('id', $req->id)->update([
                'nama_ekstra' => $req->nama,
                'deskripsi' => $req->deskripsi,
                'kategori' => $req->kategori,
                'objek_pilihan' => $req->objek_pilihan,
                'jadwal_hari' => $req->jadwal_hari,
                'jadwal_jam' => $req->jadwal_jam,
                'nm_guru' => $req->nm_guru,
                'is_active' => '1'
            ]);
        }else{
            $imageName = time().'.'.$req->gambar->extension();
            $image_path = $req->file('gambar')->storeAs('public/images', $imageName);
            EkstraModel::where('id', $req->id)->update([
                'nama_ekstra' => $req->nama,
                'deskripsi' => $req->deskripsi,
                'kategori' => $req->kategori,
                'objek_pilihan' => $req->objek_pilihan,
                'jadwal_hari' => $req->jadwal_hari,
                'jadwal_jam' => $req->jadwal_jam,
                'nm_guru' => $req->nm_guru,
                'gambar' =>  $imageName,
                'is_active' => '1'
            ]);
            if(File::exists($req->gambar_lama)){
                File::delete($req->gambar_lama);
            }
        }
        return to_route('data-ekstra');
    }
    public function hapus(Request $req){
        EkstraModel::where('id', $req->id)->update(['is_active' => '0']);
        return to_route('data-ekstra');
    }
}
