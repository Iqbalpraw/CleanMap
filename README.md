# CleanMap - Sistem Informasi Pemetaan Layanan Laundry

**CleanMap** adalah aplikasi berbasis web yang dirancang untuk memudahkan pengguna dalam menemukan layanan laundry terbaik di sekitar mereka. Aplikasi ini memfokuskan pada pemetaan lokasi laundry secara akurat dan penyajian detail informasi layanan penyedia jasa laundry.

Proyek ini dikembangkan menggunakan framework **Laravel** sebagai solusi *fullstack* untuk manajemen data spasial (koordinat) dan pengelolaan informasi outlet secara terpusat.

## 🚀 Fitur Utama

* **Pemetaan Lokasi Laundry**: Menampilkan daftar laundry lengkap dengan titik koordinat (Latitude & Longitude) untuk navigasi lokasi yang presisi.
* **Manajemen Galeri Foto**: Setiap outlet laundry memiliki galeri foto khusus untuk menampilkan fasilitas, mesin, atau daftar harga kepada calon pelanggan.
* **Dashboard Admin**: Panel kendali utama bagi administrator untuk mengelola seluruh data laundry, galeri, dan akun pengguna.
* **Manajemen Data Terpusat**: Fitur CRUD (*Create, Read, Update, Delete*) yang lengkap untuk manajemen outlet laundry dan informasi pendukungnya.
* **Visualisasi Data**: Dashboard dilengkapi dengan statistik interaktif menggunakan ApexCharts dan ECharts untuk memantau pertumbuhan data.
* **Antarmuka Responsif**: Menggunakan integrasi Simple-DataTables yang memudahkan pencarian dan pemfilteran data laundry pada berbagai ukuran layar.

## 🛠️ Teknologi yang Digunakan

* **Backend & Frontend**: [Laravel 11](https://laravel.com/) - Framework PHP modern dengan fitur keamanan dan performa tinggi.
* **Database**: MySQL / PostgreSQL (Mendukung penyimpanan data koordinat lokasi).
* **UI/UX Styling**: [Tailwind CSS](https://tailwindcss.com/) & [Bootstrap](https://getbootstrap.com/) (Vite sebagai bundler aset).
* **Visualisasi Data**: ApexCharts & ECharts untuk laporan grafis pada dashboard.
* **Role Management**: Autentikasi yang difokuskan pada peran **Admin** sebagai pengelola utama sistem.

## ⚙️ Cara Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menginstal CleanMap di lingkungan lokal Anda:

### 1. Prasyarat
Pastikan perangkat Anda sudah terinstal:
* PHP >= 8.2
* Composer
* Node.js & NPM
* Database Server (XAMPP, Laragon, atau sejenisnya)

### 2. Instalasi
1.  **Kloning Repositori**
    ```bash
    git clone [https://github.com/iqbalpraw/cleanmap.git](https://github.com/iqbalpraw/cleanmap.git)
    cd cleanmap
    ```

2.  **Instal Dependensi**
    Unduh paket-paket PHP dan JavaScript yang dibutuhkan:
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan atur koneksi database Anda:
    ```bash
    cp .env.example .env
    ```
    Generate kunci keamanan aplikasi:
    ```bash
    php artisan key:generate
    ```

4.  **Persiapkan Database**
    Jalankan migrasi tabel dan isi data awal (seeder):
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Aplikasi**
    Kompilasi aset frontend dan jalankan server:
    ```bash
    npm run dev
    # Jalankan perintah berikut di terminal baru
    php artisan serve
    ```

## 🤝 Cara Berkontribusi

Saya sangat terbuka bagi siapa saja yang ingin membantu mengembangkan proyek ini ke depannya.

1.  **Fork Repositori**.
2.  **Buat Branch Baru**: `git checkout -b fitur/nama-fitur`.
3.  **Commit Perubahan**: `git commit -m "Tambah fitur X"`.
4.  **Push ke Branch**: `git push origin fitur/nama-fitur`.
5.  **Buat Pull Request**.

### 💡 Ide Pengembangan Mendatang
* **Sistem Ulasan & Rating**: Memberikan fitur bagi user publik untuk menilai kualitas laundry.
* **Peta Interaktif (Leaflet/Google Maps)**: Integrasi API peta untuk melihat lokasi laundry secara visual di peta.
* **Multi-role User**: Penambahan peran untuk Pemilik Laundry agar bisa mengelola outlet mereka sendiri.

## 📄 Lisensi

Proyek ini dilisensikan di bawah **MIT License**.

---
*Dikembangkan dengan ❤️ oleh Iqbal Prawira.*
