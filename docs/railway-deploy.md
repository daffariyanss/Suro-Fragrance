# Railway Deployment - Suro Fragrance

## Yang Dibuat di Railway
- 1 service untuk aplikasi web
- 1 service database MySQL

## Langkah Singkat
1. Buat project baru di Railway.
2. Hubungkan repository GitHub project ini.
3. Railway akan membangun image dari [`Dockerfile`](/Users/admin/suro-fragrance/Dockerfile).
4. Tambahkan service database MySQL.
5. Set environment variables pada service web.

## Environment Variables
Gunakan nilai berikut di service web:

```ini
CI_ENVIRONMENT=production
app.baseURL=https://nama-app-anda.up.railway.app/
database.default.hostname=<host mysql dari railway>
database.default.database=<nama database railway>
database.default.username=<username mysql railway>
database.default.password=<password mysql railway>
database.default.DBDriver=MySQLi
database.default.port=3306
```

## Setelah Deploy
- Import file `.sql` ke database Railway
- Cek login admin dan customer
- Pastikan transaksi dan riwayat pembelian berjalan

## URL Aplikasi
Setelah deploy sukses, Railway akan memberi URL seperti:

```text
https://nama-app-anda.up.railway.app
```

