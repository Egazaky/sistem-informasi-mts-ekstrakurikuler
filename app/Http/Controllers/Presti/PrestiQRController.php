<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;

class PrestiQRController extends Controller
{
    public function index()
    {
        $siswa_id = session('presti_user_id');
        $siswa = PrestiSiswa::findOrFail($siswa_id);

        return view('presti.qr.index', compact('siswa'));
    }
}
