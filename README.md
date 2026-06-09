# SIAKAD Al-Khodijah
<img width="1777" height="898" alt="Dashboard-SIAKAD-Al-Khodijah" src="https://github.com/user-attachments/assets/09c8cff1-d8c2-49ca-b40d-5519144dfefc" />


Sistem Informasi Akademik (SIAKAD) terpadu untuk Sekolah Al-Khodijah. Aplikasi berbasis web ini dikembangkan menggunakan Laravel 12 untuk mengelola proses akademik, penerimaan siswa baru (PPDB), dan keuangan sekolah secara efisien.

---

## 🚀 Fitur Utama

Aplikasi ini mencakup berbagai modul yang dirancang untuk berbagai peran (Staf Administrasi, Bendahara, Wali Kelas, Kepala Sekolah, dll):

* **Manajemen Master Data:** Pengelolaan Tahun Ajaran, Kelas, Mata Pelajaran, dan Data Guru.
* **Penerimaan Siswa Baru (PPDB):** Pendaftaran online, verifikasi dokumen, dan penentuan status siswa.
* **Modul Keuangan:**
    * Pengaturan Jenis Pembayaran & Tagihan Siswa.
    * Pencatatan Pembayaran PPDB dan SPP.
    * Upload bukti pembayaran dan **Cetak Kwitansi PDF**.
* **Modul Akademik:**
    * Input Nilai Sumatif & Formatif (Tujuan Pembelajaran).
    * Pencatatan Absensi Bulanan Siswa.
    * Input data Ekstrakurikuler dan Catatan Wali Kelas.
    * Pemrosesan dan Finalisasi Rapor oleh Wali Kelas.
* **Persetujuan Dokumen:** Fitur *Approval* (Tanda Tangan) Rapor oleh Kepala Sekolah.

---

## 🛠️ Stack Teknologi

* **Framework:** Laravel 12
* **Bahasa:** PHP 8.3+
* **Database:** MySQL 8.0+
* **Library PDF:** `barryvdh/laravel-dompdf`

---

## 💻 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di mesin lokal (Development) Anda. Proyek ini tidak memerlukan proses build *frontend* (`npm install`/`npm run dev`). 

Pertama, buka Terminal atau *Command Prompt* (cmd) dan arahkan ke folder root server lokal Anda, misalnya `C:\laragon\www` (jika menggunakan Laragon) atau `C:\xampp\htdocs` (jika menggunakan XAMPP).

### 1. Kloning Repositori
```bash
git clone https://github.com/rizalizul/siakad_alkhodijah_sch.git
cd siakad_alkhodijahsch
```

### 2. Install Dependencies (PHP)
```bash
composer install
```

### 3. Pengaturan Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` di *code editor* Anda dan sesuaikan konfigurasi database-nya:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siakad_alkhodijah
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database & Generate Key
Aplikasi ini sudah menyertakan *dump* database lengkap beserta data awal.
1. Buat database kosong di MySQL Anda dengan nama `siakad_alkhodijah` (Anda bisa menggunakan phpMyAdmin atau aplikasi klien database lainnya).
2. *Import* file `siakad_alkhodijahsch.sql` (yang ada di dalam folder proyek) ke dalam database tersebut.
3. Setelah database berhasil diimpor, kembali lagi ke cmd/terminal proyek Anda, lalu jalankan perintah berikut untuk *generate application key*:
```bash
php artisan key:generate
```

### 5. Hubungkan Folder Storage (Wajib)
Agar foto profil, dokumen PPDB, dan bukti pembayaran dapat diakses melalui web, Anda harus membuat *symbolic link* untuk direktori *storage*:
```bash
php artisan storage:link
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```
Aplikasi sekarang dapat diakses melalui browser di alamat: `http://127.0.0.1:8000`

---

## 🔐 Akun Pengujian (Demo)

Database yang diimpor dari file SQL sudah mencakup data *seeder* pengguna. Anda dapat menggunakan akun-akun berikut untuk login dan menguji fitur sesuai dengan *role* masing-masing:

| Role | Nama | Email | Password |
| :--- | :--- | :--- | :--- |
| **Staf Administrasi** | Rizky Firdausi Nuzula | `admin@alkhodijah.sch` | `12345678` |
| **Bendahara** | Azmil Ulya | `bendahara@alkhodijah.sch` | `12345678` |
| **Wakasek Kurikulum** | Maslakhatul Ummah | `kurikulum@alkhodijah.sch` | `12345678` |
| **Kepala Sekolah** | Afifatur Rosidah | `kepsek@alkhodijah.sch` | `12345678` |
| **Wali Kelas (1A)** | Nanda Fitriana | `nanda.fitriana@alkhodijah.sch` | `12345678` |
| **Guru Mapel** | Adella Nuraini | `adella.nuraini@alkhodijah.sch` | `12345678` |

> **Catatan Tambahan:**
> Karena ini adalah mode pengembangan, fungsi *Cron Job/Scheduler* tidak diaktifkan secara otomatis. Anda tidak perlu menjalankan `php artisan schedule:work` untuk menguji aplikasi secara keseluruhan.
