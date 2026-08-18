# Sistem Informasi Arsip Surat PT Microdata Indonesia

Sistem informasi berbasis web untuk pengelolaan arsip surat masuk dan surat keluar di PT Microdata Indonesia. Dibangun menggunakan framework Laravel 12 dengan antarmuka modern yang responsif.

---

## Daftar Isi

- [Tentang Project](#tentang-project)
- [Tujuan](#tujuan)
- [Fitur](#fitur)
- [Role dan Hak Akses](#role-dan-hak-akses)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Project](#struktur-project)
- [Database](#database)
- [Entity Relationship Diagram](#entity-relationship-diagram)
- [Screenshot Aplikasi](#screenshot-aplikasi)
- [Instalasi dan Menjalankan Project](#instalasi-dan-menjalankan-project)
- [Konfigurasi Environment](#konfigurasi-environment)
- [Akun Demo](#akun-demo)
- [Alur Sistem](#alur-sistem)
- [Testing](#testing)
- [Pengembangan Sistem](#pengembangan-sistem)
- [Tim Pengembang](#tim-pengembang)
- [Git Workflow](#git-workflow)
- [Security](#security)
- [Status Project](#status-project)
- [Lisensi](#lisensi)

---

## Tentang Project

**Sistem Informasi Arsip Surat PT Microdata Indonesia** adalah aplikasi web yang dirancang untuk mengelola seluruh proses administrasi surat masuk dan surat keluar secara digital. Sistem ini mengatasi permasalahan pengelolaan surat secara konvensional yang rentan terhadap kehilangan dokumen, pencarian yang memakan waktu, serta kurangnya pencatatan yang terstruktur.

Aplikasi ini menyediakan fitur pencatatan surat masuk dan surat keluar, pengarsipan otomatis, pembuatan nomor surat otomatis dengan format standar perusahaan, generate dokumen PDF, pengiriman surat via email dan WhatsApp, serta pelaporan statistik yang komprehensif.

---

## Tujuan

1. **Digitalisasi arsip surat** - Mengubah proses pengelolaan surat dari manual menjadi digital untuk meningkatkan efisiensi dan keamanan data.
2. **Penomoran surat otomatis** - Menyediakan sistem penomoran surat keluar secara otomatis dengan format standar perusahaan.
3. **Pengarsipan terpusat** - Menyimpan seluruh data surat masuk dan surat keluar dalam satu sistem yang terintegrasi.
4. **Kemudahan pencarian** - Memudahkan pencarian dan pelacakan surat berdasarkan berbagai kriteria.
5. **Pelaporan** - Menyediakan laporan statistik surat dalam periode tertentu yang dapat diekspor ke PDF dan Excel.
6. **Distribusi surat digital** - Memungkinkan pengiriman surat keluar melalui email dan WhatsApp secara langsung dari sistem.

---

## Fitur

### Autentikasi
- Login dan Logout pengguna
- Registrasi akun baru
- Lupa password dan reset password via email
- Verifikasi email
- Konfirmasi password untuk aksi sensitif

### Dashboard
- Statistik total surat masuk, surat keluar, arsip, dan pengguna
- Rincian status surat masuk (Baru, Diproses, Selesai)
- Rincian status surat keluar (Draft, Dikirim, Selesai)
- Grafik komparasi surat 6 bulan terakhir (surat masuk, surat keluar, arsip)
- Daftar 5 surat masuk, surat keluar, dan arsip terbaru

### Surat Masuk
- Daftar surat masuk dengan pencarian (nomor agenda, nomor surat, asal surat, perihal)
- Tambah surat masuk dengan nomor agenda otomatis (format: `AGD-XXXX`)
- Edit dan hapus surat masuk (soft delete)
- Detail surat masuk
- Upload file PDF surat masuk
- Download lembar agenda surat masuk ke PDF
- Relasi otomatis dengan data instansi pengirim
- Pengarsipan otomatis saat surat masuk disimpan

### Surat Keluar
- Daftar surat keluar dengan DataTables
- Tambah surat keluar dengan penomoran otomatis (format: `XX/KODE/DIVISI/PT-MDI/BULAN_ROMAWI/TAHUN`)
- Preview nomor surat secara realtime di form
- Dukungan template khusus berdasarkan jenis surat (umum dan surat kuasa)
- Form dinamis yang menyesuaikan jenis surat yang dipilih
- Edit dan hapus surat keluar (soft delete)
- Detail surat keluar
- Preview surat keluar dalam format template
- Upload file PDF surat keluar
- Download/generate PDF surat keluar dari template
- Pengiriman surat keluar via email
- Pengiriman surat keluar via WhatsApp (integrasi Baileys)
- Pembuatan surat keluar sebagai balasan dari surat masuk
- Pengarsipan otomatis saat surat keluar disimpan

### Arsip Surat
- Daftar arsip surat (surat masuk dan surat keluar)
- Pencarian arsip berdasarkan nomor surat, perihal, pengirim/penerima
- Filter berdasarkan jenis (Surat Masuk / Surat Keluar)
- Filter berdasarkan status
- Detail arsip
- Hapus arsip (soft delete beserta surat aslinya)
- Ekspor arsip ke CSV

### Data Master

#### Data Instansi
- Daftar instansi (kode, nama, telepon, alamat)
- Tambah, edit, dan hapus instansi (soft delete)
- Instansi digunakan sebagai referensi asal surat masuk dan tujuan surat keluar

#### Data Jenis Surat
- Daftar jenis surat dengan kode surat dan tipe form
- Tambah jenis surat baru (dari halaman manajemen atau modal di form surat keluar)
- Edit dan hapus jenis surat (soft delete)
- Dukungan tipe form: umum dan kuasa
- Data awal: Surat Tugas (ST), Surat Undangan (SU), Surat Pemberitahuan (SP), Surat Permohonan (PM), Surat Kuasa (SK)

### Pengaturan Akun
- Edit profil pengguna (nama dan email)
- Ubah password dengan validasi password lama

### Tempat Sampah (Recycle Bin)
- Daftar data yang dihapus (surat keluar, surat masuk, arsip, instansi, jenis surat)
- Pulihkan (restore) data yang dihapus
- Hapus permanen data beserta file terkait

### Laporan
- Ringkasan statistik surat berdasarkan periode tanggal
- Filter berdasarkan jenis surat (Surat Masuk / Surat Keluar)
- Filter berdasarkan status
- Grafik tren surat harian (line chart)
- Ekspor laporan ke PDF (DomPDF)
- Ekspor laporan ke Excel (Maatwebsite Excel)
- Kirim laporan via email dengan lampiran file

### Pengiriman Surat Digital
- Kirim surat keluar via email (generate PDF otomatis atau gunakan file yang sudah diupload)
- Kirim surat keluar via WhatsApp melalui server Baileys (Node.js) yang terintegrasi

---

## Role dan Hak Akses

Berdasarkan analisis migration `create_kelola_users_table` dan `UserController`, sistem mendukung role berikut:

| Role | Hak Akses |
|------|-----------|
| **Admin** | Akses penuh ke seluruh fitur sistem termasuk manajemen pengguna |
| **Operator** | Mengelola data surat dan arsip |
| **Verifikator** | Verifikasi dan validasi surat |
| **Viewer** | Hanya dapat melihat data (role default saat registrasi) |

> **Catatan:** Saat ini seluruh route yang membutuhkan autentikasi dilindungi oleh middleware `auth`. Pembatasan akses berdasarkan role sudah tersedia pada struktur data (kolom `role` pada tabel `users` dengan default `Viewer`), namun middleware khusus untuk pembatasan akses per role belum ditemukan dalam implementasi saat ini. Semua pengguna yang sudah login dapat mengakses seluruh fitur.

---

## Teknologi yang Digunakan

| Teknologi | Keterangan |
|-----------|------------|
| **Laravel 12** | Framework backend utama |
| **PHP 8.2+** | Bahasa pemrograman server-side |
| **MySQL** | Database relasional |
| **Blade** | Template engine Laravel |
| **Tailwind CSS 3** | Framework CSS untuk styling |
| **Alpine.js 3** | Framework JavaScript untuk interaktivitas frontend |
| **DataTables** | Plugin jQuery untuk tabel data interaktif |
| **Font Awesome 6** | Library ikon |
| **Plus Jakarta Sans** | Tipografi utama aplikasi |
| **Laravel Breeze** | Starter kit autentikasi |
| **DomPDF** | Generate dokumen PDF (barryvdh/laravel-dompdf) |
| **Maatwebsite Excel** | Ekspor data ke format Excel |
| **Vite** | Build tool untuk aset frontend |
| **Chart.js** | Grafik statistik pada dashboard dan laporan |
| **Node.js + Express** | Server API WhatsApp (wa-baileys-server) |
| **Baileys** | Library WhatsApp Web API (@whiskeysockets/baileys) |
| **Axios** | HTTP client untuk request AJAX |
| **Pest** | Framework testing PHP |
| **Git** | Version control |

---

## Struktur Project

```
surat-penomoran/
├── app/
│   ├── Exports/              # Class export data (LaporanExport)
│   ├── Http/
│   │   └── Controllers/      # Controller aplikasi
│   │       ├── Auth/          # Controller autentikasi (Breeze)
│   │       ├── AccountController.php
│   │       ├── ArsipController.php
│   │       ├── DashboardController.php
│   │       ├── InstansiController.php
│   │       ├── JenisSuratController.php
│   │       ├── LaporanController.php
│   │       ├── RecycleBinController.php
│   │       ├── SuratKeluarController.php
│   │       ├── SuratMasukController.php
│   │       └── UserController.php
│   ├── Mail/                 # Mailable class (LaporanMail, SuratKeluarMail)
│   ├── Models/               # Eloquent models
│   │   ├── Arsip.php
│   │   ├── Instansi.php
│   │   ├── JenisSurat.php
│   │   ├── KelolaUser.php
│   │   ├── SuratKeluar.php
│   │   ├── SuratMasuk.php
│   │   └── User.php
│   └── View/                 # View components
├── database/
│   ├── migrations/           # File migration database
│   └── seeders/              # Seeder data awal
├── public/
│   ├── image/                # Gambar (kop surat, logo)
│   └── images/               # Logo Microdata
├── resources/
│   └── views/
│       ├── akun/             # View pengaturan akun
│       ├── arsip/            # View arsip surat
│       ├── auth/             # View autentikasi (login, register, dll.)
│       ├── components/       # Blade components
│       ├── dashboard.blade.php
│       ├── emails/           # Template email
│       ├── instansi/         # View data instansi
│       ├── jenis_surat/      # View jenis surat
│       ├── laporan/          # View laporan
│       ├── layouts/          # Layout utama (app, sidebar, navbar)
│       ├── profile/          # View profil pengguna
│       ├── recyclebin/       # View tempat sampah
│       ├── surat_keluar/     # View surat keluar
│       ├── surat_masuk/      # View surat masuk
│       └── welcome.blade.php
├── routes/
│   ├── auth.php              # Route autentikasi
│   └── web.php               # Route utama aplikasi
├── tests/                    # Automated tests (Pest)
├── wa-baileys-server/        # Server WhatsApp API (Node.js)
│   ├── index.js
│   └── package.json
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js
├── vite.config.js
└── README.md
```

---

## Database

### Tabel Utama

| Tabel | Fungsi |
|-------|--------|
| `users` | Data pengguna sistem (nama, email, password, role, unit kerja, status) |
| `surat_masuks` | Data surat masuk (nomor agenda, nomor surat, tanggal, asal surat, perihal, status, file) |
| `surat_keluars` | Data surat keluar (nomor surat otomatis, tanggal, tujuan, perihal, isi surat, status, file) |
| `arsips` | Data arsip surat (gabungan surat masuk dan keluar, dibuat otomatis) |
| `instansis` | Data master instansi (kode, nama, telepon, alamat) |
| `jenis_surats` | Data master jenis surat (nama, kode surat, tipe form, template) |
| `sessions` | Data sesi pengguna aktif |
| `password_reset_tokens` | Token reset password |
| `cache` | Penyimpanan cache aplikasi |
| `jobs` | Antrian pekerjaan background |

### Relasi Antar Tabel

- **SuratMasuk** belongsTo **User** (penginput surat)
- **SuratMasuk** belongsTo **Instansi** (asal pengirim surat)
- **SuratMasuk** hasMany **SuratKeluar** (surat keluar sebagai balasan)
- **SuratMasuk** hasOne **Arsip** (arsip otomatis)
- **SuratKeluar** belongsTo **User** (pembuat surat)
- **SuratKeluar** belongsTo **Instansi** (instansi tujuan)
- **SuratKeluar** belongsTo **JenisSurat** (jenis surat melalui kolom nama)
- **Arsip** belongsTo **SuratMasuk** (opsional)
- **Arsip** belongsTo **SuratKeluar** (opsional)
- **Arsip** belongsTo **User** (penginput)
- **Instansi** hasMany **SuratMasuk** dan **SuratKeluar**
- **User** hasMany **SuratKeluar**

### Soft Deletes

Tabel berikut menggunakan fitur soft deletes untuk mendukung mekanisme Tempat Sampah:
- `surat_masuks`
- `surat_keluars`
- `arsips`
- `instansis`
- `jenis_surats`

---

## Entity Relationship Diagram

ERD belum tersedia dalam bentuk file gambar di project ini. Diagram ERD dapat dibuat dan ditambahkan kemudian berdasarkan struktur database yang telah didokumentasikan di atas.

---

## Screenshot Aplikasi

Screenshot aplikasi belum tersedia dalam project ini. Screenshot dapat ditambahkan kemudian untuk mendokumentasikan tampilan antarmuka pengguna.

---

## Instalasi dan Menjalankan Project

### Prasyarat

- PHP >= 8.2
- Composer
- Node.js dan NPM
- MySQL
- Git

### Langkah Instalasi

```bash
# 1. Clone repository
git clone <repository-url>

# 2. Masuk ke folder project
cd surat-penomoran

# 3. Install dependensi PHP
composer install

# 4. Install dependensi frontend
npm install

# 5. Salin file environment
cp .env.example .env

# 6. Konfigurasi database di file .env (lihat bagian Konfigurasi Environment)

# 7. Generate application key
php artisan key:generate

# 8. Jalankan migration dan seeder
php artisan migrate --seed

# 9. Buat symbolic link untuk storage
php artisan storage:link

# 10. Build aset frontend
npm run build

# 11. Jalankan development server
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`.

### Menjalankan dengan Mode Development

Project ini menyediakan script `composer dev` yang menjalankan server Laravel, queue listener, log viewer (Pail), dan Vite secara bersamaan:

```bash
composer dev
```

### Server WhatsApp (Opsional)

Jika ingin menggunakan fitur pengiriman surat via WhatsApp:

```bash
# Masuk ke folder wa-baileys-server
cd wa-baileys-server

# Install dependensi
npm install

# Jalankan server
node index.js
```

Server WhatsApp API akan berjalan di `http://localhost:3000`. Scan QR code yang muncul di terminal untuk menghubungkan akun WhatsApp.

---

## Konfigurasi Environment

Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi berikut:

### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

### Email (untuk fitur pengiriman surat dan laporan via email)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=email@example.com
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Umum

```env
APP_NAME="Sistem Arsip Surat"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

---

## Akun Demo

Berdasarkan `DatabaseSeeder.php`, terdapat akun demo yang dibuat saat menjalankan seeder:

| Field | Nilai |
|-------|-------|
| **Nama** | Test User |
| **Email** | test@example.com |
| **Password** | password |

> **Catatan:** Akun ini dibuat untuk keperluan pengembangan. Pastikan untuk mengubah kredensial ini sebelum digunakan di lingkungan produksi.

---

## Alur Sistem

```
Landing Page (Welcome)
       │
       ▼
     Login
       │
       ▼
   Dashboard ──────────────────────────────────────────────┐
       │                                                   │
       ├── Data Master                                     │
       │   ├── Data Instansi (CRUD)                        │
       │   └── Data Jenis Surat (CRUD)                     │
       │                                                   │
       ├── Manajemen Surat                                 │
       │   ├── Surat Masuk ────► Arsip Otomatis            │
       │   │   ├── Input surat masuk                       │
       │   │   ├── Upload file PDF                         │
       │   │   ├── Download lembar agenda PDF              │
       │   │   └── Buat balasan (Surat Keluar)             │
       │   │                                               │
       │   ├── Surat Keluar ───► Arsip Otomatis            │
       │   │   ├── Input surat keluar (nomor otomatis)     │
       │   │   ├── Preview surat dari template             │
       │   │   ├── Download PDF                            │
       │   │   ├── Kirim via Email                         │
       │   │   └── Kirim via WhatsApp                      │
       │   │                                               │
       │   ├── Arsip Surat                                 │
       │   │   ├── Lihat & cari arsip                      │
       │   │   └── Ekspor ke CSV                           │
       │   │                                               │
       │   └── Laporan                                     │
       │       ├── Ringkasan statistik dengan grafik       │
       │       ├── Ekspor PDF / Excel                      │
       │       └── Kirim laporan via Email                 │
       │                                                   │
       ├── Pengaturan Akun (edit profil & password)        │
       │                                                   │
       └── Tempat Sampah (restore / hapus permanen)        │
                                                           │
       Logout ◄────────────────────────────────────────────┘
```

---

## Testing

Project ini menggunakan **Pest** sebagai framework testing. Terdapat beberapa test bawaan dari Laravel Breeze:

### Test yang Tersedia

- **Feature Tests:**
  - `ExampleTest.php` - Test respons halaman utama
  - `ProfileTest.php` - Test fitur profil pengguna
  - `Auth/AuthenticationTest.php` - Test login dan logout
  - `Auth/EmailVerificationTest.php` - Test verifikasi email
  - `Auth/PasswordConfirmationTest.php` - Test konfirmasi password
  - `Auth/PasswordResetTest.php` - Test reset password
  - `Auth/PasswordUpdateTest.php` - Test update password
  - `Auth/RegistrationTest.php` - Test registrasi pengguna

- **Unit Tests:**
  - `ExampleTest.php` - Test dasar unit

### Menjalankan Test

```bash
php artisan test
```

atau menggunakan composer script:

```bash
composer test
```

---

## Pengembangan Sistem

Informasi mengenai metode pengembangan yang digunakan tidak dapat dipastikan dari source code. Project ini dikembangkan secara kolaboratif menggunakan Git sebagai version control.

Berdasarkan file `TODO.md` yang ditemukan dalam project, pengembangan dilakukan secara iteratif dengan daftar tugas yang dicatat dan dilacak penyelesaiannya.

---

## Tim Pengembang

Project ini dikembangkan secara kolaboratif oleh:

| Nama |
|------|
| **Fahmi Mutaqin** |
| **Riyan** |
| **Angga** |

---

## Git Workflow

Project ini menggunakan Git dan GitHub untuk version control. Workflow dasar yang digunakan:

```
Repository (GitHub)
       │
       ├── Clone / Pull (mengambil perubahan terbaru)
       │
       ├── Pengembangan lokal
       │
       ├── Commit (menyimpan perubahan)
       │
       └── Push (mengirim perubahan ke repository)
```

---

## Security

Aspek keamanan yang diimplementasikan dalam project ini:

| Aspek | Implementasi |
|-------|-------------|
| **Authentication** | Laravel Breeze (login, register, logout, reset password) |
| **Authorization** | Middleware `auth` untuk melindungi route yang membutuhkan login |
| **CSRF Protection** | Token CSRF pada setiap form (disediakan oleh Laravel) |
| **Password Hashing** | Bcrypt dengan 12 rounds (konfigurasi di `.env`) |
| **Input Validation** | Validasi server-side pada setiap controller (required, email, unique, mimes, max, dll.) |
| **Session Management** | Session berbasis database dengan enkripsi opsional |
| **Signed URL** | URL bertanda tangan untuk download publik surat dan laporan |
| **File Upload Validation** | Validasi tipe file (PDF only) dan ukuran maksimum (2MB) |
| **Soft Deletes** | Data yang dihapus tidak langsung hilang, dapat dipulihkan dari Tempat Sampah |
| **Self-Delete Prevention** | Pengguna tidak dapat menghapus akun miliknya sendiri |

---

## Status Project

Project ini merupakan sistem informasi arsip surat berbasis web yang sedang dalam tahap pengembangan aktif. Fitur-fitur utama seperti manajemen surat masuk, surat keluar, arsip, laporan, dan pengiriman digital (email dan WhatsApp) telah diimplementasikan. Beberapa pengembangan lanjutan seperti template khusus per jenis surat dan penyempurnaan hak akses berbasis role masih dalam proses pengerjaan.

---

## Lisensi

Project ini belum menentukan lisensi secara eksplisit. Silakan hubungi tim pengembang untuk informasi lebih lanjut mengenai hak penggunaan.
