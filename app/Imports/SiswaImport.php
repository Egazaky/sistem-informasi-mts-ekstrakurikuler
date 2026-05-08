<?php

namespace App\Imports;

use App\Models\SiswaModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Normalisasi key ke lowercase agar support header kapital
            $rowArr = $row->toArray();
            $rowLower = [];
            foreach ($rowArr as $k => $v) {
                $rowLower[strtolower($k)] = $v;
            }
            $nama = $rowLower['nama'] ?? $rowLower['nama_siswa'] ?? null;
            $kelas = $rowLower['kelas'] ?? '7A';
            $ket = $rowLower['ket'] ?? null;
            // Map kolom KET ke jen_kel (L/P)
            $jen_kel = null;
            if ($ket) {
                $jen_kel = strtoupper($ket) == 'L' ? 'Laki-laki' : (strtoupper($ket) == 'P' ? 'Perempuan' : null);
            }
            if ($nama && $jen_kel) {
                SiswaModel::create([
                    'nama_siswa' => $nama,
                    'kelas' => $kelas,
                    'jen_kel' => $jen_kel,
                    'username' => 'sis25' . Str::random(4),
                    'password' => Str::random(5),
                    'status' => '0',
                    'is_active' => '1',
                ]);
            }
        }
    }
}

