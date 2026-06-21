# CMS Simulasi Pembelian Produk - CodeIgniter 4

Technical Test Full Stack Developer - Wrapstation (Bagian CodeIgniter)

Aplikasi CMS sederhana untuk mensimulasikan proses pembelian produk. Mendukung
operasi CRUD penuh untuk tiga entitas: User, Produk, dan Transaksi, tanpa fitur
login/registrasi sesuai ketentuan soal.

## Spesifikasi Sistem Pengerjaan

- OS: Windows 11 versi 23H2 (OS Build 22631.6199)
- Processor: Intel(R) Core(TM) i5-7300HQ CPU @ 2.50GHz
- RAM: 16 GB
- GPU: NVIDIA GeForce GTX 1050 / Intel(R) HD Graphics 630
- PHP: 8.5.6
- Database: MySQL (MAMP)

## Tech Stack

- CodeIgniter 4.7.3
- PHP 8.5
- MySQL
- Bootstrap 5 (CDN)

## Struktur Database

Tiga tabel dengan relasi sebagai berikut:

- **users** - `user_id` (PK), `name`
- **products** - `product_id` (PK), `product_name`, `qty_in_stock`, `price`
- **transactions** - `transaction_id` (PK), `user_id` (FK), `product_id` (FK), `payment_method`, `qty`

Satu user dapat memiliki banyak transaksi, satu produk dapat muncul di banyak
transaksi. Saat transaksi baru dibuat, `qty_in_stock` pada produk terkait akan
berkurang secara otomatis sesuai jumlah yang dibeli. Saat transaksi diedit
atau dihapus, stok akan disesuaikan/dikembalikan kembali.

Struktur tabel dibuat melalui Database Migration bawaan CodeIgniter (lihat
`app/Database/Migrations/`).

## Instalasi & Menjalankan Project

### 1. Clone repository

```bash
git clone <url-repo-ini>
cd <nama-folder>
```

### 2. Install dependencies

```bash
composer install
```

### 3. Setup environment

Copy file `env` menjadi `.env`:

```bash
cp env .env
```

Buka `.env`, sesuaikan bagian berikut dengan konfigurasi database lokal:
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = wrapstation_db
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306