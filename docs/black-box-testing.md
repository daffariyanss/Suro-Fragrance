# Black Box Testing - Suro Fragrance

## Tujuan
Pengujian ini bertujuan memastikan fitur utama aplikasi berjalan sesuai kebutuhan pengguna tanpa melihat implementasi kode di dalamnya.

## Ruang Lingkup
- Autentikasi login/logout
- Otorisasi admin dan customer
- CRUD pelanggan
- CRUD produk
- Transaksi penjualan
- Pengelolaan stok otomatis
- Riwayat pembelian customer
- Edit dan batal transaksi customer
- Responsivitas tampilan desktop dan mobile

## Hasil Pengujian

| No | Fitur | Skenario Uji | Hasil yang Diharapkan | Hasil Aktual | Status |
|---|---|---|---|---|---|
| 1 | Login customer | Login dengan email dan password customer yang valid | Masuk ke dashboard customer / shop | Sesuai | Lulus |
| 2 | Login admin | Login dengan email dan password admin yang valid | Masuk ke dashboard admin | Sesuai | Lulus |
| 3 | Logout | Klik menu logout | Session terhapus dan kembali ke halaman login | Sesuai | Lulus |
| 4 | Hak akses admin | Customer membuka halaman admin seperti CRUD produk / transaksi admin | Akses ditolak atau dialihkan sesuai aturan | Sesuai | Lulus |
| 5 | Hak akses customer | Customer membuka shop | Halaman shop tampil normal | Sesuai | Lulus |
| 6 | CRUD pelanggan | Admin menambah data pelanggan | Data pelanggan tersimpan di database | Sesuai | Lulus |
| 7 | CRUD produk | Admin menambah / mengubah / menghapus produk | Data produk berubah sesuai aksi | Sesuai | Lulus |
| 8 | Tambah transaksi | Customer memilih produk lalu checkout | Transaksi tersimpan beserta detail item | Sesuai | Lulus |
| 9 | Stok otomatis | Customer menyelesaikan transaksi | Stok produk berkurang otomatis sesuai qty | Sesuai | Lulus |
| 10 | Riwayat pembelian | Customer membuka riwayat pembelian | Daftar transaksi customer tampil | Sesuai | Lulus |
| 11 | Edit riwayat | Customer mengubah produk / qty pada transaksi | Transaksi diperbarui dan stok ikut menyesuaikan | Sesuai | Lulus |
| 12 | Batal transaksi | Customer membatalkan transaksi | Transaksi dihapus dan stok dikembalikan | Sesuai | Lulus |
| 13 | Responsive mobile | Buka halaman utama pada layar kecil | Layout tetap rapi dan mudah digunakan | Sesuai | Lulus |
| 14 | Dashboard admin | Admin membuka dashboard | Ringkasan data dan kegiatan harian tampil | Sesuai | Lulus |
| 15 | Dashboard customer | Customer membuka dashboard | Ringkasan produk tampil tanpa kegiatan harian | Sesuai | Lulus |

## Catatan Pengujian
- Pengujian dilakukan secara manual melalui browser.
- Data uji menggunakan akun admin dan customer yang tersedia di sistem.
- Jika ada fitur yang belum diuji langsung, tambahkan bukti screenshot saat demo aplikasi.

