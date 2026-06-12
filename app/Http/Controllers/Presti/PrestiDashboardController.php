<?php

namespace App\Http\Controllers\Presti;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presti\PrestiSiswa;
use App\Models\Presti\PrestiAbsensi;
use Illuminate\Support\Facades\DB;

class PrestiDashboardController extends Controller
{
    public function index()
    {
        $role = session('presti_role');
        if ($role === 'admin') {
            return redirect()->route('presti.dashboard.admin');
        } elseif ($role === 'guru') {
            return redirect()->route('presti.dashboard.guru');
        } elseif ($role === 'siswa') {
            return redirect()->route('presti.dashboard.siswa');
        } elseif ($role === 'ortu') {
            return redirect()->route('presti.dashboard.ortu');
        }
        return redirect()->route('presti.login');
    }

    public function admin(Request $request)
    {
        $filter_waktu = $request->get('filter_waktu', 'hari_ini');
        
        $query = PrestiAbsensi::query();
        if ($filter_waktu === 'hari_ini') {
            $hari_ini = date('Y-m-d');
            $query->where('tanggal', $hari_ini);
            $teks_filter = "Hari Ini (" . date('d M Y') . ")";
        } else {
            $teks_filter = "Total Semua Waktu";
        }

        $total_hadir = (clone $query)->where('status', 'Hadir')->count();
        $total_terlambat = (clone $query)->where('status', 'Terlambat')->count();
        $total_sakit = (clone $query)->where('status', 'Sakit')->count();
        $total_izin = (clone $query)->where('status', 'Izin')->count();
        $total_alpha = (clone $query)->where('status', 'Alpha')->count();

        $donutData = [$total_hadir, $total_terlambat, $total_sakit, $total_izin, $total_alpha];

        // Line and Bar Charts Data
        $hadirPerHari = [];
        $terlambatPerHari = [];

        $dayOfWeek = date('w');
        $dayOfWeek = ($dayOfWeek == 0) ? 7 : $dayOfWeek;
        $daysToSubtract = $dayOfWeek - 1;
        $monday_this_week = date('Y-m-d', strtotime("-$daysToSubtract days"));

        for ($i = 0; $i < 5; $i++) {
            if ($filter_waktu === 'semua') {
                $sql_dow = $i + 2; 
                $qHadir = PrestiAbsensi::whereRaw('DAYOFWEEK(tanggal) = ?', [$sql_dow])->where('status', 'Hadir')->count();
                $qTerlambat = PrestiAbsensi::whereRaw('DAYOFWEEK(tanggal) = ?', [$sql_dow])->where('status', 'Terlambat')->count();
            } else {
                $currentDate = date('Y-m-d', strtotime($monday_this_week . " +$i days"));
                $qHadir = PrestiAbsensi::where('tanggal', $currentDate)->where('status', 'Hadir')->count();
                $qTerlambat = PrestiAbsensi::where('tanggal', $currentDate)->where('status', 'Terlambat')->count();
            }
            $hadirPerHari[] = $qHadir;
            $terlambatPerHari[] = $qTerlambat;
        }

        return view('presti.dashboard.admin', compact(
            'filter_waktu', 'teks_filter',
            'total_hadir', 'total_terlambat', 'total_sakit', 'total_izin', 'total_alpha',
            'donutData', 'hadirPerHari', 'terlambatPerHari'
        ));
    }

