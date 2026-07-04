# Deployment Guide - Suro Fragrance

## Tujuan
Panduan ini membantu memindahkan aplikasi CodeIgniter 4 ke server hosting agar dapat diakses online.

## Kebutuhan
- PHP 8.2 atau lebih baru
- MySQL / MariaDB
- Extension PHP: `intl`, `mbstring`, `json`, `mysqlnd`, `curl`
- Web server: Apache atau Nginx

## Struktur Folder Aman
Pastikan document root hosting mengarah ke folder `public/`, bukan ke root project.

## Langkah Deployment

### 1. Upload source code
- Upload seluruh project ke hosting atau VPS.
- Jika memakai shared hosting, taruh project di folder di luar `public_html` bila memungkinkan.

### 2. Arahkan web root ke `public`
- Jika bisa atur Virtual Host:
  - document root = `/path/to/project/public`
- Jika shared hosting biasa:
  - isi `public_html/index.php` dengan bootstrap CI4 yang benar atau salin isi `public/` ke `public_html` dengan penyesuaian path.

### 3. Buat database
- Buat database MySQL / MariaDB di panel hosting.
- Import file `.sql` project ke database tersebut.

### 4. Atur file `.env`
Sesuaikan konfigurasi berikut:

```ini
CI_ENVIRONMENT = production
app.baseURL = 'https://domain-anda.com/'

database.default.hostname = localhost
database.default.database = nama_database
database.default.username = user_database
database.default.password = password_database
database.default.DBDriver = MySQLi
```

### 5. Generate key jika diperlukan
Pastikan konfigurasi keamanan dan session sudah sesuai untuk production.

### 6. Jalankan migrasi / seed bila dibutuhkan
Jika hosting mendukung SSH:

```bash
php spark migrate
php spark db:seed AdminUserSeeder
```

### 7. Cek permission folder
Pastikan folder berikut writable:
- `writable/cache`
- `writable/logs`
- `writable/session`
- `writable/uploads` jika ada upload file

### 8. Testing setelah deploy
- Login customer
- Login admin
- Transaksi
- Riwayat pembelian
- Edit / batal transaksi
- Responsif mobile

## Bukti Deployment
Isi bagian berikut setelah aplikasi online:

- URL aplikasi: `https://...`
- Username admin: `admin@gmail.com`
- Password admin: `...`
- Screenshot halaman login
- Screenshot dashboard
- Screenshot transaksi
- Screenshot riwayat pembelian

## Catatan Penting
- Jangan upload folder `vendor/` ke public web root jika server mengizinkan pemisahan folder.
- Jika memakai shared hosting, pastikan file rahasia seperti `.env` tidak dapat diakses publik.
- `public/` adalah folder yang harus diekspos ke internet.

