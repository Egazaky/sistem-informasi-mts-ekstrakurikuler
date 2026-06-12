<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;
use App\Models\Presti\PrestiAbsensi;
use Illuminate\Support\Facades\DB;

class PrestiAnalisisController extends Controller
{
    public function kelas(Request $request)
    {
        $kelas_id = $request->get('kelas', '');
        $tanggal = $request->get('tanggal', '');

        // Distinct classes
        $kelas_list = PrestiSiswa::select('kelas')
            ->whereNotNull('kelas')
            ->where('kelas', '!=', '')
            ->distinct()
            ->orderBy('kelas', 'asc')
            ->pluck('kelas');

        // KPI queries
        $kpiQuery = PrestiAbsensi::query()->join('presti_siswa', 'presti_absensi.siswa_id', '=', 'presti_siswa.id');
        if (!empty($kelas_id)) {
            $kpiQuery->where('presti_siswa.kelas', $kelas_id);
        }
        if (!empty($tanggal)) {
            $kpiQuery->where('presti_absensi.tanggal', $tanggal);
        }

        $kpi = [
            'hadir' => (clone $kpiQuery)->where('status', 'Hadir')->count(),
            'terlambat' => (clone $kpiQuery)->where('status', 'Terlambat')->count(),
            'sakit' => (clone $kpiQuery)->where('status', 'Sakit')->count(),
            'izin' => (clone $kpiQuery)->where('status', 'Izin')->count(),
            'alpha' => (clone $kpiQuery)->where('status', 'Alpha')->count(),
        ];

        // Chart data: Average check-in time per class
        $chartQuery = PrestiAbsensi::query()
            ->join('presti_siswa', 'presti_absensi.siswa_id', '=', 'presti_siswa.id')
            ->select('presti_siswa.kelas as nama',
                DB::raw("SUM(presti_absensi.status='Hadir') AS hadir"),
                DB::raw("SUM(presti_absensi.status='Terlambat') AS terlambat"),
                DB::raw("AVG(TIME_TO_SEC(presti_absensi.jam_masuk)) AS rata_jam")
            );
        if (!empty($tanggal)) {
            $chartQuery->where('presti_absensi.tanggal', $tanggal);
        }
        $chartData = $chartQuery->groupBy('presti_siswa.kelas')->get();

        // Student-specific breakdown
        $siswaQuery = PrestiAbsensi::query()
            ->join('presti_siswa', 'presti_absensi.siswa_id', '=', 'presti_siswa.id')
            ->select('presti_siswa.nama',
                DB::raw("SUM(presti_absensi.status='Hadir') AS hadir"),
                DB::raw("SUM(presti_absensi.status='Terlambat') AS terlambat"),
                DB::raw("SUM(presti_absensi.status='Sakit') AS sakit"),
                DB::raw("SUM(presti_absensi.status='Izin') AS izin"),
                DB::raw("SUM(presti_absensi.status='Alpha') AS alpha"),
                DB::raw("COUNT(presti_absensi.id) AS total")
            );
        if (!empty($kelas_id)) {
            $siswaQuery->where('presti_siswa.kelas', $kelas_id);
        }
        if (!empty($tanggal)) {
            $siswaQuery->where('presti_absensi.tanggal', $tanggal);
        }
        $siswaData = $siswaQuery->groupBy('presti_siswa.id', 'presti_siswa.nama')->orderBy('presti_siswa.nama', 'asc')->get();

        return view('presti.analisis.kelas', compact(
            'kelas_list', 'kelas_id', 'tanggal', 'kpi', 'chartData', 'siswaData'
        ));
    }
}
