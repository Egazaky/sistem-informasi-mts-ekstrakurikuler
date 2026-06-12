<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;
use App\Models\Presti\PrestiTagihan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PrestiTagihanController extends Controller
{
    public function manage(Request $request)
    {
        $search_nama = $request->get('search_nama', '');
        $filter_kelas = $request->get('filter_kelas', '');
        $filter_jenis = $request->get('filter_jenis', '');
        $filter_status = $request->get('filter_status', '');
        $filter_bulan = $request->get('filter_bulan', '');

        $query = PrestiTagihan::with('siswa')->join('presti_siswa', 'presti_tagihan.siswa_id', '=', 'presti_siswa.id')
            ->select('presti_tagihan.*');

        if (!empty($search_nama)) {
            $query->where('presti_siswa.nama', 'like', '%' . $search_nama . '%');
        }
        if (!empty($filter_kelas)) {
            $query->where('presti_siswa.kelas', $filter_kelas);
        }
        if (!empty($filter_jenis)) {
            $query->where('presti_tagihan.jenis_pembayaran', $filter_jenis);
        }
        if (!empty($filter_status)) {
            $query->where('presti_tagihan.status', $filter_status);
        }
        if (!empty($filter_bulan)) {
            $query->whereMonth('presti_tagihan.tenggat_bayar', $filter_bulan);
        }

        $tagihan = $query->orderBy('presti_tagihan.tenggat_bayar', 'asc')->get();

        // Get distinct classes for filtering
        $kelas_list = PrestiSiswa::select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas', 'asc')
            ->pluck('kelas');

        $siswa_list = PrestiSiswa::orderBy('nama', 'asc')->get();

        return view('presti.tagihan.manage', compact(
            'tagihan', 'kelas_list', 'siswa_list',
            'search_nama', 'filter_kelas', 'filter_jenis', 'filter_status', 'filter_bulan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tagihan' => 'required|string|max:150',
            'jenis_pembayaran' => 'required|in:Syariah,Jariyah Gedung,LKM dan Daftar Ulang,Lain-lain',
            'nominal' => 'required|integer|min:1',
            'tenggat_bayar' => 'required|date',
            'target_tipe' => 'required|in:semua,kelas,siswa',
            'target_kelas' => 'required_if:target_tipe,kelas',
            'target_siswa' => 'required_if:target_tipe,siswa',
        ]);

        $target_tipe = $request->input('target_tipe');
        $student_ids = [];

        if ($target_tipe === 'semua') {
            $student_ids = PrestiSiswa::pluck('id')->toArray();
        } elseif ($target_tipe === 'kelas') {
            $target_kelas = $request->input('target_kelas');
            $student_ids = PrestiSiswa::where('kelas', $target_kelas)->pluck('id')->toArray();
        } elseif ($target_tipe === 'siswa') {
            $student_ids = [$request->input('target_siswa')];
        }

        if (empty($student_ids)) {
            return redirect()->route('presti.tagihan.manage')->with('error', 'Tidak ada siswa penerima tagihan yang ditemukan.');
        }

        $nama_tagihan = $request->input('nama_tagihan');
        $jenis_pembayaran = $request->input('jenis_pembayaran');
        $nominal = $request->input('nominal');
        $tenggat_bayar = $request->input('tenggat_bayar');

        $success_count = 0;

        DB::transaction(function () use ($student_ids, $nama_tagihan, $jenis_pembayaran, $nominal, $tenggat_bayar, &$success_count) {
            foreach ($student_ids as $sid) {
                // Check if a similar bill exists to prevent duplicate billing
                $exists = PrestiTagihan::where('siswa_id', $sid)
                    ->where('nama_tagihan', $nama_tagihan)
                    ->where('jenis_pembayaran', $jenis_pembayaran)
                    ->exists();

                if (!$exists) {
                    PrestiTagihan::create([
                        'siswa_id' => $sid,
                        'nama_tagihan' => $nama_tagihan,
                        'jenis_pembayaran' => $jenis_pembayaran,
                        'nominal' => $nominal,
                        'tenggat_bayar' => $tenggat_bayar,
                        'status' => 'Belum Bayar',
                    ]);
                    $success_count++;
                }
            }
        });

        return redirect()->route('presti.tagihan.manage')->with('success', "Berhasil membuat {$success_count} tagihan baru!");
    }

    public function update(Request $request, $id)
    {
        $tagihan = PrestiTagihan::findOrFail($id);

        $request->validate([
            'nama_tagihan' => 'required|string|max:150',
            'jenis_pembayaran' => 'required|in:Syariah,Jariyah Gedung,LKM dan Daftar Ulang,Lain-lain',
            'nominal' => 'required|integer|min:1',
            'tenggat_bayar' => 'required|date',
            'status' => 'required|in:Belum Bayar,Menunggu Verifikasi,Lunas',
        ]);

        $status = $request->input('status');

        DB::transaction(function () use ($tagihan, $request, $status) {
            $updateData = [
                'nama_tagihan' => $request->input('nama_tagihan'),
                'jenis_pembayaran' => $request->input('jenis_pembayaran'),
                'nominal' => $request->input('nominal'),
                'tenggat_bayar' => $request->input('tenggat_bayar'),
                'status' => $status,
            ];

            if ($status === 'Lunas') {
                $updateData['tanggal_bayar'] = $tagihan->tanggal_bayar ?? now();
                $updateData['metode_bayar'] = $tagihan->metode_bayar ?? 'Cash';
            } elseif ($status === 'Belum Bayar') {
                // Delete payment proof file if it exists
                if (!empty($tagihan->bukti_bayar)) {
                    $filepath = public_path('uploads/' . $tagihan->bukti_bayar);
                    if (File::exists($filepath)) {
                        File::delete($filepath);
                    }
                }
                $updateData['tanggal_bayar'] = null;
                $updateData['metode_bayar'] = null;
                $updateData['bukti_bayar'] = null;
            }

            $tagihan->update($updateData);
        });

        return redirect()->route('presti.tagihan.manage')->with('success', 'Tagihan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tagihan = PrestiTagihan::findOrFail($id);

        if (!empty($tagihan->bukti_bayar)) {
            $filepath = public_path('uploads/' . $tagihan->bukti_bayar);
            if (File::exists($filepath)) {
                File::delete($filepath);
            }
        }

        $tagihan->delete();

        return redirect()->route('presti.tagihan.manage')->with('success', 'Tagihan berhasil dihapus!');
    }

    public function bayarCash($id)
    {
        $tagihan = PrestiTagihan::findOrFail($id);
        $tagihan->update([
            'status' => 'Lunas',
            'tanggal_bayar' => now(),
            'metode_bayar' => 'Cash',
        ]);

        return redirect()->route('presti.tagihan.manage')->with('success', 'Tagihan berhasil dilunasi via Cash!');
    }

    public function verifikasiSetuju($id)
    {
        $tagihan = PrestiTagihan::findOrFail($id);
        $tagihan->update([
            'status' => 'Lunas',
            'tanggal_bayar' => now(),
            'metode_bayar' => 'Transfer',
        ]);

        return redirect()->route('presti.tagihan.manage')->with('success', 'Pembayaran bukti transfer berhasil dikonfirmasi Lunas!');
    }

    public function verifikasiTolak($id)
    {
        $tagihan = PrestiTagihan::findOrFail($id);

        if (!empty($tagihan->bukti_bayar)) {
            $filepath = public_path('uploads/' . $tagihan->bukti_bayar);
            if (File::exists($filepath)) {
                File::delete($filepath);
            }
        }

        $tagihan->update([
            'status' => 'Belum Bayar',
            'bukti_bayar' => null,
            'metode_bayar' => null,
        ]);

        return redirect()->route('presti.tagihan.manage')->with('success', 'Pembayaran ditolak. Status tagihan dikembalikan ke Belum Bayar.');
    }

    public function tagihanSiswa()
    {
        $siswa_id = session('presti_user_id');
        $siswa = PrestiSiswa::findOrFail($siswa_id);

        $total_belum = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Belum Bayar')->sum('nominal');
        $total_verif = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Menunggu Verifikasi')->sum('nominal');
        $total_lunas = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Lunas')->sum('nominal');

        $tagihan_aktif = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', '!=', 'Lunas')->orderBy('tenggat_bayar', 'asc')->get();
        $tagihan_lunas = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Lunas')->orderBy('tanggal_bayar', 'desc')->get();

        return view('presti.tagihan.siswa', compact('siswa', 'total_belum', 'total_verif', 'total_lunas', 'tagihan_aktif', 'tagihan_lunas'));
    }

    public function tagihanOrtu()
    {
        $siswa_id = session('presti_user_id'); // Parent's user_id is their child's siswa_id
        $siswa = PrestiSiswa::findOrFail($siswa_id);

        $total_belum = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Belum Bayar')->sum('nominal');
        $total_verif = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Menunggu Verifikasi')->sum('nominal');
        $total_lunas = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Lunas')->sum('nominal');

        $tagihan_aktif = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', '!=', 'Lunas')->orderBy('tenggat_bayar', 'asc')->get();
        $tagihan_lunas = PrestiTagihan::where('siswa_id', $siswa_id)->where('status', 'Lunas')->orderBy('tanggal_bayar', 'desc')->get();

        return view('presti.tagihan.ortu', compact('siswa', 'total_belum', 'total_verif', 'total_lunas', 'tagihan_aktif', 'tagihan_lunas'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $siswa_id = session('presti_user_id');
        $siswa = PrestiSiswa::findOrFail($siswa_id);
        $tagihan = PrestiTagihan::where('id', $id)->where('siswa_id', $siswa_id)->firstOrFail();

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer') && $request->file('bukti_transfer')->isValid()) {
            $file = $request->file('bukti_transfer');
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = 'bukti_spp_' . time() . '_' . $siswa->nis . '_' . $tagihan->id . '.' . $ext;
            
            $target_dir = public_path('uploads/');
            if (!File::isDirectory($target_dir)) {
                File::makeDirectory($target_dir, 0777, true, true);
            }

            $file->move($target_dir, $filename);

            $tagihan->update([
                'status' => 'Menunggu Verifikasi',
                'bukti_bayar' => $filename,
                'metode_bayar' => 'Transfer',
            ]);

            return redirect()->route('presti.tagihan.ortu')->with('success', 'Bukti transfer berhasil diunggah! Status sekarang Menunggu Verifikasi. Mohon tunggu admin menyetujui.');
        }

        return redirect()->route('presti.tagihan.ortu')->with('error', 'Gagal mengunggah file. Silakan coba lagi.');
    }
}
