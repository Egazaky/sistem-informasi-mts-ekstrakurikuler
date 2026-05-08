<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SiswaModel;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        $data = [
                    'menu' => 'login'
                ];
        return view('login', $data);
    }
    public function prosesLogin(Request $req){
        $siswa = SiswaModel::where('is_active', '1')->where('username', $req->username)->where('password', $req->password)->get();
        if (count($siswa) != 0) {
            session()->put('level', 'siswa');
            session()->put('id_user', $siswa[0]->id);
            return to_route('minat-bakat');
        }

        $admin = User::where('name', $req->username)->where('password', $req->password)->get();
        if (count($admin) != 0) {
            session()->put('level', 'admin');
            session()->put('id_user', $admin[0]->id);
            return to_route('dashboard');
        }
        session()->flash('status', 'Cek username dan password');
        return to_route('login');

    }
    public function prosesLogout(Request $req){
        session()->forget('level');
        session()->forget('id_user');
        return to_route('landing');
    }
}
