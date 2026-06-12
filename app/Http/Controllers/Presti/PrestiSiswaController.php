<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;
use App\Models\Presti\PrestiOrtu;
use App\Models\Presti\PrestiAbsensi;
use App\Models\Presti\PrestiTagihan;
use Illuminate\Support\Facades\DB;

class PrestiSiswaController extends Controller
{
    public function index(Request $request)
    {
        $filter_kelas = $request->get('filter_kelas', '');

        $query = PrestiSiswa::orderBy('nis', 'asc');
        if (!empty($filter_kelas)) {
            $query->where('kelas', $filter_kelas);
        }
        $siswa = $query->get();

        $kelas_list = PrestiSiswa::select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas', 'asc')
            ->pluck('kelas');

        return view('presti.siswa.index', compact('siswa', 'kelas_list', 'filter_kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|max:20|unique:presti_siswa,nis',
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:100',
            'no_hp_ortu' => 'nullable|string|max:20',
        ]);

        $nis = $request->input('nis');
        $password_default = md5($nis);

        DB::transaction(function () use ($request, $nis, $password_default) {
            $siswa = PrestiSiswa::create([
                'nis' => $nis,
                'nama' => $request->input('nama'),
                'kelas' => $request->input('kelas'),
                'no_hp_ortu' => $request->input('no_hp_ortu'),
                'password' => $password_default,
            ]);

            // Auto create ortu
            if ($request->filled('no_hp_ortu')) {
                PrestiOrtu::create([
                    'siswa_id' => $siswa->id,
                    'username' => 'ortu_' . $nis,
                    'password' => $password_default,
                ]);
            }
        });

        return redirect()->route('presti.siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $siswa = PrestiSiswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|max:20|unique:presti_siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:100',
            'no_hp_ortu' => 'nullable|string|max:20',
        ]);

        $nis = $request->input('nis');

        DB::transaction(function () use ($siswa, $request, $nis) {
            $siswa->update([
                'nis' => $nis,
                'nama' => $request->input('nama'),
                'kelas' => $request->input('kelas'),
                'no_hp_ortu' => $request->input('no_hp_ortu'),
            ]);

            // Update or create ortu username
            $ortu = PrestiOrtu::where('siswa_id', $siswa->id)->first();
            if ($ortu) {
                $ortu->update([
                    'username' => 'ortu_' . $nis,
                ]);
            } else if ($request->filled('no_hp_ortu')) {
                // If previously empty, create parent account
                $password_default = md5($nis);
                PrestiOrtu::create([
                    'siswa_id' => $siswa->id,
                    'username' => 'ortu_' . $nis,
                    'password' => $password_default,
                ]);
            }
        });

        return redirect()->route('presti.siswa.index')->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = PrestiSiswa::findOrFail($id);
        
        DB::transaction(function () use ($siswa) {
            PrestiOrtu::where('siswa_id', $siswa->id)->delete();
            PrestiAbsensi::where('siswa_id', $siswa->id)->delete();
            PrestiTagihan::where('siswa_id', $siswa->id)->delete();
            $siswa->delete();
        });

        return redirect()->route('presti.siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Template_Siswa.csv"',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['NIS', 'Nama Lengkap', 'Nama Kelas', 'No HP Orang Tua']);
            fputcsv($file, ['10101', 'Budi Santoso', 'X IPA 1', '628123456789']);
            fputcsv($file, ['10102', 'Siti Aminah', 'X IPA 1', '628987654321']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file',
        ]);

        $file = $request->file('file_csv');
        $path = $file->getRealPath();

        $fileHandle = fopen($path, 'r');
        // skip header
        fgetcsv($fileHandle);

        $count_success = 0;
        $count_duplicate = 0;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($fileHandle, 1000, ",")) !== FALSE) {
                // If saved in Indonesian regional settings in Excel, delimiter could be semicolon
                if (count($row) == 1 && strpos($row[0], ';') !== false) {
                    $row = explode(';', $row[0]);
                }

                if (count($row) >= 3) {
                    $nis = trim($row[0]);
                    $nama = trim($row[1]);
                    $kelas = trim($row[2]);
                    $no_hp_ortu = isset($row[3]) ? trim($row[3]) : '';

                    if (empty($nis) || empty($nama) || empty($kelas)) {
                        continue;
                    }

                    // Check duplicate
                    $exists = PrestiSiswa::where('nis', $nis)->exists();
                    if ($exists) {
                        $count_duplicate++;
                        continue;
                    }

                    $password_default = md5($nis);
                    $siswa = PrestiSiswa::create([
                        'nis' => $nis,
                        'nama' => $nama,
                        'kelas' => $kelas,
                        'no_hp_ortu' => $no_hp_ortu,
                        'password' => $password_default,
                    ]);

                    if (!empty($no_hp_ortu)) {
                        PrestiOrtu::create([
                            'siswa_id' => $siswa->id,
                            'username' => 'ortu_' . $nis,
                            'password' => $password_default,
                        ]);
                    }
                    $count_success++;
                }
            }
            fclose($fileHandle);
            DB::commit();
        } catch (\Exception $e) {
            fclose($fileHandle);
            DB::rollBack();
            return redirect()->route('presti.siswa.index')->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }

        if ($count_success > 0 || $count_duplicate > 0) {
            return redirect()->route('presti.siswa.index')->with('success', "Proses import selesai: {$count_success} berhasil ditambahkan, {$count_duplicate} dilewati karena NIS ganda.");
        } else {
            return redirect()->route('presti.siswa.index')->with('error', 'Gagal memproses data. Pastikan format kolom sudah sesuai.');
        }
    }
}
