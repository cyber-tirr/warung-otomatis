# Flowchart Aplikasi Warung Kopi Otomatis

## 1. Flowchart Autentikasi Pengguna

```mermaid
flowchart TD
    A[Pengguna Mengakses Aplikasi] --> B{Login?}
    B -->|Tidak| C[Lihat Menu]
    B -->|Ya| D[Form Login]
    D --> E{Validasi}
    E -->|Berhasil| F[Redirect ke Dashboard]
    E -->|Gagal| D
    F --> G{Peran Pengguna?}
    G -->|Admin| H[Akses Admin]
    G -->|Operator| I[Akses Operator]
    H --> J[Kelola Pengguna, Kategori, Produk, Pesanan, Laporan]
    I --> K[Kelola Produk, Pesanan, Laporan]
```

## 2. Flowchart Proses Pemesanan

```mermaid
flowchart TD
    A[Pengunjung] -->|Lihat Menu| B[Pilih Produk]
    B --> C{Tambah ke Keranjang?}
    C -->|Ya| D[Update Keranjang]
    C -->|Tidak| B
    D --> E{Lanjut Checkout?}
    E -->|Tidak| B
    E -->|Ya| F[Form Pemesanan]
    F --> G{Metode Pembayaran}
    G -->|Tunai| H[Konfirmasi Pembayaran]
    G -->|Non-Tunai| I[Proses Pembayaran Online]
    H --> J[Cetak Struk]
    I -->|Berhasil| J
    I -->|Gagal| K[Notifikasi Gagal]
    K --> F
    J --> L[Selesai]
```

## 3. Flowchart Manajemen Produk

```mermaid
flowchart TD
    A[Admin/Operator] -->|Login| B[Dashboard]
    B --> C[Kelola Produk]
    C --> D{Tindakan?}
    D -->|Tambah| E[Form Tambah Produk]
    D -->|Edit| F[Form Edit Produk]
    D -->|Hapus| G[Konfirmasi Hapus]
    E --> H[Simpan Data]
    F --> H
    G -->|Ya| I[Hapus Produk]
    G -->|Tidak| C
    H --> C
    I --> C
```

## 4. Flowchart Laporan

```mermaid
flowchart TD
    A[Admin/Operator] -->|Login| B[Dashboard]
    B --> C[Laporan]
    C --> D{Filter}
    D -->|Harian/Mingguan/Bulanan| E[Generate Laporan]
    E --> F{Format Ekspor?}
    F -->|Excel| G[Unduh Excel]
    F -->|PDF| H[Unduh PDF]
    G --> C
    H --> C
```

## 5. Flowchart Proses Pembayaran Tunai

```mermaid
flowchart TD
    A[Admin/Operator] -->|Login| B[Pesanan Baru]
    B --> C[Pilih Produk & Jumlah]
    C --> D[Keranjang]
    D --> E{Ada Item?}
    E -->|Tidak| C
    E -->|Ya| F[Proses Pembayaran]
    F --> G{Metode Pembayaran}
    G -->|Tunai| H[Input Jumlah Uang]
    H --> I{Validasi Uang}
    I -->|Cukup| J[Hitung Kembalian]
    I -->|Kurang| K[Minta Tambahan]
    K --> H
    J --> L[Simpan Transaksi]
    L --> M[Cetak Struk]
    M --> N[Selesai]
```

## Cara Menggunakan

1. Salin kode mermaid di atas
2. Tempelkan di file markdown yang mendukung rendering mermaid
3. Atau gunakan editor mermaid online seperti [Mermaid Live Editor](https://mermaid.live/)

## Catatan

- Pastikan ekstensi mermaid terpasang di aplikasi markdown viewer Anda
- Beberapa fitur mungkin memerlukan konfigurasi tambahan tergantung environment Anda
