<?php

namespace App\Http\Controllers;

use App\Models\SiswaModel;
use App\Models\WaliKelas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JawabSiswaModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;


class SiswaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        Excel::import(new SiswaImport, $request->file('file'));
        return redirect()->route('data-siswa')->with('success', 'Data siswa berhasil diimport!');
    }
    public function index(Request $request){
        $kelas = $request->query('kelas');
        $query = SiswaModel::where('is_active', '1');
        $allSiswa = $query->get();
        // Ambil semua kelas unik dari data siswa
        $daftar_kelas = $allSiswa->pluck('kelas')->unique()->sort()->values();
        // Ambil wali kelas untuk kelas aktif
        $wali_kelas = null;
        if ($kelas) {
            $wali = WaliKelas::where('kelas', $kelas)->first();
            if ($wali) {
                $wali_kelas = $wali->nama_wali;
            }
        }
        $data = [
            'menu'  => 'siswa',
            'aksi' => 'tampil',
            'siswa' => $allSiswa,
            'jawab' => JawabSiswaModel::select('siswa_id')->distinct()->get(),
            'daftar_kelas' => $daftar_kelas,
            'wali_kelas' => $wali_kelas,
        ];
        return view('admin/siswa', $data);
    }
    public function tambah(){
        // Ambil semua siswa aktif untuk daftar kelas
        $allSiswa = SiswaModel::where('is_active', '1')->get();
        $daftar_kelas = $allSiswa->pluck('kelas')->unique()->sort()->values();
        $kelas = request('kelas');
        // Ambil wali kelas untuk kelas aktif
        $wali_kelas = null;
        if ($kelas) {
            $wali = WaliKelas::where('kelas', $kelas)->first();
            if ($wali) {
                $wali_kelas = $wali->nama_wali;
            }
        }
        $data = [
            'menu'  => 'siswa',
            'aksi' => 'tambah',
            'siswa' => SiswaModel::get(),
            'daftar_kelas' => $daftar_kelas,
            'wali_kelas' => $wali_kelas,
            'kelas' => $kelas,
        ];
        return view('admin/siswa', $data);
    }
    public function prosesTambah(Request $req){
        $jmlSiswa = SiswaModel::count()+1;
        $pass = Str::random(5);
        $data = [
            'nama_siswa' => $req->nama,
            'kelas' => $req->kelas,
            'jen_kel' => $req->jen_kel,
            'password' => $pass,
            'status' => '0',
            'is_active' => '1',
            'username' => 'sis25'.$jmlSiswa
        ];
        $cek = SiswaModel::create($data);
        return to_route('data-siswa');
    }
    public function ubah(Request $req){
        $siswa = SiswaModel::where('id', $req->id)->get();
        // Ambil semua siswa aktif untuk daftar kelas
        $allSiswa = SiswaModel::where('is_active', '1')->get();
        $daftar_kelas = $allSiswa->pluck('kelas')->unique()->sort()->values();
        $kelas = $req->query('kelas', $siswa[0]->kelas ?? null);
        // Ambil wali kelas untuk kelas aktif
        $wali_kelas = null;
        if ($kelas) {
            $wali = WaliKelas::where('kelas', $kelas)->first();
            if ($wali) {
                $wali_kelas = $wali->nama_wali;
            }
        }
        $data = [
            'menu'  => 'siswa',
            'aksi' => 'ubah',
            'siswa' => $siswa,
            'daftar_kelas' => $daftar_kelas,
            'wali_kelas' => $wali_kelas,
            'kelas' => $kelas,
        ];
        return view('admin/siswa', $data);
    }
    public function prosesUbah(Request $req){
        $data = [
            'nama_siswa' => $req->nama,
            'kelas' => $req->kelas,
            'jen_kel' => $req->jen_kel,
        ];
        $cek = SiswaModel::where('id', $req->id)->update($data);
        return to_route('data-siswa');
    }
    public function hapus(Request $req){
        SiswaModel::where('id', $req->id)->update(['is_active' => '0']);
        $kelas = $req->query('kelas');
        if ($kelas) {
            return redirect()->route('data-siswa', ['kelas' => $kelas]);
        }
        return to_route('data-siswa');
    }

    public function siswaProfil(){
        $data = ['siswa' => SiswaModel::where('id', session()->get('id_user'))->get()];
        return view('siswa/profil', $data);
    }
    public function updateUsername(Request $req){
        $data = SiswaModel::where('username', $req->user_old)->get();
        if (count($data) != 0) {
            $user = SiswaModel::where('id', $req->id)->where('password', $req->password)->get();
            if (count($user) != 0) {
                SiswaModel::where('id', $req->id)->update(['username' => $req->user_new]);
                $req->session()->flash('status_ket', '1');
                return to_route('siswa_profil');
            }else{
                $req->session()->flash('status_ket', '2');
                $req->session()->flash('status_ket', 'password salah');
                return to_route('siswa_profil');
            }
        }else{
            $req->session()->flash('status_ket', '2');
                $req->session()->flash('status_ket', 'Masukkan username lain');
                return to_route('siswa_profil');
        }
    }
    public function updatePassword(Request $req){
            $user = SiswaModel::where('id', $req->id)->where('password', $req->password_lama)->get();
            if (count($user) != 0) {
                SiswaModel::where('id', $req->id)->update(['password' => $req->password_baru]);
                $req->session()->flash('status_ket_p', '1');
                return to_route('siswa_profil');
            }else{
                $req->session()->flash('status_ket_p', 'Password salah');
                return to_route('siswa_profil');
            }

    }
    // Tambah method untuk update wali kelas
    public function updateWaliKelas(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'nama_wali' => 'required',
        ]);
        WaliKelas::updateOrCreate(
            ['kelas' => $request->kelas],
            ['nama_wali' => $request->nama_wali]
        );
        return redirect()->back()->with('success', 'Wali kelas berhasil diupdate!');
    }
}
