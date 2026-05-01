# Kelas Elektronika Industri

Website dokumentasi kelas berbasis Laravel untuk menampilkan profil mahasiswa, galeri kelas, halaman publik, dashboard user, dan admin panel pengelolaan konten.

## Ringkasan

Project ini dirancang agar:

- siap dipakai untuk demo kelas
- mudah dipindahkan ke server lain
- punya seed data awal
- punya role admin dan user
- punya halaman publik yang bisa dikelola dari dashboard

## Fitur

- Halaman publik:
  - Beranda
  - Tentang
  - Mahasiswa
  - Galeri
  - Kontak
- Dashboard admin:
  - Statistik ringkas
  - CRUD mahasiswa
  - Manajemen galeri
  - Manajemen user
  - Pesan kontak
  - Pengaturan konten website
- Dashboard user:
  - Edit profil
  - Upload foto galeri
- Security:
  - route admin diproteksi `auth + role + gate`
  - CSRF aktif
  - validasi upload gambar
  - public registration ditutup; akun user dibuat oleh admin
  - rate limiting untuk form kontak, upload galeri, reset password, dan aksi password sensitif
  - fallback image aman
  - cleanup file lama saat update/delete
- Testing:
  - login
  - akses admin
  - CRUD mahasiswa
  - pembatasan role
  - audit upload dan security dasar

## Teknologi

- Laravel 13
- PHP 8.3+
- MySQL 8
- Vite
- Tailwind CSS
- Docker Compose

## Kebutuhan Lokal

- PHP 8.3+
- Composer
- Node.js + npm
- MySQL atau MariaDB
- Extension PHP `pdo_mysql` jika memakai MySQL dari host/non-Docker

## Instalasi Lokal

1. Clone project dan masuk ke direktori project.

```bash
git clone <repository-url>
cd web-kelas-elektro
```

2. Install dependency backend.

```bash
composer install
```

3. Install dependency frontend.

```bash
npm install
```

4. Salin file environment.

```bash
cp .env.example .env
```

5. Atur koneksi database pada `.env`.

Contoh minimal:

```env
APP_NAME="Kelas Elektronika Industri"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

ADMIN_NAME="Admin Kelas"
# ADMIN_EMAIL=admin@example.com
# ADMIN_PASSWORD=password
# STUDENT_DEFAULT_PASSWORD=password

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_kelas_elektro
DB_USERNAME=root
DB_PASSWORD=
```

6. Generate application key.

```bash
php artisan key:generate
```

7. Jalankan migrasi dan seeding.

```bash
php artisan migrate --seed
```

8. Buat storage link.

```bash
php artisan storage:link
```

9. Jalankan aplikasi.

Untuk mode development penuh:

```bash
composer run dev
```

Atau dipisah:

```bash
php artisan serve
npm run dev
```

## Penggunaan Docker

Project ini sudah menyertakan:

- [Dockerfile](/home/dimas/web-kelas-elektro/Dockerfile)
- [docker-compose.yml](/home/dimas/web-kelas-elektro/docker-compose.yml)
- [docker-entrypoint.sh](/home/dimas/web-kelas-elektro/docker-entrypoint.sh)

Service yang tersedia:

- `app` Laravel
- `mysql` database MySQL 8
- `phpmyadmin` untuk akses database via browser

### Menjalankan Dengan Docker

```bash
docker compose up --build
```

Setelah container aktif:

- aplikasi: `http://localhost:8001`
- phpMyAdmin: `http://localhost:8082`
- MySQL host lokal: `127.0.0.1:3307`

### Konfigurasi Database Docker

Nilai database dari `docker-compose.yml`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=web_kelas_elektro
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

`docker-entrypoint.sh` akan:

- menunggu MySQL siap
- menjalankan migrasi
- menjalankan seed jika user belum ada
- menjalankan server Laravel

Jika perlu menjalankan perintah manual di container:

```bash
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
docker compose exec app php artisan test
```

## Deploy Tanpa Docker

Project ini bisa dipasang di shared hosting, cPanel, atau VPS native tanpa Docker selama server menyediakan PHP 8.3+, MySQL/MariaDB, dan extension `pdo_mysql`.

Gunakan file [.env.hosting.example](/home/dimas/web-kelas-elektro/.env.hosting.example) sebagai acuan konfigurasi production. Panduan lengkap ada di [docs/hosting-non-docker.md](/home/dimas/web-kelas-elektro/docs/hosting-non-docker.md).

Hal paling penting untuk hosting non-Docker:

- document root domain harus mengarah ke folder `public`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_HOST` biasanya `127.0.0.1` atau host database dari provider
- `storage` dan `bootstrap/cache` harus writable
- jalankan `php artisan migrate --force`
- jalankan `php artisan storage:link`
- jalankan `npm run build` sebelum upload jika hosting tidak menyediakan Node.js

## Deploy Percobaan ke Vercel

Project ini menyertakan konfigurasi dasar Vercel:

- [vercel.json](/home/dimas/web-kelas-elektro/vercel.json)
- [api/index.php](/home/dimas/web-kelas-elektro/api/index.php)
- [.vercelignore](/home/dimas/web-kelas-elektro/.vercelignore)
- [.env.vercel.example](/home/dimas/web-kelas-elektro/.env.vercel.example)

Vercel tidak menyediakan runtime PHP resmi. Konfigurasi ini memakai community runtime `vercel-php@0.7.4`, jadi cocok untuk percobaan/preview, bukan rekomendasi utama untuk production Laravel yang butuh upload file lokal dan proses backend jangka panjang.

Langkah awal:

1. Push commit terbaru ke GitHub.
2. Import repository dari dashboard Vercel.
3. Pastikan root directory tetap root repository.
4. Gunakan build command `npm run build` jika tidak otomatis terbaca dari `vercel.json`.
5. Salin nilai dari [.env.vercel.example](/home/dimas/web-kelas-elektro/.env.vercel.example) ke Environment Variables Vercel.
6. Isi `APP_KEY` dengan hasil `php artisan key:generate --show`.
7. Gunakan database eksternal MySQL/PostgreSQL yang bisa diakses dari Vercel.
8. Setelah deploy pertama, jalankan migration dari lokal ke database production:

```bash
php artisan migrate --force --seed
```

Catatan penting untuk Vercel:

- set `LOG_CHANNEL=stderr`
- set `SESSION_DRIVER=database`
- set `CACHE_STORE=database`
- set `LARAVEL_STORAGE_PATH=/tmp/storage`
- upload foto ke disk lokal tidak permanen di Vercel; gunakan object storage seperti S3/R2/Supabase Storage jika fitur upload harus dipakai serius

## Migration dan Seeding

Menjalankan migration:

```bash
php artisan migrate
```

Rollback migration terakhir:

```bash
php artisan migrate:rollback
```

Menjalankan seeder penuh:

```bash
php artisan db:seed
```

Menjalankan seeder tertentu:

```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=StudentSeeder
php artisan db:seed --class=GallerySeeder
```

## Seeder yang Tersedia

- `DatabaseSeeder`
- `AdminUserSeeder`
- `DemoUserSeeder`
- `SiteSettingSeeder`
- `StudentSeeder`
- `GallerySeeder`

Seeder default akan menyiapkan:

- 1 admin
- 10 akun mahasiswa dari daftar kelas di `config/classroom.php`
- pengaturan website
- minimal 15 data mahasiswa demo
- beberapa item galeri demo

Public registration ditutup. Akun baru hanya bisa dibuat oleh admin melalui menu admin `Kelola Akun`.

## Akun Development

Untuk local development, jika `ADMIN_EMAIL` dan `ADMIN_PASSWORD` tidak diatur, seeder akan membuat akun:

- Email: `admin@example.com`
- Password: `password`

Seeder juga membuat 10 akun mahasiswa dengan email dari daftar kelas. Untuk local development, password default mahasiswa adalah:

- Password: `password`

Untuk production, isi admin asli dan password awal mahasiswa di `.env` server:

```env
ADMIN_NAME="Admin Kelas"
ADMIN_EMAIL="admin@domain-anda.com"
ADMIN_PASSWORD="gunakan-password-admin-yang-panjang-dan-acak"
STUDENT_DEFAULT_PASSWORD="gunakan-password-awal-mahasiswa"
```

Pada environment `production`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`, dan `STUDENT_DEFAULT_PASSWORD` wajib diisi sebelum seeding. `ADMIN_PASSWORD` minimal 16 karakter dan harus berisi huruf besar, huruf kecil, angka, dan simbol.

Contoh membuat password admin acak:

```bash
openssl rand -base64 24
```

## Testing

Menjalankan seluruh test:

```bash
php artisan test
```

Menjalankan test flow utama:

```bash
php artisan test tests/Feature/MainProjectFlowTest.php
```

Menjalankan audit upload dan security:

```bash
php artisan test tests/Feature/SecurityAndUploadAuditTest.php
```

## Struktur Fitur Penting

- [routes/web.php](/home/dimas/web-kelas-elektro/routes/web.php)
- [app/Http/Controllers/PublicPageController.php](/home/dimas/web-kelas-elektro/app/Http/Controllers/PublicPageController.php)
- [app/Http/Controllers/Admin/StudentController.php](/home/dimas/web-kelas-elektro/app/Http/Controllers/Admin/StudentController.php)
- [app/Http/Controllers/Admin/GalleryItemController.php](/home/dimas/web-kelas-elektro/app/Http/Controllers/Admin/GalleryItemController.php)
- [app/Http/Controllers/Admin/SiteSettingController.php](/home/dimas/web-kelas-elektro/app/Http/Controllers/Admin/SiteSettingController.php)
- [app/Models/Student.php](/home/dimas/web-kelas-elektro/app/Models/Student.php)
- [resources/views/pages/home.blade.php](/home/dimas/web-kelas-elektro/resources/views/pages/home.blade.php)

## Checklist Sebelum Hosting

- set `APP_ENV=production`
- set `APP_DEBUG=false`
- set `APP_URL` sesuai domain final
- pastikan server punya extension PHP `pdo_mysql`
- pastikan `.env` tidak masuk Git
- generate `APP_KEY` di server
- jalankan migration dan seeding sesuai kebutuhan
- jalankan `php artisan storage:link`
- pastikan `storage` dan `bootstrap/cache` writable
- jalankan `npm run build`
- set `ADMIN_EMAIL` dan `ADMIN_PASSWORD` untuk akun admin production
- set `STUDENT_DEFAULT_PASSWORD` untuk akun awal mahasiswa

## Catatan

- Jika environment lama masih memakai struktur tabel `students` versi lama, jalankan migration terbaru sebelum dipakai penuh.
- Warning cache hasil test dari `vendor/pestphp/pest/.temp/test-results` bisa muncul jika permission vendor terbatas, tetapi tidak mempengaruhi hasil test fitur.
