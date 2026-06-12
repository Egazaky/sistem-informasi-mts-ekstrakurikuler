<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;
use App\Models\Presti\PrestiAbsensi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PrestiAbsensiController extends Controller
{
    public function scan()
    {
        return view('presti.absensi.scan');
    }

    public function scanProcess(Request $request)
    {
        $req_nis = $request->input('nis', '');
        if (trim($req_nis) === '') {
            return response()->json([
                "status" => "error",
                "message" => "QR Code / NIS tidak valid"
            ]);
        }

        $req_jenis_scan = $request->input('jenis_scan', 'masuk');
        $nis = trim($req_nis);
        $tanggal = date("Y-m-d");
        $jam = date("H:i:s");

        // CEK SISWA
        $siswa = PrestiSiswa::where('nis', $nis)->first();
        if (!$siswa) {
            return response()->json([
                "status" => "error",
                "message" => "NIS tidak terdaftar"
            ]);
        }

        // CEK SUDAH ABSEN HARI INI
        $existing = PrestiAbsensi::where('siswa_id', $siswa->id)
            ->where('tanggal', $tanggal)
            ->first();

        $is_pulang = false;
        $id_absen = null;

        if ($req_jenis_scan === 'masuk') {
            if ($existing) {
                return response()->json([
                    "status" => "error",
                    "message" => "Siswa sudah melakukan absensi masuk hari ini"
                ]);
            }
        } else {
            // jenis_scan === 'pulang'
            if (!$existing) {
                return response()->json([
                    "status" => "error",
                    "message" => "Siswa belum melakukan absensi masuk hari ini"
                ]);
            }
            if (!empty($existing->jam_pulang)) {
                return response()->json([
                    "status" => "error",
                    "message" => "Siswa sudah melakukan absensi pulang hari ini"
                ]);
            }
            $is_pulang = true;
            $id_absen = $existing->id;
        }

        // PROSES CATATAN DAN FOTO
        $catatan = $request->input('catatan', '');
        $bukti_foto = '';

        if ($request->hasFile('bukti_foto') && $request->file('bukti_foto')->isValid()) {
            $file = $request->file('bukti_foto');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '_' . $nis . '.' . $ext;
            
            $target_dir = public_path('uploads/');
            if (!File::isDirectory($target_dir)) {
                File::makeDirectory($target_dir, 0777, true, true);
            }

            $file->move($target_dir, $filename);
            $bukti_foto = $filename;
        }

        if ($is_pulang) {
            // PROSES ABSENSI PULANG
            $existing->jam_pulang = $jam;
            if (!empty($catatan)) {
                $existing->catatan = ($existing->catatan ? $existing->catatan . "\n" : "") . "Pulang: " . $catatan;
            }
            if (!empty($bukti_foto)) {
                $existing->bukti_foto = $bukti_foto;
            }
            $existing->save();
            
            $status_wa = "Pulang";
            $pesan_success = "Absensi pulang berhasil dicatat";
            $status_response = "Pulang";
        } else {
            // MENENTUKAN STATUS HADIR (Masuk)
            $req_status = $request->input('status', '');
            if (trim($req_status) !== '') {
                $status = trim($req_status);
                // Validasi manual: jika lewat 07:00:00 dan dipilih Hadir, jadikan Terlambat
                if ($status === 'Hadir' && $jam > "07:00:00") {
                    $status = 'Terlambat';
                }
            } else {
                $status = ($jam > "07:00:00") ? "Terlambat" : "Hadir";
            }

            $existing = PrestiAbsensi::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $tanggal,
                'jam_masuk' => $jam,
                'status' => $status,
                'catatan' => $catatan,
                'bukti_foto' => $bukti_foto,
            ]);

            $status_wa = $status;
            $pesan_success = "Absensi masuk berhasil dicatat";
            $status_response = $status;
        }

        // NOTIFIKASI WHATSAPP
        if (!empty($siswa->no_hp_ortu)) {
            if ($is_pulang) {
                $pesan_wa = "Pemberitahuan Absensi:\n\nAnanda *" . $siswa->nama . "* telah melakukan absensi *PULANG* pada *" . date("d-m-Y", strtotime($tanggal)) . "* pukul *" . $jam . "*.";
            } else {
                $pesan_wa = "Pemberitahuan Absensi:\n\nAnanda *" . $siswa->nama . "* telah melakukan absensi *MASUK* pada *" . date("d-m-Y", strtotime($tanggal)) . "* dengan status *" . $status_wa . "* pukul *" . $jam . "*.";
            }

            if (!empty($catatan)) {
                $pesan_wa .= "\nCatatan: " . $catatan;
            }
            $pesan_wa .= "\n\nTerima kasih.";
            $pesan_wa .= "\n\n---\n*Info Login Ke Sistem Informasi:*\nUsername: ortu_" . $nis . "\nPassword: " . $nis . "\n_Gunakan akses di atas bila ingin memantau rekap data ananda secara mandiri._";

            // Format phone number
            $no_hp = preg_replace('/[^0-9]/', '', $siswa->no_hp_ortu);
            if (str_starts_with($no_hp, '0')) {
                $no_hp = '62' . substr($no_hp, 1);
            } elseif (str_starts_with($no_hp, '8')) {
                $no_hp = '628' . substr($no_hp, 1);
            }

            // Fonnte API call
            $fonnte_token = 'v1S86u7eWunVEvvibtAR';
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $no_hp,
                    'message' => $pesan_wa,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $fonnte_token"
                ),
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
            ));

            $result = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            // Logging Fonnte
            $log_path = storage_path('logs/fonnte_log.txt');
            $log_msg = date('Y-m-d H:i:s') . " - Fonnte to $no_hp: " . ($err ? "Error: $err" : "Response: $result") . "\n";
            File::append($log_path, $log_msg);
        }

        return response()->json([
            "status" => "success",
            "message" => $pesan_success,
            "nama" => $siswa->nama,
            "status_hadir" => $status_response,
            "jam" => $jam
        ]);
    }

    public function getRiwayat()
    {
        $tanggal = date("Y-m-d");
        $riwayat = PrestiAbsensi::with('siswa')
            ->where('tanggal', $tanggal)
            ->orderBy('jam_masuk', 'desc')
            ->limit(10)
            ->get();

        if ($riwayat->count() > 0) {
            $html = '';
            foreach ($riwayat as $row) {
                if (!$row->siswa) continue;
                $badge_class = ($row->status == 'Hadir') ? 'text-bg-success' : 'text-bg-warning';
                if ($row->status == 'Sakit' || $row->status == 'Izin') $badge_class = 'text-bg-info';
                if ($row->status == 'Alpha') $badge_class = 'text-bg-danger';

                $waktu = "Masuk: " . $row->jam_masuk;
                if (!empty($row->jam_pulang)) {
                    $waktu .= " | Pulang: " . $row->jam_pulang;
                }

                $html .= '
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div>
                        <h6 class="mb-0">' . e($row->siswa->nama) . '</h6>
                        <small class="text-muted">' . e($row->siswa->nis) . '</small>
                    </div>
                    <div class="text-end">
                        <span class="badge ' . $badge_class . ' mb-1">' . $row->status . '</span><br>
                        <small class="text-muted">' . $waktu . '</small>
                    </div>
                </div>';
            }
            return response($html);
        } else {
            return response('<div class="text-center text-muted py-3">Belum ada data absensi hari ini</div>');
        }
    }

    public function exportExcel(Request $request)
    {
        $kelas_id = $request->get('kelas', '');
        $tanggal = $request->get('tanggal', date('Y-m-d'));
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        $tipe = $request->get('tipe', 'harian');

        // Available classes
        $kelas_list = PrestiSiswa::select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas', 'asc')
            ->pluck('kelas');

        // Processing Excel Export if requested
        if ($request->has('export')) {
            $export_type = $request->get('export');
            
            if ($export_type === 'harian') {
                $headers = [
                    "Content-type" => "application/vnd-ms-excel",
                    "Content-Disposition" => "attachment; filename=laporan_absensi_harian_{$tanggal}.xls"
                ];

                $query = PrestiAbsensi::with('siswa')->where('tanggal', $tanggal);
                if (!empty($kelas_id)) {
                    $query->whereHas('siswa', function ($q) use ($kelas_id) {
                        $q->where('kelas', $kelas_id);
                    });
                }
                $data = $query->get();

                $callback = function () use ($data, $tanggal) {
                    echo "<table border='1'>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Catatan Alasan</th>
                    </tr>";

                    $no = 1;
                    foreach ($data as $d) {
                        if (!$d->siswa) continue;
                        echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>{$d->siswa->nis}</td>
                            <td>" . e($d->siswa->nama) . "</td>
                            <td>" . e($d->siswa->kelas) . "</td>
                            <td>{$d->tanggal}</td>
                            <td>{$d->jam_masuk}</td>
                            <td>" . ($d->jam_pulang ?? '-') . "</td>
                            <td>{$d->status}</td>
                            <td>" . e($d->catatan) . "</td>
                        </tr>";
                    }
                    echo "</table>";
                };

                return response()->stream($callback, 200, $headers);

            } elseif ($export_type === 'bulanan') {
                $nama_bulan = [
                    "01" => "Januari", "02" => "Februari", "03" => "Maret", 
                    "04" => "April", "05" => "Mei", "06" => "Juni", 
                    "07" => "Juli", "08" => "Agustus", "09" => "September", 
                    "10" => "Oktober", "11" => "November", "12" => "Desember"
                ];
                $bln_nama = $nama_bulan[$bulan] ?? "Bulan";

                $headers = [
                    "Content-type" => "application/vnd-ms-excel",
                    "Content-Disposition" => "attachment; filename=laporan_absensi_bulanan_{$bln_nama}_{$tahun}.xls"
                ];

                $siswaQuery = PrestiSiswa::query();
                if (!empty($kelas_id)) {
                    $siswaQuery->where('kelas', $kelas_id);
                }
                $siswa_data = $siswaQuery->orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();

                $absensi_data = PrestiAbsensi::whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->get();

                $matrix = [];
                foreach ($absensi_data as $a) {
                    $day = (int)date('j', strtotime($a->tanggal));
                    $matrix[$a->siswa_id][$day] = $a->status;
                }

                $jml_hari = cal_days_in_month(CAL_GREGORIAN, (int)$bulan, (int)$tahun);
                $colspan_header = $jml_hari + 9;
                $colspan_text = $colspan_header - 2;

                $logo_url = asset('assets/img/presti-logo.png');

                $callback = function () use ($siswa_data, $matrix, $jml_hari, $colspan_text, $colspan_header, $bln_nama, $tahun, $logo_url) {
                    echo "<table border='1'>
                    <tr>
                        <th rowspan='3' colspan='2' style='text-align:center; vertical-align:middle;'>
                            <img src='{$logo_url}' height='70' alt='Logo'>
                        </th>
                        <th colspan='{$colspan_text}' style='text-align:center; font-size:16pt; font-weight:bold;'>MTs. Al Islam Jepara</th>
                    </tr>
                    <tr>
                        <th colspan='{$colspan_text}' style='text-align:center; font-size:12pt; font-weight:bold;'>Laporan Rekapitulasi Absensi Bulanan</th>
                    </tr>
                    <tr>
                        <th colspan='{$colspan_text}' style='text-align:center; font-size:11pt;'>Bulan: {$bln_nama} {$tahun}</th>
                    </tr>
                    <tr>
                        <th colspan='{$colspan_header}'></th>
                    </tr>
                    <tr>
                        <th rowspan='2'>No</th>
                        <th rowspan='2'>NIS</th>
                        <th rowspan='2'>Nama Siswa</th>
                        <th rowspan='2'>Kelas</th>
                        <th colspan='{$jml_hari}'>Tanggal</th>
                        <th colspan='5'>Total</th>
                    </tr>
                    <tr>";
                    for ($i = 1; $i <= $jml_hari; $i++) {
                        echo "<th>$i</th>";
                    }
                    echo "<th>H</th><th>T</th><th>I</th><th>S</th><th>A</th></tr>";

                    $no = 1;
                    foreach ($siswa_data as $s) {
                        echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>&nbsp;{$s->nis}</td>
                            <td>" . e($s->nama) . "</td>
                            <td>" . e($s->kelas) . "</td>";

                        $total_h = 0; $total_t = 0; $total_i = 0; $total_s = 0; $total_a = 0;

                        for ($i = 1; $i <= $jml_hari; $i++) {
                            $status = $matrix[$s->id][$i] ?? '';
                            $kode = '';
                            if ($status == 'Hadir') { $kode = 'H'; $total_h++; }
                            elseif ($status == 'Terlambat') { $kode = 'T'; $total_t++; }
                            elseif ($status == 'Izin') { $kode = 'I'; $total_i++; }
                            elseif ($status == 'Sakit') { $kode = 'S'; $total_s++; }
                            elseif ($status == 'Alpha') { $kode = 'A'; $total_a++; }

                            echo "<td style='text-align:center;'>$kode</td>";
                        }

                        echo "<td style='text-align:center; font-weight:bold;'>$total_h</td>
                              <td style='text-align:center; font-weight:bold;'>$total_t</td>
                              <td style='text-align:center; font-weight:bold;'>$total_i</td>
                              <td style='text-align:center; font-weight:bold;'>$total_s</td>
                              <td style='text-align:center; font-weight:bold;'>$total_a</td>
                        </tr>";
                    }
                    echo "</table>";
                };

                return response()->stream($callback, 200, $headers);
            }
        }

        // Preview rendering for GET request (not direct export)
        $preview_data = [];
        if ($tipe === 'harian') {
            $query = PrestiAbsensi::with('siswa')->where('tanggal', $tanggal);
            if (!empty($kelas_id)) {
                $query->whereHas('siswa', function ($q) use ($kelas_id) {
                    $q->where('kelas', $kelas_id);
                });
            }
            $preview_data = $query->orderBy('tanggal', 'desc')->get();
        }

        return view('presti.absensi.export', compact(
            'kelas_list', 'kelas_id', 'tanggal', 'bulan', 'tahun', 'tipe', 'preview_data'
        ));
    }

    public function cetakQR(Request $request)
    {
        $kelas_id = $request->get('kelas', '');

        $kelas_list = PrestiSiswa::select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas', 'asc')
            ->pluck('kelas');

        $query = PrestiSiswa::query();
        if (!empty($kelas_id)) {
            $query->where('kelas', $kelas_id);
        }
        $siswa = $query->orderBy('nama', 'asc')->get();

        return view('presti.absensi.cetak_qr', compact('siswa', 'kelas_list', 'kelas_id'));
    }
}
