<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        $profile = Profile::firstOrCreate([]);
        $menu = 'gallery';
        return view('admin.gallery.index', compact('galleries', 'menu', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = 'gallery';
        return view('admin.gallery.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // max in kilobytes (51200 KB ≈ 50 MB)
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:51200',
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('images/gallery', 'public');

        Gallery::create([
            'image_path' => $imagePath,
            'caption' => $validated['caption'] ?? null,
        ]);

        return redirect()->route('gallery.index')->with('success', 'Gambar galeri berhasil diupload.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not used for this resource
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        $menu = 'gallery';
        return view('admin.gallery.edit', compact('gallery', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $gallery = Gallery::findOrFail($id);
        $gallery->update(['caption' => $request->caption]);

        return redirect()->route('gallery.index')->with('success', 'Caption updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully.');
    }

    public function updateAbout(Request $request)
    {
        $profile = Profile::firstOrCreate([]);

        $request->validate([
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        $data = $request->only(['about_title', 'about_description']);

        if ($request->hasFile('about_image')) {
            if ($profile->about_image) {
                Storage::disk('public')->delete($profile->about_image);
            }
            $data['about_image'] = $request->file('about_image')->store('images/profile', 'public');
        }

        $profile->update($data);

        return redirect()->route('gallery.index')->with('success', 'Konten Tentang Kami berhasil diperbarui.');
    }
}
