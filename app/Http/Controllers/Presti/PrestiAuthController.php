<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiAdmin;
use App\Models\Presti\PrestiGuru;
use App\Models\Presti\PrestiSiswa;
use App\Models\Presti\PrestiOrtu;

class PrestiAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('presti_role')) {
            return redirect('/presti');
        }
        return view('presti.login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = $request->input('username');
        $pass = md5($request->input('password'));

        // 1. Admin
        $admin = PrestiAdmin::where('username', $user)->where('password', $pass)->first();
        if ($admin) {
            session([
                'presti_role' => 'admin',
                'presti_user_id' => $admin->id,
                'presti_username' => $admin->username,
            ]);
            return redirect('/presti');
        }

        // 2. Guru
        $guru = PrestiGuru::where('username', $user)->where('password', $pass)->first();
        if ($guru) {
            session([
                'presti_role' => 'guru',
                'presti_user_id' => $guru->id,
                'presti_username' => $guru->username,
            ]);
            return redirect('/presti');
        }

        // 3. Siswa
        $siswa = PrestiSiswa::where('nis', $user)->where('password', $pass)->first();
        if ($siswa) {
            session([
                'presti_role' => 'siswa',
                'presti_user_id' => $siswa->id,
                'presti_username' => $siswa->nama,
            ]);
            return redirect('/presti');
        }

        // 4. Ortu
        $ortu = PrestiOrtu::where('username', $user)->where('password', $pass)->first();
        if ($ortu) {
            session([
                'presti_role' => 'ortu',
                'presti_user_id' => $ortu->siswa_id,
                'presti_username' => $ortu->username,
            ]);
            return redirect('/presti');
        }

        return redirect()->route('presti.login')->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['presti_role', 'presti_user_id', 'presti_username']);
        return redirect()->route('presti.login')->with('success', 'Anda telah berhasil logout.');
    }
}