    public function guru(Request $request)
    {
        $filter_waktu = $request->get('filter_waktu', 'hari_ini');
        
        $query = PrestiAbsensi::query();
        if ($filter_waktu === 'hari_ini') {
            $hari_ini = date('Y-m-d');
            $query->where('tanggal', $hari_ini);
            $teks_filter = "Hari Ini (" . date('d M Y') . ")";
        } else {
            $teks_filter = "Total Semua Waktu";
        }

        $total_hadir = (clone $query)->where('status', 'Hadir')->count();
        $total_terlambat = (clone $query)->where('status', 'Terlambat')->count();
        $total_sakit = (clone $query)->where('status', 'Sakit')->count();
        $total_izin = (clone $query)->where('status', 'Izin')->count();
        $total_alpha = (clone $query)->where('status', 'Alpha')->count();

        $donutData = [$total_hadir, $total_terlambat, $total_sakit, $total_izin, $total_alpha];

        // Line and Bar Charts Data
        $hadirPerHari = [];
        $terlambatPerHari = [];

        $dayOfWeek = date('w');
        $dayOfWeek = ($dayOfWeek == 0) ? 7 : $dayOfWeek;
        $daysToSubtract = $dayOfWeek - 1;
        $monday_this_week = date('Y-m-d', strtotime("-$daysToSubtract days"));

        for ($i = 0; $i < 5; $i++) {
            if ($filter_waktu === 'semua') {
                $sql_dow = $i + 2; 
                $qHadir = PrestiAbsensi::whereRaw('DAYOFWEEK(tanggal) = ?', [$sql_dow])->where('status', 'Hadir')->count();
                $qTerlambat = PrestiAbsensi::whereRaw('DAYOFWEEK(tanggal) = ?', [$sql_dow])->where('status', 'Terlambat')->count();
            } else {
                $currentDate = date('Y-m-d', strtotime($monday_this_week . " +$i days"));
                $qHadir = PrestiAbsensi::where('tanggal', $currentDate)->where('status', 'Hadir')->count();
                $qTerlambat = PrestiAbsensi::where('tanggal', $currentDate)->where('status', 'Terlambat')->count();
            }
            $hadirPerHari[] = $qHadir;
            $terlambatPerHari[] = $qTerlambat;
        }

        return view('presti.dashboard.guru', compact(
            'filter_waktu', 'teks_filter',
            'total_hadir', 'total_terlambat', 'total_sakit', 'total_izin', 'total_alpha',
            'donutData', 'hadirPerHari', 'terlambatPerHari'
        ));
    }

    public function siswa()
    {
        $siswa_id = session('presti_user_id');
        $siswa = PrestiSiswa::findOrFail($siswa_id);

        $hadir = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Hadir')->count();
        $terlambat = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Terlambat')->count();
        $sakit = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Sakit')->count();
        $izin = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Izin')->count();
        $alpha = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Alpha')->count();

        $total_hari = $hadir + $terlambat + $sakit + $izin + $alpha;
        $persentase = $total_hari > 0 ? round((($hadir + $terlambat) / $total_hari) * 100, 1) : 0;

        $keterlambatanBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $keterlambatanBulan[] = PrestiAbsensi::where('siswa_id', $siswa_id)
                ->where('status', 'Terlambat')
                ->whereMonth('tanggal', $i)
                ->whereYear('tanggal', date('Y'))
                ->count();
        }

        return view('presti.dashboard.siswa', compact(
            'siswa', 'hadir', 'terlambat', 'sakit', 'izin', 'alpha',
            'total_hari', 'persentase', 'keterlambatanBulan'
        ));
    }

    public function ortu()
    {
        $siswa_id = session('presti_user_id');
        $siswa = PrestiSiswa::findOrFail($siswa_id);

        $hadir = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Hadir')->count();
        $terlambat = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Terlambat')->count();
        $sakit = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Sakit')->count();
        $izin = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Izin')->count();
        $alpha = PrestiAbsensi::where('siswa_id', $siswa_id)->where('status', 'Alpha')->count();

        $total_hari = $hadir + $terlambat + $sakit + $izin + $alpha;
        $persentase = $total_hari > 0 ? round((($hadir + $terlambat) / $total_hari) * 100, 1) : 0;

        $riwayat = PrestiAbsensi::where('siswa_id', $siswa_id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->limit(30)
            ->get();

        return view('presti.dashboard.ortu', compact(
            'siswa', 'hadir', 'terlambat', 'sakit', 'izin', 'alpha',
            'total_hari', 'persentase', 'riwayat'
        ));
    }
}
