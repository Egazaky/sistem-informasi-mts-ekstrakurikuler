<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;

class PrestiPasswordController extends Controller
{
    public function index()
    {
        return view('presti.password.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:4',
            'konfirmasi_password' => 'required|same:password_baru',
        ]);

        $siswa_id = session('presti_user_id');
        $siswa = PrestiSiswa::findOrFail($siswa_id);

        $pass_lama_md5 = md5($request->input('password_lama'));

        if ($siswa->password !== $pass_lama_md5) {
            return redirect()->back()->with('error', 'Password lama salah!');
        }

        $siswa->update([
            'password' => md5($request->input('password_baru')),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
