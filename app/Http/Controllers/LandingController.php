<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Profile;
use App\Models\Gallery;
use App\Models\Guru;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Models\RegistrationSettings;

class LandingController extends Controller
{
    public function index()
    {
        $homeSetting = HomeSetting::first();
        $profile = Profile::first();
        $berita = Berita::latest()->take(3)->get();
        $galleries = Gallery::latest()->take(6)->get();
        return view('landing.home', compact('homeSetting', 'profile', 'berita', 'galleries'));
    }

    public function berita()
    {
        $berita = Berita::latest()->paginate(6);
        return view('landing.berita', compact('berita'));
    }

    public function tentangKami()
    {
        $profile = Profile::first();
        $galleries = Gallery::latest()->paginate(9);
        $gurus = Guru::latest()->get();

        return view('landing.tentang-kami', compact('profile', 'galleries', 'gurus'));
    }

    public function showBerita($id)
    {
        $berita = Berita::findOrFail($id);
        return view('landing.berita-show', compact('berita'));
    }

    public function profil()
    {
        $profile = Profile::first();
        return view('landing.profil', compact('profile'));
    }

    public function pendaftaran()
    {
        $content = RegistrationSettings::first();
        return view('landing.pendaftaran', compact('content'));
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:zip,rar|max:10240', // 10MB max
        ]);

        // Simpan data pendaftaran ke database
        $pendaftaran = new \App\Models\Pendaftaran();
        $pendaftaran->nama_lengkap = $request->nama_lengkap;
        $pendaftaran->nama_panggilan = $request->nama_panggilan;
        $pendaftaran->tempat_lahir = $request->tempat_lahir;
        $pendaftaran->tanggal_lahir = $request->tanggal_lahir;
        $pendaftaran->jenis_kelamin = $request->jenis_kelamin;
        $pendaftaran->agama = $request->agama;
        $pendaftaran->alamat = $request->alamat;
        $pendaftaran->no_hp = $request->no_hp;
        $pendaftaran->email = $request->email;
        $pendaftaran->nama_ayah = $request->nama_ayah;
        $pendaftaran->nama_ibu = $request->nama_ibu;
        $pendaftaran->pekerjaan_ayah = $request->pekerjaan_ayah;
        $pendaftaran->pekerjaan_ibu = $request->pekerjaan_ibu;
        $pendaftaran->asal_sekolah = $request->asal_sekolah;
        $pendaftaran->status = 'pending';
        $pendaftaran->tahun_ajaran = '2025/2026';

        // Handle file upload
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen_pendaftaran', $filename);
            $pendaftaran->dokumen_path = $filename;
        }

        $pendaftaran->save();

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
