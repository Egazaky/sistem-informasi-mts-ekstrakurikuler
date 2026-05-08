# Sistem Pendaftaran Siswa MTS Al-Islam Jepara

## Fitur yang Telah Diimplementasikan

### 1. Halaman Pendaftaran Publik
- **URL**: `/pendaftaran`
- **Fitur**:
  - Form pendaftaran online dengan validasi lengkap
  - Upload dokumen pendaftaran (ZIP/RAR)
  - Informasi syarat pendaftaran
  - Program unggulan (Bahsul Kutub, Tahsin Tahfidz)
  - Aspek strategis (Pondok Pesantren)
  - Ekstrakurikuler yang tersedia
  - Prestasi siswa
  - Kontak narahubung PPDB
  - Link pendaftaran online dan QR Code

### 2. Admin Panel
- **URL**: `/admin/pendaftaran`
- **Fitur**:
  - Daftar semua pendaftaran siswa
  - Detail pendaftaran lengkap
  - Edit data pendaftaran
  - Update status pendaftaran (Menunggu/Diterima/Ditolak)
  - Tambah catatan untuk setiap pendaftaran
  - Hapus data pendaftaran
  - Download dokumen pendaftaran

### 3. Database Schema
Tabel `pendaftarans` dengan field:
- `id` - Primary key
- `nama_lengkap` - Nama lengkap siswa
- `nama_panggilan` - Nama panggilan (opsional)
- `tempat_lahir` - Tempat lahir
- `tanggal_lahir` - Tanggal lahir
- `jenis_kelamin` - L/P
- `agama` - Agama siswa
- `alamat` - Alamat lengkap
- `no_hp` - Nomor HP/WhatsApp
- `email` - Email (opsional)
- `nama_ayah` - Nama ayah
- `nama_ibu` - Nama ibu
- `pekerjaan_ayah` - Pekerjaan ayah (opsional)
- `pekerjaan_ibu` - Pekerjaan ibu (opsional)
- `asal_sekolah` - Asal sekolah
- `dokumen_path` - Path file dokumen (opsional)
- `status` - pending/diterima/ditolak
- `tahun_ajaran` - Tahun ajaran
- `catatan` - Catatan admin (opsional)
- `created_at` - Tanggal dibuat
- `updated_at` - Tanggal diupdate

### 4. Menu Navigasi
- Menu "Profil Sekolah" telah diubah menjadi "Pendaftaran"
- Halaman pendaftaran terintegrasi dengan sistem admin

### 5. Validasi Form
- Validasi server-side untuk semua field wajib
- Validasi file upload (ZIP/RAR, maksimal 10MB)
- Error handling dan notifikasi sukses

### 6. Responsive Design
- Halaman pendaftaran responsive untuk mobile dan desktop
- Admin panel menggunakan template yang sudah ada
- Bootstrap 5 untuk styling

## Cara Menggunakan

### Untuk Admin:
1. Login ke admin panel
2. Pilih menu "Pendaftaran" di sidebar
3. Kelola data pendaftaran siswa
4. Update status pendaftaran sesuai kebutuhan

### Untuk Calon Siswa:
1. Kunjungi halaman `/pendaftaran`
2. Isi form pendaftaran dengan lengkap
3. Upload dokumen yang diperlukan
4. Submit form pendaftaran
5. Tunggu konfirmasi dari admin

## File yang Dibuat/Dimodifikasi

### Views:
- `resources/views/landing/pendaftaran.blade.php` - Halaman pendaftaran publik
- `resources/views/admin/pendaftaran/index.blade.php` - Daftar pendaftaran admin
- `resources/views/admin/pendaftaran/show.blade.php` - Detail pendaftaran admin
- `resources/views/admin/pendaftaran/edit.blade.php` - Edit pendaftaran admin
- `resources/views/admin/pendaftaran/create.blade.php` - Tambah pendaftaran admin

### Controllers:
- `app/Http/Controllers/LandingController.php` - Method pendaftaran dan storePendaftaran
- `app/Http/Controllers/Admin/PendaftaranController.php` - CRUD admin pendaftaran

### Models:
- `app/Models/Pendaftaran.php` - Model pendaftaran

### Migration:
- `database/migrations/2025_09_05_155409_create_pendaftarans_table.php` - Schema tabel pendaftaran

### Routes:
- `routes/web.php` - Route untuk pendaftaran dan admin pendaftaran

### Layout:
- `resources/views/landing/layout.blade.php` - Menu navigasi diubah
- `resources/views/admin/template.blade.php` - Menu admin ditambahkan

## Catatan Penting

1. Pastikan folder `storage/app/public/dokumen_pendaftaran` dapat diakses
2. File dokumen akan disimpan dengan format: `timestamp_namafile.extension`
3. Status pendaftaran dapat diupdate oleh admin
4. Semua data pendaftaran tersimpan di database
5. Halaman pendaftaran sudah responsive dan user-friendly

## Fitur Tambahan yang Bisa Dikembangkan

1. Email notifikasi untuk admin dan calon siswa
2. Export data pendaftaran ke Excel/PDF
3. Filter dan pencarian data pendaftaran
4. Dashboard statistik pendaftaran
5. Integrasi dengan sistem pembayaran
6. Auto-generate nomor pendaftaran
7. Validasi dokumen otomatis
