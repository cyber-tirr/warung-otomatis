# Instalasi dan Penggunaan Aplikasi Warung Kopi Otomatis

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (untuk asset compilation)
- Laravel 12

## Langkah Instalasi

### 1. Clone atau Setup Project
Pastikan Anda sudah berada di direktori project:
```bash
cd c:\laragon\www\warung-kopi-otomatis
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Copy file `.env.example` menjadi `.env` (jika belum ada):
```bash
copy .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warung_kopi
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Buat Database
Buat database MySQL dengan nama `warung_kopi` melalui phpMyAdmin atau command line:
```sql
CREATE DATABASE warung_kopi;
```

### 6. Jalankan Migrasi Database
```bash
php artisan migrate
```

### 7. Jalankan Seeder (Data Awal)
Seeder akan membuat 2 user default:
```bash
php artisan db:seed
```

**User Default:**
- **Admin**
  - Email: `admin@warungkopi.com`
  - Password: `admin123`
  
- **Operator**
  - Email: `operator@warungkopi.com`
  - Password: `operator123`

### 8. Buat Storage Link (untuk upload gambar)
```bash
php artisan storage:link
```

### 9. Compile Assets (Optional)
```bash
npm run dev
```
Atau untuk production:
```bash
npm run build
```

### 10. Jalankan Aplikasi
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://127.0.0.1:8000`

---

## Struktur Aplikasi

### Halaman Public (Pelanggan)
- **URL**: `http://127.0.0.1:8000/`
- Menampilkan daftar menu dalam bentuk card
- Pelanggan dapat klik menu untuk melihat detail dan memesan
- Form pemesanan mencakup: nama, telepon, alamat

### Halaman Login Admin/Operator
- **URL**: `http://127.0.0.1:8000/login`
- Login untuk Admin dan Operator

### Dashboard Admin/Operator
- **URL**: `http://127.0.0.1:8000/dashboard`
- Statistik: Total Pesanan, Total Produk, Total Pendapatan

---

## Fitur Berdasarkan Role

### Admin (Akses Penuh)
1. **Kelola User** (`/admin/users`)
   - CRUD user (Admin/Operator)
   
2. **Kelola Kategori** (`/admin/categories`)
   - CRUD kategori produk
   
3. **Kelola Produk** (`/admin/products`)
   - CRUD produk/menu (nama, deskripsi, harga, gambar, kategori)
   
4. **Kelola Pesanan** (`/admin/orders`)
   - Lihat semua pesanan
   - Update status pesanan (pending, processed, completed, cancelled)
   - Hapus pesanan
   
5. **Laporan Penjualan** (`/admin/reports`)
   - Lihat laporan transaksi
   - Filter berdasarkan tanggal
   - Total pendapatan dari `order_summaries`

### Operator (Akses Terbatas)
1. **Kelola Produk** (`/admin/products`)
   - CRUD produk/menu
   
2. **Kelola Pesanan** (`/admin/orders`)
   - Lihat pesanan
   - Update status pesanan
   
3. **Laporan Penjualan** (`/admin/reports`)
   - Lihat laporan (read-only)

---

## Struktur Database

### Tabel `users`
- id, name, email, password, role (admin/operator), timestamps

### Tabel `categories`
- id, name, timestamps

### Tabel `products`
- id, category_id, name, description, price, image, timestamps

### Tabel `customers`
- id, name, phone, address, timestamps

### Tabel `orders`
- id, customer_id, product_id, quantity, total_price, status, timestamps

### Tabel `order_summaries`
- id, order_id, subtotal, timestamps

---

## Alur Pemesanan Pelanggan

1. Pelanggan membuka halaman utama (`/`)
2. Melihat daftar menu dalam bentuk card
3. Klik salah satu menu → muncul modal dengan detail produk
4. Isi form pemesanan:
   - Jumlah pesanan
   - Nama pelanggan
   - Nomor telepon
   - Alamat
5. Klik "Pesan Sekarang"
6. Data pelanggan disimpan ke tabel `customers`
7. Pesanan disimpan ke tabel `orders`
8. Summary disimpan ke tabel `order_summaries`
9. Admin/Operator dapat melihat dan mengelola pesanan di dashboard

---

## Catatan Penting

- **Upload Gambar Produk**: Gambar disimpan di `storage/app/public/products/`
- **Middleware Autentikasi**: Menggunakan session native PHP (bukan Laravel Breeze/Jetstream)
- **Middleware Role**: Membatasi akses berdasarkan role (admin/operator)
- **Bootstrap 5**: Digunakan untuk styling UI
- **Bootstrap Icons**: Untuk icon

---

## Troubleshooting

### Error "Class 'Storage' not found"
Pastikan sudah menjalankan:
```bash
php artisan storage:link
```

### Gambar tidak muncul
1. Pastikan storage link sudah dibuat
2. Cek permission folder `storage/app/public`
3. Pastikan file `.env` sudah dikonfigurasi dengan benar

### Error 403 Forbidden
Pastikan user yang login memiliki role yang sesuai untuk mengakses halaman tersebut.

---

## Pengembangan Lebih Lanjut

Aplikasi ini dapat dikembangkan dengan fitur tambahan:
- Export laporan ke PDF/Excel
- Notifikasi real-time untuk pesanan baru
- Sistem pembayaran online
- Rating dan review produk
- Multi-branch management
- API untuk mobile app

---

## Kontak & Support

Jika ada pertanyaan atau masalah, silakan hubungi developer atau buat issue di repository project.

**Selamat menggunakan Aplikasi Warung Kopi Otomatis!** ☕
