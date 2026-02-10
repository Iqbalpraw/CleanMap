# Panduan Kontribusi CleanMap

Pertama-tama, terima kasih telah meluangkan waktu untuk berkontribusi! ✨

Halaman ini berisi panduan untuk membantu Anda berkontribusi pada proyek **CleanMap**. Panduan ini dibuat untuk memastikan proses pengembangan berjalan lancar dan kualitas kode tetap terjaga.

## Daftar Isi
- [Apa yang Bisa Saya Bantu?](#apa-yang-bisa-saya-bantu)
- [Memulai Kontribusi](#memulai-kontribusi)
- [Standar Penulisan Kode](#standar-penulisan-kode)
- [Proses Pull Request](#proses-pull-request)

## Apa yang Bisa Saya Bantu?

Kami menerima kontribusi dalam berbagai bentuk:
* **Perbaikan Bug**: Menemukan dan memperbaiki masalah teknis atau celah keamanan.
* **Fitur Baru**: Mengimplementasikan ide baru yang ada di *roadmap* (seperti pengembangan sistem ulasan pelanggan, integrasi peta interaktif Leaflet/Google Maps, atau penambahan role untuk user publik).
* **Dokumentasi**: Memperbaiki salah ketik, memperjelas panduan instalasi, atau menambahkan komentar pada kode.
* **UI/UX**: Meningkatkan tampilan antarmuka agar lebih modern dan ramah pengguna.

## Memulai Kontribusi

1.  **Fork** repositori ini ke akun GitHub Anda.
2.  **Clone** hasil fork tersebut ke mesin lokal Anda:
    ```bash
    git clone [https://github.com/username-anda/cleanmap.git](https://github.com/username-anda/cleanmap.git)
    ```
3.  **Instalasi Dependensi**:
    Masuk ke direktori proyek dan jalankan perintah berikut:
    ```bash
    composer install
    npm install
    ```
4.  **Buat branch baru** untuk pengerjaan Anda (gunakan prefix yang sesuai):
    ```bash
    git checkout -b fitur/nama-fitur-anda
    # atau
    git checkout -b fix/deskripsi-perbaikan
    ```
5.  **Lakukan perubahan kode**, pastikan aplikasi berjalan normal di lokal, lalu lakukan **commit**:
    ```bash
    git commit -m "Menambahkan fitur X untuk meningkatkan Y"
    ```
6.  **Push** branch Anda ke GitHub:
    ```bash
    git push origin fitur/nama-fitur-anda
    ```

## Standar Penulisan Kode

Untuk menjaga konsistensi di seluruh proyek, harap ikuti aturan berikut:

* **Standar PHP**: Ikuti standar penulisan kode [PSR-12](https://www.php-fig.org/psr/psr-12/).
* **Laravel Best Practices**: Gunakan fitur bawaan Laravel seperti Eloquent ORM, Blade Components, dan Request Validation.
* **Penamaan**: Gunakan penamaan variabel dan fungsi yang deskriptif dalam Bahasa Inggris atau Indonesia yang konsisten.
* **Komentar**: Berikan penjelasan singkat pada logika yang kompleks atau fungsi baru yang Anda tambahkan.

## Proses Pull Request

Setelah Anda mengirimkan Pull Request (PR):

1.  Jelaskan secara singkat perubahan apa saja yang Anda lakukan di bagian deskripsi PR.
2.  Sertakan tangkapan layar (screenshot) jika ada perubahan pada bagian antarmuka (UI).
3.  Pastikan tidak ada konflik (*merge conflicts*) dengan branch utama.
4.  Tim akan meninjau kode Anda dan memberikan masukan jika diperlukan sebelum digabungkan.

---
**CleanMap** dibangun untuk mempermudah pemetaan layanan laundry. Mari kita berkolaborasi untuk menciptakan aplikasi yang bermanfaat bagi masyarakat! 🚀
