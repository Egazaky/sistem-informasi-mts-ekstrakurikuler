<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use App\Models\EkstraModel;

class MinatBakatController extends Controller
{
    // Tampilkan form kuesioner
    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = $user ? $user->id : session('id_user');
    $siswa = \App\Models\SiswaModel::find($user_id);
    // Jika ada request ulang=1, paksa tampilkan form soal meskipun status 1
    if ($siswa && $siswa->status == '1' && !$request->has('ulang')) {
            $minat = \App\Models\Answer::where('user_id', $user_id)->where('kategori', 'minat')->sum('value');
            $bakat = \App\Models\Answer::where('user_id', $user_id)->where('kategori', 'bakat')->sum('value');
            $bakat_objek = \App\Models\Answer::where('answers.user_id', $user_id)
                ->where('answers.kategori', 'bakat')
                ->join('questions', 'answers.question_id', '=', 'questions.id')
                ->select('questions.objek_pilihan')
                ->groupBy('questions.objek_pilihan')
                ->orderByRaw('SUM(answers.value) DESC')
                ->limit(1)
                ->pluck('questions.objek_pilihan')
                ->first();
            $kecerdasan_dominan = $bakat_objek ?? '-';
            $bakatQuery = \App\Models\EkstraModel::where('is_active', '1');
            if ($kecerdasan_dominan !== '-') {
                $bakatQuery = $bakatQuery->where(function($q) use ($kecerdasan_dominan) {
                    $q->where('bakat', $kecerdasan_dominan)
                      ->orWhere('bakat', 'like', '%'.$kecerdasan_dominan.'%');
                    if (strtolower($kecerdasan_dominan) == 'logika') {
                        $q->orWhere('bakat', 'like', '%Logika-Matematika%');
                    }
                    if (strtolower($kecerdasan_dominan) == 'visual') {
                        $q->orWhere('bakat', 'like', '%Visual-Spasial%');
                    }
                });
            }
            $rekomendasi_ekstra = $bakatQuery->pluck('nama_ekstra')->toArray();
            $rekomendasi = count($rekomendasi_ekstra) ? implode(', ', $rekomendasi_ekstra) : 'Belum ada rekomendasi sesuai hasil bakat.';
            $minat_objek = \App\Models\Answer::where('answers.user_id', $user_id)
                ->where('answers.kategori', 'minat')
                ->join('questions', 'answers.question_id', '=', 'questions.id')
                ->select('questions.objek_pilihan')
                ->groupBy('questions.objek_pilihan')
                ->orderByRaw('SUM(answers.value) DESC')
                ->limit(1)
                ->pluck('questions.objek_pilihan')
                ->first();
            return view('siswa.hasil', compact('kecerdasan_dominan', 'minat_objek', 'rekomendasi', 'minat', 'bakat'));
        }
        $questions = Question::orderBy('kategori')->orderBy('objek_pilihan')->orderBy('urutan')->get();
        // Ambil jawaban terakhir user
        $jawaban_terakhir = [];
        $answers = \App\Models\Answer::where('user_id', $user_id)->get();
        foreach ($answers as $ans) {
            $jawaban_terakhir[$ans->question_id] = $ans->value;
        }
        return view('siswa.soal', compact('questions', 'jawaban_terakhir'));
    }

    // Simpan jawaban siswa
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user ? $user->id : session('id_user');

        $data = $request->input('jawaban');
        foreach ($data as $question_id => $value) {
            $question = Question::find($question_id);
            if ($question) {
                Answer::updateOrCreate([
                    'user_id' => $user_id,
                    'question_id' => $question_id,
                ], [
                    'kategori' => $question->kategori,
                    'value' => $value,
                ]);
            }
        }
        // Hitung skor minat & bakat
        $minat = Answer::where('user_id', $user_id)->where('kategori', 'minat')->sum('value');
        $bakat = Answer::where('user_id', $user_id)->where('kategori', 'bakat')->sum('value');

        // Cari objek_pilihan dengan skor terbanyak di bakat
        $bakat_objek = Answer::where('answers.user_id', $user_id)
            ->where('answers.kategori', 'bakat')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->select('questions.objek_pilihan')
            ->groupBy('questions.objek_pilihan')
            ->orderByRaw('SUM(answers.value) DESC')
            ->limit(1)
            ->pluck('questions.objek_pilihan')
            ->first();


        // Cek kecerdasan dominan (bakat_objek)
        $kecerdasan_dominan = $bakat_objek ?? '-';
        $bakatQuery = \App\Models\EkstraModel::where('is_active', '1');
        if ($kecerdasan_dominan !== '-') {
            $bakatQuery = $bakatQuery->where(function($q) use ($kecerdasan_dominan) {
                $q->where('bakat', $kecerdasan_dominan)
                  ->orWhere('bakat', 'like', '%'.$kecerdasan_dominan.'%');
                if (strtolower($kecerdasan_dominan) == 'logika') {
                    $q->orWhere('bakat', 'like', '%Logika-Matematika%');
                }
                if (strtolower($kecerdasan_dominan) == 'visual') {
                    $q->orWhere('bakat', 'like', '%Visual-Spasial%');
                }
            });
        }
        $rekomendasi_ekstra = $bakatQuery->pluck('nama_ekstra')->toArray();
        $rekomendasi = count($rekomendasi_ekstra) ? implode(', ', $rekomendasi_ekstra) : 'Belum ada rekomendasi sesuai hasil bakat.';

        // Cari bidang minat yang relevan (objek_pilihan minat tertinggi)
        $minat_objek = Answer::where('answers.user_id', $user_id)
            ->where('answers.kategori', 'minat')
            ->join('questions', 'answers.question_id', '=', 'questions.id')
            ->select('questions.objek_pilihan')
            ->groupBy('questions.objek_pilihan')
            ->orderByRaw('SUM(answers.value) DESC')
            ->limit(1)
            ->pluck('questions.objek_pilihan')
            ->first();

        \App\Models\SiswaModel::where('id', $user_id)->update(['status' => '1']);

        return view('siswa.hasil', compact('kecerdasan_dominan', 'minat_objek', 'rekomendasi', 'minat', 'bakat'));
    }
}
