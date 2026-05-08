<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationSettingsController extends Controller
{
    public function index()
    {
        $content = RegistrationSettings::first();
        if (!$content) {
            $content = RegistrationSettings::create([]);
        }
        return view('admin.pendaftaran.settings', [
            'menu' => 'registration-settings',
            'content' => $content
        ]);
    }

    public function edit()
    {
        $setting = RegistrationSettings::first();
        return view('admin.pendaftaran.settings', compact('setting'));
    }

    public function update(Request $request)
{
    $setting = RegistrationSettings::first();
    if (!$setting) {
        $setting = RegistrationSettings::create([]);
    }


    $data = $request->except(['program_unggulan_images','aspek_strategis_images','daftar_ekstrakurikuler_images']);

    // Ubah array menjadi string biar disimpan di kolom
    if ($request->has('syarat_pendaftaran')) {
        $data['syarat_pendaftaran'] = implode('|', $request->syarat_pendaftaran);
    }
    if ($request->has('program_unggulan')) {
        $data['program_unggulan'] = implode('|', $request->program_unggulan);
    }
    if ($request->has('aspek_strategis')) {
        $data['aspek_strategis'] = implode('|', $request->aspek_strategis);
    }
    if ($request->has('daftar_ekstrakurikuler')) {
        $data['daftar_ekstrakurikuler'] = implode('|', $request->daftar_ekstrakurikuler);
    }
    if ($request->has('narahubung')) {
        $data['narahubung'] = implode('|', $request->narahubung);
    }

    // Handle upload gambar per item
    $program_unggulan_images = [];
    $aspek_strategis_images = [];
    $daftar_ekstrakurikuler_images = [];

    // Simpan gambar program unggulan
    if ($request->hasFile('program_unggulan_images')) {
        foreach ($request->file('program_unggulan_images') as $i => $file) {
            if ($file) {
                $path = $file->store('public/pendaftaran');
                $program_unggulan_images[$i] = str_replace('public/', '', $path);
            } else if ($setting->program_unggulan_images) {
                $old = explode('|', $setting->program_unggulan_images);
                $program_unggulan_images[$i] = $old[$i] ?? '';
            } else {
                $program_unggulan_images[$i] = '';
            }
        }
        $data['program_unggulan_images'] = implode('|', $program_unggulan_images);
    } else if ($setting->program_unggulan_images) {
        $data['program_unggulan_images'] = $setting->program_unggulan_images;
    }

    // Simpan gambar aspek strategis
    if ($request->hasFile('aspek_strategis_images')) {
        foreach ($request->file('aspek_strategis_images') as $i => $file) {
            if ($file) {
                $path = $file->store('public/pendaftaran');
                $aspek_strategis_images[$i] = str_replace('public/', '', $path);
            } else if ($setting->aspek_strategis_images) {
                $old = explode('|', $setting->aspek_strategis_images);
                $aspek_strategis_images[$i] = $old[$i] ?? '';
            } else {
                $aspek_strategis_images[$i] = '';
            }
        }
        $data['aspek_strategis_images'] = implode('|', $aspek_strategis_images);
    } else if ($setting->aspek_strategis_images) {
        $data['aspek_strategis_images'] = $setting->aspek_strategis_images;
    }

    // Simpan gambar ekstrakurikuler
    if ($request->hasFile('daftar_ekstrakurikuler_images')) {
        foreach ($request->file('daftar_ekstrakurikuler_images') as $i => $file) {
            if ($file) {
                $path = $file->store('public/pendaftaran');
                $daftar_ekstrakurikuler_images[$i] = str_replace('public/', '', $path);
            } else if ($setting->daftar_ekstrakurikuler_images) {
                $old = explode('|', $setting->daftar_ekstrakurikuler_images);
                $daftar_ekstrakurikuler_images[$i] = $old[$i] ?? '';
            } else {
                $daftar_ekstrakurikuler_images[$i] = '';
            }
        }
        $data['daftar_ekstrakurikuler_images'] = implode('|', $daftar_ekstrakurikuler_images);
    } else if ($setting->daftar_ekstrakurikuler_images) {
        $data['daftar_ekstrakurikuler_images'] = $setting->daftar_ekstrakurikuler_images;
    }

    $setting->update($data);

    return redirect()->route('admin.pendaftaran.settings')
        ->with('success', 'Pengaturan halaman pendaftaran berhasil diperbarui.');
}

}
