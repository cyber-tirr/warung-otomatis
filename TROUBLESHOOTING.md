# Troubleshooting Guide

## Error: "Path cannot be empty" saat upload gambar produk

### Penyebab
Error ini terjadi karena masalah dengan Laravel Storage facade yang membutuhkan konfigurasi `APP_URL` yang valid.

### Solusi yang Sudah Diterapkan ✅

Masalah ini telah diperbaiki dengan menggunakan metode upload file langsung tanpa Storage facade. Controller sekarang menggunakan `move()` method yang lebih reliable.

### Jika Masih Terjadi Error

1. **Pastikan direktori storage/app/public/products ada:**

```bash
# Windows PowerShell
New-Item -ItemType Directory -Path "storage\app\public\products" -Force

# Linux/Mac
mkdir -p storage/app/public/products
```

2. **Pastikan permission folder storage benar:**

**Linux/Mac:**
```bash
chmod -R 775 storage
chown -R www-data:www-data storage
```

**Windows:**
- Klik kanan folder `storage` → Properties → Security
- Pastikan user Anda memiliki "Full Control"

3. **Clear cache:**

```bash
php artisan optimize:clear
```

4. **Pastikan storage link sudah dibuat:**

```bash
php artisan storage:link
```

### Penjelasan Teknis

Sebelumnya, aplikasi menggunakan `Storage::disk('public')->store()` yang bergantung pada konfigurasi filesystem. Sekarang menggunakan metode langsung:

```php
$file->move(storage_path('app/public/products'), $filename);
```

Ini lebih reliable karena tidak bergantung pada konfigurasi `APP_URL` di `.env`.

---

## Error: Storage link tidak ditemukan

### Solusi

Jalankan command berikut:

```bash
php artisan storage:link
```

Jika muncul error "link already exists", hapus dulu link lama:

**Windows (PowerShell):**
```powershell
Remove-Item public\storage
php artisan storage:link
```

**Linux/Mac:**
```bash
rm public/storage
php artisan storage:link
```

---

## Error: Permission denied saat upload file

### Solusi

Pastikan folder `storage` dan `bootstrap/cache` memiliki permission yang benar:

**Linux/Mac:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Windows:**
- Klik kanan folder `storage` → Properties → Security
- Pastikan user Anda memiliki "Full Control"

---

## Database connection error

### Solusi

1. Pastikan MySQL/MariaDB sudah running
2. Cek konfigurasi database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warung_kopi
DB_USERNAME=root
DB_PASSWORD=
```

3. Buat database jika belum ada:

```sql
CREATE DATABASE warung_kopi;
```

4. Test koneksi:

```bash
php artisan migrate:status
```

---

## Pusher notifications tidak bekerja

### Solusi

1. Pastikan kredensial Pusher sudah benar di `.env`
2. Pastikan `BROADCAST_DRIVER` diset ke `pusher`:

```env
BROADCAST_CONNECTION=pusher
BROADCAST_DRIVER=pusher
```

3. Clear cache:

```bash
php artisan config:clear
php artisan cache:clear
```

4. Restart queue worker jika menggunakan queue:

```bash
php artisan queue:restart
```

---

## Midtrans payment tidak bekerja

### Solusi

1. Pastikan kredensial Midtrans sudah benar di `.env`
2. Untuk testing, gunakan sandbox:

```env
MIDTRANS_IS_PRODUCTION=false
```

3. Gunakan test card dari [Midtrans Documentation](https://docs.midtrans.com/docs/testing-payment)

---

## CSS/JS tidak muncul setelah update

### Solusi

1. Clear cache browser (Ctrl+Shift+Delete)
2. Rebuild assets:

```bash
npm run build
```

Atau untuk development:

```bash
npm run dev
```

3. Clear Laravel cache:

```bash
php artisan view:clear
php artisan cache:clear
```

---

## Session expired terus-menerus

### Solusi

1. Pastikan `APP_KEY` sudah di-generate:

```bash
php artisan key:generate
```

2. Clear session:

```bash
php artisan session:clear
```

3. Jika menggunakan database session, pastikan tabel `sessions` ada:

```bash
php artisan migrate
```

---

## Butuh bantuan lebih lanjut?

Jika masalah masih berlanjut, cek:
- Laravel log: `storage/logs/laravel.log`
- Web server error log (Apache/Nginx)
- Browser console untuk JavaScript errors
