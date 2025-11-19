# Warung Kopi Otomatis

Sistem Point of Sale (POS) untuk warung kopi dengan fitur pemesanan otomatis, pembayaran digital, dan notifikasi real-time.

## Fitur Utama

- 🛒 Sistem pemesanan produk
- 💳 Integrasi pembayaran Midtrans
- 🔔 Notifikasi real-time dengan Pusher
- 📊 Dashboard admin
- 📱 Responsive design
- 📄 Export laporan ke Excel & PDF

## Instalasi

### 1. Clone Repository & Install Dependencies

```bash
composer install
npm install
```

### 2. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

**PENTING:** Edit file `.env` dan pastikan `APP_URL` diisi dengan benar:

```env
APP_NAME="Warung Kopi Otomatis"
APP_URL=http://warung-kopi-otomatis.test
```

### 3. Setup Database

Buat database MySQL dan konfigurasi di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=warung_kopi
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

### 4. Setup Storage

```bash
php artisan storage:link
```

### 5. Konfigurasi Pusher (Optional)

Untuk notifikasi real-time, daftarkan akun di [Pusher](https://pusher.com) dan isi:

```env
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=ap1
```

### 6. Konfigurasi Midtrans (Optional)

Untuk payment gateway, daftarkan akun di [Midtrans](https://midtrans.com) dan isi:

```env
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
npm run dev
```

Akses aplikasi di: `http://localhost:8000` atau `http://warung-kopi-otomatis.test`

## Default Login

**Admin:**
- Email: admin@warungkopi.com
- Password: password

## Tech Stack

- Laravel 12.31.1
- PHP 8.3.15
- MySQL
- Bootstrap 5
- Pusher (Real-time notifications)
- Midtrans (Payment gateway)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
