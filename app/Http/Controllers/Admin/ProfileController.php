<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::firstOrCreate([]);
        $menu = 'profil';
        return view('admin.profil', compact('profile', 'menu'));
    }

    public function update(Request $request)
    {
        $profile = Profile::firstOrCreate([]);
        
        $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'whatsapp_link' => 'nullable|url',
            'tagline' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'kepala_sekolah_nama' => 'nullable|string|max:255',
            'kepala_sekolah_sambutan' => 'nullable|string',
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'google_maps_link' => 'nullable|string',
            'kepala_sekolah_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
            'registration_barcode' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        $data = $request->except('_token');

        foreach (['kepala_sekolah_foto', 'about_image', 'registration_barcode'] as $imageField) {
            if ($request->hasFile($imageField)) {
                if ($profile->{$imageField}) {
                    Storage::disk('public')->delete($profile->{$imageField});
                }
                $data[$imageField] = $request->file($imageField)->store('images/profile', 'public');
            } else if ($request->has($imageField . '_remove') && $profile->{$imageField}) { // Handle image removal
                Storage::disk('public')->delete($profile->{$imageField});
                $data[$imageField] = null;
            }
        }

        $profile->update($data);

        return back()->with('success', 'Profil berhasil diupdate!');
    }
}