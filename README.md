# ☕ Warkop Sky Official Website & Midnight CRM Admin Dashboard

[![Laravel v11](https://img.shields.io/badge/Laravel-v11.x-E63946?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP v8.2+](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![jQuery DataTables](https://img.shields.io/badge/jQuery-DataTables-0769AD?style=for-the-badge&logo=jquery&logoColor=white)](https://datatables.net)
[![License MIT](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](https://opensource.org/licenses/MIT)

Warkop Sky adalah ekosistem aplikasi web restoran dan sistem manajemen pelanggan (CRM) terpadu. Sistem ini dirancang khusus dengan **skema estetika Midnight Glassmorphism** (warna kabin malam berpadu dengan pijar lampu Edison hangat dan kaca transparan) serta dilengkapi dengan fitur analitik tanpa kuki pelacak pihak ketiga dan notifikasi interaktif real-time.

---

## ✨ Fitur Unggulan

### 1. Halaman Publik Pengunjung (High-Conversion Visuals)
*   **Menu List**: Grid dinamis yang membagi menu fisik menjadi **15 kategori presisi** lengkap dengan badge "FAVORIT" dan animasi transisi.
*   **Asymmetric Photo Gallery**: Grid foto asymmetric (masonry) dengan vanilla JS filter secepat kilat untuk menyaring suasana, event, dan menu.
*   **Review Stories Timeline**: Alur cerita ulasan pengunjung dilengkapi pipeline pengolahan gambar otomatis (kompresi WebP via PHP GD) dan Livewire.
*   **Interactive Table Reservation**: Formulir reservasi meja interaktif dengan browser time-picker, dropdown kebutuhan (dine-in/gathering), dan **WhatsApp Click-to-Chat Redirect Generator** dengan pesan prasetel otomatis.
*   **CTA Banner High-Conversion**: Sistem tombol transisi, spanduk strip penutup halaman, serta **WhatsApp Floating CTA Pill** dengan deteksi scroll dinamis.

### 2. Midnight CRM Admin Dashboard (Real-Time Control Room)
*   **Mekanisme Real-Time AJAX Polling (DOMParser)**: Menampilkan pemberitahuan langsung, statistik KPI, dan baris data terbaru secara seketika (setiap 8 detik) tanpa perlu me-refresh halaman.
*   **Audio Chime Dinamis (HTML5 Web Audio API)**: Membunyikan chime elektronik profesional (E5 ke A5) murni lewat sintesis browser tanpa membutuhkan aset berkas `.mp3` eksternal.
*   **Glassmorphic Floating Toasts**: Popup melayang di sisi kanan atas peramban yang memudar otomatis dalam 6 detik.
*   **Pusat Pemberitahuan Terintegrasi (Tab & LocalStorage)**: Fitur penandaan bintang (Star ⭐) untuk menyimpan pesan penting, aksi hapus (Delete 🗑️) dengan animasi runtuh (*collapsing exit*), dan penunjuk waktu ganda (Relative Short-time & Absolute Localized Date-time) berbasis `localStorage`.
*   **Rate-Limiter Auth Gate**: Perlindungan keamanan login dari serangan brute-force (maksimal 5 percobaan per menit) dan middleware khusus pencegah Bf-Cache browser (*Back button cache leakage*).
*   **Kompresi CRUD Media**: Pipeline unggahan foto menu & galeri dengan konversi otomatis ke format `.webp` hemat memori dan pembersih otomatis file fisik saat data dihapus.

### 3. Server-Side Web Analytics (Telemetry Mandiri)
*   **Dashboard Telemetri**: Grafik tren kunjungan bulanan interaktif, peta panas (*heatmap*) jam-jam sibuk kedai, rasio klien (sistem operasi, browser, gawai), referer saluran traffic, dan halaman terpopuler.
*   **Failsafe Geolocation Tracker**: Mendeteksi lokasi pengunjung (Kota, Wilayah, ISP) secara instan melalui integrasi cache IP lookup 7 hari untuk mengurangi konsumsi kuota API luar.
*   **Bot & Spider Filtering**: Filter telemetri cerdas menyaring lebih dari 30 bot web (Googlebot, Claude, GPT, dll) guna menyajikan data statistik riil pengunjung.
*   **Clickstream Timelines**: Melacak alur penjelajahan halaman demi halaman secara runut waktu lengkap dengan penghitungan durasi tinggal.
*   **Tracking Reset Gateway**: Penghapusan data analitik aman dengan gerbang konfirmasi AJAX.

---

## 🛠️ Persyaratan Sistem
*   **PHP $\ge$ 8.2** (dengan ekstensi `PDO SQLite`, `GD`, `MBString`, `XML` aktif)
*   **Composer**
*   **Node.js & NPM** (hanya untuk kompilasi lokal bila diperlukan)
*   **Laragon** / **XAMPP** (disarankan Laragon di OS Windows)

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di mesin lokal Anda:

1.  **Kloning Repositori**
    ```bash
    git clone https://github.com/username/warkopsky.git
    cd warkopsky
    ```

2.  **Instal Dependensi PHP (Composer)**
    ```bash
    composer install
    ```

3.  **Instal Dependensi JavaScript (NPM)**
    ```bash
    npm install
    ```

4.  **Siapkan Konfigurasi Lingkungan (`.env`)**
    Salin file contoh ke file `.env` baru:
    ```bash
    cp .env.example .env
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Siapkan Database SQLite**
    Buat file kosong SQLite di folder database:
    *   **Windows (PowerShell)**:
        ```powershell
        New-Item -Path "database" -Name "database.sqlite" -ItemType "file"
        ```
    *   **Mac/Linux (Terminal)**:
        ```bash
        touch database/database.sqlite
        ```

7.  **Jalankan Migrasi & Seeder (50+ Real Items & Admin User)**
    Jalankan perintah berikut untuk mengisi database dengan skema tabel dan menu fisik asli Warkop Sky beserta satu akun pengelola admin:
    ```bash
    php artisan migrate:fresh --seed
    ```

    > **Informasi Akun Admin Bawaan:**
    > *   **Email**: `admin@warkopsky.com`
    > *   **Password**: `password`

8.  **Jalankan Aplikasi**
    Nyalakan server lokal Laravel:
    ```bash
    php artisan serve
    ```
    Aplikasi web dapat diakses melalui peramban pada alamat: [http://127.0.0.1:8000](http://127.0.0.1:8000)
    
    Untuk masuk ke panel CRM pengelola, buka alamat: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

---

## 📂 Struktur Repositori Utama
*   `app/Http/Controllers/` — Penanganan logika visual CRUD Menu, Galeri, Reservasi, Cerita, dan Analitik.
*   `app/Http/Middleware/TrackVisitor.php` — Middleware sensor telemetri mandiri & filter bot.
*   `app/Http/Middleware/PreventBackHistory.php` — Middleware pengaman *bfcache* otentikasi login.
*   `database/seeders/DatabaseSeeder.php` — Seeder database berisi 15 kategori menu fisik terperinci.
*   `resources/views/`
    *   `layouts/admin.blade.php` — Master layout gelap dengan accordion sidebar dropdown dan inisialisasi DataTables.
    *   `admin/` — Seluruh visual antarmuka CRUD pengelola (dashboard, galeri, menu, reservasi, cerita).
    *   `public/` — Halaman ramah pengunjung dengan performa tinggi.
    *   `components/` — Komponen Blade reaktif (success booking, menu empty states).
*   `public/css/app.css` — Pusat desain sistem variabel CSS, radius, breakpoint, dan transform tabel mobile.

---

## ⚖️ Lisensi
Proyek ini bersifat open-source di bawah lisensi [MIT License](LICENSE).
