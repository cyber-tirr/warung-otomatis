# Fitur Pembayaran Cash dengan Kembalian

## 📋 Deskripsi
Fitur ini memungkinkan operator/admin untuk menginput jumlah uang yang dibayarkan pelanggan saat pembayaran cash, sistem akan otomatis menghitung kembalian dan mencetaknya di struk.

## ✨ Fitur Utama

### 1. **Halaman Konfirmasi Pembayaran**
- Muncul otomatis setelah membuat pesanan dengan metode pembayaran **Cash**
- Menampilkan ringkasan pesanan lengkap
- Form input jumlah uang yang dibayarkan pelanggan

### 2. **Perhitungan Otomatis**
- Sistem otomatis menghitung kembalian
- Validasi: uang yang dibayar harus >= total pembayaran
- Real-time calculation saat operator mengetik

### 3. **Tombol Nominal Cepat**
- **Uang Pas**: Langsung set sesuai total
- **Nominal Umum**: Rp 20.000, Rp 50.000, Rp 100.000, dll
- Mempercepat proses input

### 4. **Struk yang Diperbaiki**
- Ukuran lebih kecil (80mm thermal printer format)
- Desain modern dengan font monospace
- Menampilkan:
  - Total Pembayaran
  - Uang Dibayar
  - Kembalian
  - Informasi lengkap pesanan

## 🔄 Alur Kerja

### Untuk Pembayaran Cash:
```
1. Operator membuat pesanan baru
   ↓
2. Pilih metode pembayaran: Cash
   ↓
3. Submit pesanan
   ↓
4. Redirect ke halaman Konfirmasi Pembayaran
   ↓
5. Operator input jumlah uang yang dibayar pelanggan
   ↓
6. Sistem hitung kembalian otomatis
   ↓
7. Klik "Proses & Cetak Struk"
   ↓
8. Redirect ke halaman struk
   ↓
9. Cetak struk (dengan info uang dibayar & kembalian)
```

### Untuk Pembayaran Non-Cash (Bayar Nanti):
```
1. Operator membuat pesanan baru
   ↓
2. Pilih metode pembayaran: Bayar Nanti
   ↓
3. Submit pesanan
   ↓
4. Langsung ke halaman struk (skip konfirmasi pembayaran)
```

## 💾 Database Changes

### Tabel: `payments`
Ditambahkan 2 kolom baru:
- `cash_paid` (decimal 15,2): Jumlah uang yang dibayarkan pelanggan
- `change_amount` (decimal 15,2): Jumlah kembalian

## 📁 File yang Dibuat/Dimodifikasi

### File Baru:
1. `database/migrations/2025_10_08_094200_add_cash_payment_fields_to_payments_table.php`
2. `resources/views/admin/orders/payment-confirmation.blade.php`

### File Dimodifikasi:
1. `app/Models/Payment.php` - Tambah fillable fields
2. `app/Http/Controllers/Admin/AdminOrderController.php` - Tambah methods:
   - `paymentConfirmation()` - Tampilkan form pembayaran
   - `processPayment()` - Proses pembayaran dan hitung kembalian
3. `routes/web.php` - Tambah routes baru
4. `resources/views/admin/orders/receipt.blade.php` - Update tampilan struk
5. `resources/views/admin/orders/index.blade.php` - Tambah tombol proses pembayaran

## 🎯 Cara Penggunaan

### Membuat Pesanan dengan Cash:
1. Login sebagai Admin/Operator
2. Klik **"Buat Pesanan Baru"**
3. Pilih produk dan tambahkan ke keranjang
4. Isi data pelanggan (nama & nomor meja)
5. Pilih **"Tunai (Cash)"** sebagai metode pembayaran
6. Status pembayaran: **"Belum Lunas"**
7. Klik **"Buat Pesanan"**

### Input Pembayaran:
1. Setelah pesanan dibuat, akan muncul halaman **Konfirmasi Pembayaran**
2. Lihat total yang harus dibayar
3. Input jumlah uang yang diberikan pelanggan
   - Bisa ketik manual
   - Atau gunakan tombol nominal cepat
4. Sistem akan otomatis menampilkan kembalian
5. Klik **"Proses & Cetak Struk"**

### Cetak Struk:
1. Setelah pembayaran diproses, akan muncul halaman struk
2. Struk menampilkan:
   - Info pesanan lengkap
   - Total pembayaran
   - Uang yang dibayar
   - Kembalian
3. Klik **"Cetak Struk"** untuk print

### Proses Pembayaran yang Tertunda:
Jika ada pesanan cash yang belum diproses pembayarannya:
1. Buka **Kelola Pesanan**
2. Cari pesanan dengan status pembayaran **"Belum Lunas"**
3. Klik tombol **💰** (icon cash) untuk proses pembayaran
4. Lanjutkan dengan input pembayaran seperti biasa

## 🖨️ Format Struk

Struk menggunakan format thermal printer (80mm) dengan informasi:

```
================================
        ☕
   WARUNG KOPI OTOMATIS
   Jl. Contoh No. 123, Kota
   Telp: (021) 12345678
================================
No. Transaksi    #000001
Tanggal          08/10/2025 09:42
Pelanggan        John Doe
Meja             5
================================
Kopi Hitam
2 x  Rp 15.000   Rp 30.000

Es Teh
1 x  Rp 5.000    Rp 5.000
================================
TOTAL            Rp 35.000
================================
Metode           TUNAI
Status           ✓ LUNAS
- - - - - - - - - - - - - - - -
Uang Dibayar     Rp 100.000
Kembalian        Rp 65.000
================================
      ✓ SELESAI
================================
     Terima Kasih!
   Selamat Menikmati
   08/10/2025 09:42:14
================================
```

## ⚠️ Validasi

1. **Uang dibayar harus >= Total**: Sistem akan menampilkan warning jika kurang
2. **Tombol submit disabled**: Sampai jumlah uang valid
3. **Minimal input**: Sesuai dengan total pembayaran

## 🔧 Konfigurasi Print

Struk sudah dioptimalkan untuk:
- **Ukuran kertas**: 80mm (thermal printer)
- **Auto-sizing**: Otomatis menyesuaikan saat print
- **Print-friendly**: Hanya struk yang tercetak, UI dashboard disembunyikan

## 📝 Catatan

- Fitur ini hanya untuk metode pembayaran **Cash**
- Untuk **Bayar Nanti**, langsung ke struk tanpa input pembayaran
- Data kembalian tersimpan di database untuk keperluan laporan
- Struk bisa dicetak ulang kapan saja dari menu **Kelola Pesanan**

## 🎨 Peningkatan UI/UX

1. **Real-time calculation**: Kembalian langsung muncul saat ketik
2. **Quick buttons**: Tombol nominal cepat untuk efisiensi
3. **Visual feedback**: Warning jika uang kurang
4. **Responsive design**: Tampilan bagus di semua ukuran layar
5. **Print optimization**: Hasil cetak profesional

---

**Dibuat**: 08 Oktober 2025  
**Versi**: 1.0
