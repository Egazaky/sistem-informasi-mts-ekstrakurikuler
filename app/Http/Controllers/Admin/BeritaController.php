<?php

namespace App\Http\Controllers\Admin;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::latest()->paginate(10);
        $menu = 'berita';
        return view('admin.berita.index', compact('berita', 'menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = 'berita';
        return view('admin.berita.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            // max in kilobytes (51200 KB ≈ 50 MB)
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:51200',
        ]);

        $data = [
            'title' => $validated['judul'],
            'content' => $validated['isi'],
        ];

        if ($request->hasFile('foto')) {
            $data['image'] = $request->file('foto')->store('images/berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil disimpan.');
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
        $berita = Berita::findOrFail($id);
        $menu = 'berita';
        return view('admin.berita.edit', compact('berita', 'menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            // max in kilobytes (51200 KB ≈ 50 MB)
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:51200',
        ]);

        $berita = Berita::findOrFail($id);
        $data = [
            'title' => $request->judul,
            'content' => $request->isi,
        ];

        if ($request->hasFile('foto')) {
            if ($berita->image) {
                Storage::disk('public')->delete($berita->image);
            }
            $data['image'] = $request->file('foto')->store('images/berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('berita.index')->with('success', 'Berita updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);
        if ($berita->image) {
            Storage::disk('public')->delete($berita->image);
        }
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita deleted successfully.');
    }
}
