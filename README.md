# E-Izin SMPN 6 Surabaya

Aplikasi digitalisasi pengajuan **surat izin siswa** (sakit / keperluan) untuk SMP Negeri 6
Surabaya. Mengganti surat fisik dengan alur pengajuan → verifikasi guru → rekap terpusat.

**Tech stack:** Laravel 13 (PHP 8.3, Blade) · MySQL · Tailwind CSS (via CDN) · Alpine.js (via CDN)
· Autentikasi berbasis **Laravel Breeze** dengan RBAC kustom.

---

## Peran & Fitur

| Peran | Fitur utama |
| --- | --- |
| **Siswa / Orang Tua** | Dashboard ringkasan, ajukan izin (jenis, tanggal, alasan, unggah bukti), riwayat & detail izin |
| **Guru / Wali Kelas** | Dashboard (izin menunggu hari ini), daftar persetujuan, detail + tombol **Setujui/Tolak** + catatan guru |
| **Admin / Tata Usaha** | Dashboard statistik bulan berjalan, **kelola pengguna** (CRUD guru & siswa + reset password), **rekapitulasi** dengan filter (kelas/status/tanggal) + **ekspor CSV** |

---

## Menjalankan secara lokal

> Prasyarat: PHP 8.3, Composer, dan **server MySQL** yang berjalan.

1. **Dependensi** (sudah terpasang di repo ini):
   ```bash
   composer install
   ```

2. **Konfigurasi `.env`** sudah disetel untuk MySQL:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=izin_smp6_sby
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Sesuaikan `DB_USERNAME`/`DB_PASSWORD` dengan MySQL Anda bila perlu.

3. **Nyalakan MySQL & buat database:**
   ```bash
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS izin_smp6_sby CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

4. **Migrasi + data contoh:**
   ```bash
   php artisan migrate --seed
   ```

5. **Symlink penyimpanan** (untuk file bukti lampiran — sudah dibuat, jalankan jika perlu):
   ```bash
   php artisan storage:link
   ```

6. **Jalankan aplikasi:**
   ```bash
   php artisan serve
   ```
   Buka http://127.0.0.1:8000 — Anda akan diarahkan ke halaman login.

> **Catatan:** `SESSION_DRIVER=database`, jadi MySQL harus aktif & sudah dimigrasi
> sebelum halaman apa pun dibuka (termasuk login).

---

## Akun demo (dari seeder)

Semua akun memakai password: **`password`**

| Peran | Login (email atau NISN) |
| --- | --- |
| Admin / TU | `admin@smpn6.sch.id` |
| Guru | `guru@smpn6.sch.id` (dan `guru2@smpn6.sch.id`) |
| Siswa | `siswa1@smpn6.sch.id` **atau** NISN `0071234567` (Ahmad Rizki, 7A) |

Siswa dapat login menggunakan **NISN _atau_ email**.

---

## Struktur penting

```
app/Http/Controllers/
  DashboardController.php        # dispatch dashboard sesuai role
  LeaveRequestController.php     # siswa: ajukan & riwayat izin
  ApprovalController.php         # guru: setujui / tolak izin
  Admin/UserController.php       # admin: kelola pengguna + reset password
  Admin/ReportController.php     # admin: rekap + ekspor CSV
app/Http/Middleware/CheckRole.php  # RBAC, alias 'role' (lihat bootstrap/app.php)
app/Models/                     # User, Student, LeaveRequest
database/migrations/            # users(+role), students, leave_requests
database/seeders/DatabaseSeeder.php
resources/views/{auth,layouts,siswa,guru,admin,components}/
routes/web.php                  # grup rute per role
```

## Catatan teknis

- **Tailwind & Alpine via CDN** — tidak perlu `npm install`/`vite`. Styling dimuat
  langsung di `resources/views/layouts/{app,guest}.blade.php`.
- **RBAC**: middleware `role:siswa|guru|admin` menjaga tiap grup rute.
- **Upload bukti**: disimpan di `storage/app/public/bukti`, diakses via symlink `public/storage`.
