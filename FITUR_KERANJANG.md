# Fitur Keranjang & Pemesanan oleh Admin/Operator

**Versi: 2.0 - Updated: 07 Oktober 2025**

## Deskripsi Fitur

Sistem pemesanan telah diubah dengan alur kerja baru:

### 1. **Halaman Pelanggan (Public)**
- Pelanggan dapat melihat menu dan detail produk
- Pelanggan dapat menambahkan produk ke keranjang
- Keranjang disimpan di localStorage browser
- **Pelanggan TIDAK bisa membuat pesanan sendiri**
- Pelanggan harus menghubungi admin/operator untuk memproses pesanan

### 2. **Halaman Admin/Operator**
- Admin/Operator yang membuat pesanan dari keranjang pelanggan
- Admin/Operator mengisi data pelanggan:
  - Nama
  - Nomor Meja
- Admin/Operator memilih metode pembayaran:
  - **Tunai (Cash)** - Pembayaran langsung di kasir
  - **Bayar Nanti** - Pembayaran ditunda
- Admin/Operator menentukan status pembayaran:
  - **Sudah Dibayar** - Pesanan langsung diproses
  - **Belum Dibayar** - Pesanan menunggu pembayaran

### 3. **Struk Pesanan**
- Setelah pesanan dibuat, sistem otomatis menampilkan struk
- Struk dapat dicetak langsung
- Struk berisi:
  - Informasi transaksi (nomor, tanggal)
  - Data pelanggan
  - Detail pesanan (item, jumlah, harga)
  - Total pembayaran
  - Metode pembayaran
  - Status pembayaran
  - Status pesanan

## Cara Penggunaan

### Untuk Pelanggan:
1. Buka halaman utama website
2. Lihat menu yang tersedia
3. Klik produk untuk melihat detail
4. Pilih jumlah dan klik "Tambah ke Keranjang"
5. Klik tombol "Keranjang" di navbar untuk melihat item
6. Hubungi admin/operator untuk memproses pesanan

### Untuk Admin/Operator:
1. Login ke dashboard admin
2. Buka halaman "Kelola Pesanan"
3. Klik tombol "Buat Pesanan Baru"
4. Sistem akan menampilkan item dari keranjang pelanggan
5. Jika keranjang kosong, buka halaman menu di tab baru untuk menambah item
6. Isi data pelanggan:
   - Nama pelanggan
   - Nomor telepon
   - Alamat lengkap
7. Pilih metode pembayaran (Tunai/Bayar Nanti)
8. Pilih status pembayaran (Sudah Dibayar/Belum Dibayar)
9. Klik "Proses Pesanan"
10. Sistem akan menampilkan struk yang bisa dicetak

### Mencetak Struk:
1. Setelah pesanan dibuat, struk otomatis ditampilkan
2. Klik tombol "Cetak Struk" untuk mencetak
3. Atau dari halaman "Kelola Pesanan", klik icon receipt (🧾) pada pesanan yang ingin dicetak

## Fitur Keranjang

### Fungsi Keranjang:
- **Tambah Item**: Menambahkan produk ke keranjang dengan jumlah tertentu
- **Update Jumlah**: Mengubah jumlah item dengan tombol +/-
- **Hapus Item**: Menghapus item tertentu dari keranjang
- **Kosongkan Keranjang**: Menghapus semua item sekaligus
- **Sinkronisasi**: Keranjang tersinkronisasi antara halaman pelanggan dan admin

### Penyimpanan:
- Keranjang disimpan di **localStorage** browser
- Data tetap tersimpan meskipun browser ditutup
- Data keranjang dapat diakses dari halaman pelanggan dan admin
- Keranjang otomatis dikosongkan setelah pesanan berhasil dibuat

## Routes Baru

### Public Routes:
```
GET  /                      - Halaman menu pelanggan
GET  /cart                  - Get cart data (API)
POST /cart/add              - Add item to cart (API)
POST /cart/update           - Update cart item (API)
POST /cart/remove           - Remove item from cart (API)
POST /cart/clear            - Clear cart (API)
```

### Admin Routes:
```
GET  /admin/orders/create           - Form buat pesanan baru
POST /admin/orders                  - Store pesanan baru
GET  /admin/orders/{id}/receipt     - Tampilkan struk pesanan
```

## File yang Dibuat/Dimodifikasi

### Controllers:
- `app/Http/Controllers/CartController.php` (Baru)
- `app/Http/Controllers/Admin/AdminOrderController.php` (Dimodifikasi)

### Views:
- `resources/views/home.blade.php` (Dimodifikasi)
- `resources/views/admin/orders/index.blade.php` (Dimodifikasi)
- `resources/views/admin/orders/create.blade.php` (Baru)
- `resources/views/admin/orders/receipt.blade.php` (Baru)

### Routes:
- `routes/web.php` (Dimodifikasi)

## Keuntungan Sistem Baru

1. **Kontrol Penuh**: Admin/operator memiliki kontrol penuh atas pesanan
2. **Data Akurat**: Data pelanggan diisi langsung oleh admin, mengurangi kesalahan input
3. **Fleksibel**: Mendukung berbagai metode pembayaran dan status
4. **Struk Otomatis**: Struk langsung tersedia setelah pesanan dibuat
5. **Mudah Dicetak**: Struk dapat dicetak dengan satu klik
6. **Sinkronisasi Real-time**: Keranjang tersinkronisasi antara pelanggan dan admin

## Catatan Penting

- Keranjang menggunakan localStorage, jadi data spesifik per browser
- Jika admin menggunakan komputer berbeda, keranjang tidak akan tersinkronisasi
- Untuk sinkronisasi lintas device, bisa dikembangkan dengan session backend
- Pastikan printer sudah terkonfigurasi untuk mencetak struk
- Struk dioptimalkan untuk ukuran kertas A4

## Troubleshooting

### Keranjang Tidak Muncul di Admin:
- Pastikan browser yang digunakan sama dengan pelanggan
- Atau buka halaman menu di tab baru untuk menambah item

### Struk Tidak Bisa Dicetak:
- Pastikan printer sudah terhubung
- Cek pengaturan print di browser
- Gunakan Chrome/Edge untuk hasil terbaik

### Data Keranjang Hilang:
- Jangan clear localStorage browser
- Jangan gunakan mode incognito/private
- Backup data penting sebelum clear browser data
