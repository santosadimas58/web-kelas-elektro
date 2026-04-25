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
- PHP 8.4
- MySQL 8
- Vite
- Tailwind CSS
- Docker Compose

## Kebutuhan Lokal

- PHP 8.4+
- Composer
- Node.js + npm
- MySQL atau MariaDB

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

- 1 admin default
- 1 user default
- pengaturan website
- minimal 15 data mahasiswa demo
- beberapa item galeri demo

## Akun Default

Admin:

- Email: `admin@example.com`
- Password: `password`

User:

- Email: `user@example.com`
- Password: `password`

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
- pastikan `.env` tidak masuk Git
- generate `APP_KEY` di server
- jalankan migration dan seeding sesuai kebutuhan
- jalankan `php artisan storage:link`
- pastikan `storage` dan `bootstrap/cache` writable
- jalankan `npm run build`
- ganti akun demo default jika website dipublikasikan

## Catatan

- Jika environment lama masih memakai struktur tabel `students` versi lama, jalankan migration terbaru sebelum dipakai penuh.
- Warning cache hasil test dari `vendor/pestphp/pest/.temp/test-results` bisa muncul jika permission vendor terbatas, tetapi tidak mempengaruhi hasil test fitur.
