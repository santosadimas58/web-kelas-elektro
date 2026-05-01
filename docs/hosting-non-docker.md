# Deploy Tanpa Docker

Panduan ini untuk shared hosting, cPanel, atau VPS native yang menjalankan PHP langsung tanpa Docker.

## Requirement Server

- PHP 8.3 atau lebih baru.
- Extension PHP: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `zip`.
- MySQL atau MariaDB.
- Composer tersedia di server, atau dependency `vendor/` di-upload dari hasil `composer install --no-dev`.
- Document root domain diarahkan ke folder `public`.
- Folder `storage` dan `bootstrap/cache` writable oleh user web server.

## Environment

Gunakan `.env.hosting.example` sebagai acuan file `.env` di server.

Nilai minimal yang wajib diganti:

```env
APP_KEY=
APP_URL=https://domain-anda.com
DB_DATABASE=nama_database_hosting
DB_USERNAME=user_database_hosting
DB_PASSWORD=password_database_hosting
ADMIN_NAME="Admin Kelas"
ADMIN_EMAIL="admin@domain-anda.com"
ADMIN_PASSWORD="gunakan-password-admin-yang-panjang-dan-acak"
MAIL_FROM_ADDRESS="noreply@domain-anda.com"
RESEND_API_KEY=
```

Generate `APP_KEY` di server:

```bash
php artisan key:generate --force
```

Jika hosting tidak menyediakan terminal, generate key di lokal lalu salin nilainya ke `.env` server.

## Build Sebelum Upload

Jalankan dari lokal:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

Upload project ke hosting, termasuk:

- `app`
- `bootstrap`
- `config`
- `database`
- `public`
- `resources`
- `routes`
- `storage`
- `vendor`
- `.env`
- `artisan`
- `composer.json`
- `composer.lock`

Tidak perlu upload:

- `node_modules`
- `.git`
- file `.env` lokal yang berisi credential development

## Setup Di Server

Pastikan domain mengarah ke folder `public`. Jika control panel memberi pilihan document root, pilih:

```text
/path/ke/project/public
```

Set permission:

```bash
chmod -R 775 storage bootstrap/cache
```

Jalankan migration:

```bash
php artisan migrate --force
```

Jalankan seeder hanya jika memang ingin data awal:

```bash
php artisan db:seed --force
```

Pada `APP_ENV=production`, seeder akan membuat admin dari `ADMIN_NAME`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD`. `ADMIN_PASSWORD` minimal 16 karakter dan harus berisi huruf besar, huruf kecil, angka, dan simbol. User demo `user@example.com` tidak dibuat otomatis.

Jika hanya ingin membuat admin dan pengaturan awal tanpa data demo mahasiswa/galeri, jalankan:

```bash
php artisan db:seed --class=AdminUserSeeder --force
php artisan db:seed --class=SiteSettingSeeder --force
```

Buat storage link:

```bash
php artisan storage:link
```

Jika shared hosting tidak mengizinkan symlink, salin isi `storage/app/public` ke `public/storage` dan ulangi setiap ada file upload baru, atau gunakan fitur file manager/symlink dari panel hosting.

Aktifkan cache production:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Validasi

Jalankan:

```bash
php artisan about
php artisan migrate:status
```

Target hasil:

- `Environment`: `production`
- `Debug Mode`: `OFF`
- `Database`: `mysql`
- semua migration utama berstatus `Ran`

## Catatan Shared Hosting

Jika hosting tidak bisa mengubah document root ke `public`, jangan memindahkan semua file Laravel ke `public_html` begitu saja karena `.env`, `vendor`, dan source code bisa terekspos. Solusi yang lebih aman adalah meminta hosting mengarahkannya ke folder `public`, memakai subdomain dengan document root custom, atau memakai VPS/native hosting yang memberi akses konfigurasi web root.
