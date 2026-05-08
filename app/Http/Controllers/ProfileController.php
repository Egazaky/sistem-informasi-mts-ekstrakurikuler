<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::first();
        return view('admin.profil', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::first();

        $request->validate([
            'about_title' => 'required|string|max:255',
            'about_description' => 'required|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'kepala_sekolah_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'kepala_sekolah_nama' => 'required|string|max:255',
            'kepala_sekolah_sambutan' => 'required|string',
            'registration_barcode' => 'nullable|image|mimes:jpeg,png,jpg|max:20480',
            'google_maps_link' => 'nullable|string',
        ]);

        // Update text fields
        $profile->about_title = $request->about_title;
        $profile->about_description = $request->about_description;
        $profile->kepala_sekolah_nama = $request->kepala_sekolah_nama;
        $profile->kepala_sekolah_sambutan = $request->kepala_sekolah_sambutan;
        $profile->google_maps_link = $request->google_maps_link;

        // Handle image uploads
        if ($request->hasFile('about_image')) {
            // Delete old image if exists
            if ($profile->about_image) {
                Storage::disk('public')->delete($profile->about_image);
            }
            // Store new image
            $profile->about_image = $request->file('about_image')->store('profile-images', 'public');
        }

        if ($request->hasFile('kepala_sekolah_foto')) {
            // Delete old image if exists
            if ($profile->kepala_sekolah_foto) {
                Storage::disk('public')->delete($profile->kepala_sekolah_foto);
            }
            // Store new image
            $profile->kepala_sekolah_foto = $request->file('kepala_sekolah_foto')->store('profile-images', 'public');
        }

        if ($request->hasFile('registration_barcode')) {
            // Delete old image if exists
            if ($profile->registration_barcode) {
                Storage::disk('public')->delete($profile->registration_barcode);
            }
            // Store new image
            $profile->registration_barcode = $request->file('registration_barcode')->store('profile-images', 'public');
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
