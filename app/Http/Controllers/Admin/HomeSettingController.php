<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;

class HomeSettingController extends Controller
{
    public function index()
    {
        $setting = HomeSetting::first();
        if (!$setting) {
            $setting = HomeSetting::create([]);
        }
        return view('admin.home-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = HomeSetting::first();
        if (!$setting) {
            $setting = HomeSetting::create([]);
        }
        $data = $request->validate([
            'judul_utama' => 'nullable|string',
            'subjudul_utama' => 'nullable|string',
            'mengapa_pilih_kami' => 'nullable|string',
            'akreditasi' => 'nullable|string',
            'deskripsi_akreditasi' => 'nullable|string',
            'fasilitas' => 'nullable|string',
            'alumni_sukses' => 'nullable|string',
            'sambutan_kepala_sekolah' => 'nullable|string',
            'foto_kepala_sekolah' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|string',
            'footer' => 'nullable|string',
        ]);
        $setting->update($data);
        return redirect()->back()->with('success', 'Pengaturan beranda berhasil diperbarui.');
    }
}
