# SI-Tracer UHN (Tracer Study & Bursa Kerja TI UHN)

Sistem Informasi Penelusuran Alumni dan Evaluasi Kurikulum Terpadu (Tracer Study) Program Studi Teknik Informatika - Universitas Harkat Negeri (UHN). Aplikasi ini dirancang untuk mendata alumni, melacak penyerapan lulusan di dunia kerja, menganalisis relevansi kurikulum menggunakan AI, serta menyediakan portal lowongan kerja (bursa karir) terpadu.

---

## 🚀 Fitur Utama

### 1. Portal Alumni

- **Kuesioner Tracer Study**: Pengisian kuesioner alumni terintegrasi untuk melacak relevansi pendidikan dengan karir.
- **Resume & CV Builder**: Pembuatan CV otomatis siap cetak berdasarkan data profil alumni.
- **Bursa Kerja & Riwayat Lamaran**: Pendaftaran lowongan kerja langsung melalui portal dengan fitur:
    - Unggah CV/Resume (PDF/DOC/DOCX, maksimal 2MB).
    - Input Nomor WhatsApp/Telepon Aktif (terintegrasi).
    - Ekspektasi Gaji (Opsional).
    - Notifikasi interaktif menggunakan **SweetAlert2**.

### 2. Panel Admin

- **Manajemen Data Master**: Pengelolaan data mahasiswa, alumni, dan mitra perusahaan.
- **Kelola Lowongan Kerja**: Pembuatan, penyuntingan, dan penghapusan lowongan dengan dukungan:
    - Unggah hingga 10 poster/gambar lowongan (dengan fitur preview).
    - Field deskripsi, kualifikasi, rentang gaji, dan kontak pendaftaran dibuat opsional (fleksibel).
- **Manajemen Lamaran Masuk**: Daftar alumni yang melamar pekerjaan lengkap dengan link langsung WhatsApp serta tombol unduh CV.
- **Analisis Kurikulum Berbasis AI**: Sistem analisis otomatis keselarasan kurikulum dengan kebutuhan industri berbasis **Google Gemini AI** dan fallback **OpenRouter**.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5, OneUI Template
- **UI/UX Enhancement**: SweetAlert2 (Notifikasi Dinamis), FontAwesome 6 (Ikon)
- **AI Integration**: Google Gemini API & OpenRouter API

---

## 📦 Prasyarat Instalasi

Pilih salah satu metode instalasi di bawah ini:

### A. Menggunakan Docker (Direkomendasikan - Praktis & Cepat)
Pastikan sistem Anda sudah terinstal:
- Docker Desktop / Docker Engine
- Docker Compose v2+

### B. Menggunakan Server Lokal (Manual)
Pastikan sistem Anda sudah terinstal:
- PHP >= 8.2 (dengan ekstensi gd, zip, pdo_mysql)
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Tesseract OCR (instal di level OS)
- Poppler Utils / pdftotext (instal di level OS)

---

## ⚙️ Langkah Instalasi

### 🐳 Metode 1: Menggunakan Docker (Rekomendasi)

1. **Clone Repository**
   ```bash
   git clone https://github.com/Ajijagatsaputra/si-tracer.git
   cd si-tracer
   ```

2. **Salin & Siapkan File Lingkungan (`.env`)**
   ```bash
   cp .env.example .env
   ```
   *(Untuk Docker, pengaturan host database `DB_HOST` dan `DB_PASSWORD` sudah dikonfigurasi otomatis di docker-compose).*

3. **Membangun & Jalankan Docker Container**
   ```bash
   docker compose up -d --build
   ```

4. **Instal Dependensi Composer di Dalam Container**
   ```bash
   docker compose exec app composer install
   ```

5. **Buat Symlink Storage**
   ```bash
   docker compose exec app php artisan storage:link
   ```

6. **Sinkronisasi Migrasi Database**
   Jika tabel belum sepenuhnya termigrasi setelah impor database dump `tracer.sql` bawaan:
   ```bash
   docker compose exec app php artisan migrate
   ```

7. **Akses Aplikasi**
   - Halaman Utama Website: **[http://localhost:8000](http://localhost:8000)**
   - Port Vite Assets: `5173` (terkompilasi otomatis melalui layanan Node)
   - Port MySQL Database: `3306`

---

### 🖥️ Metode 2: Menggunakan Server Lokal (Manual)

1. **Clone Repository**
   ```bash
   git clone https://github.com/Ajijagatsaputra/si-tracer.git
   cd si-tracer
   ```

2. **Instal Dependensi PHP & JavaScript**
   ```bash
   composer install
   npm install
   ```

3. **Salin & Konfigurasi Lingkungan (`.env`)**
   ```bash
   cp .env.example .env
   ```
   *Atur konfigurasi database, API key Gemini/OpenRouter pada file `.env`:*
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tracer_revisi
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi & Import Database**
   Import database manual menggunakan file `tracer.sql` ke database Anda, lalu jalankan migrasi tambahan:
   ```bash
   php artisan migrate
   ```

6. **Buat Symlink Storage**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Layanan Development**
   - Terminal 1 (Laravel Server):
     ```bash
     php artisan serve --port=8082
     ```
   - Terminal 2 (Vite Compiler):
     ```bash
     npm run dev
     ```

---

## 🔑 Kredensial Login Default (Development)

Untuk masuk ke dalam sistem selama masa pengembangan:

- **Akun Admin**
    - Email: `adminti@gmail.com`
    - Password: `password`

- **Akun Alumni (Contoh)**
    - Email: `ramang@gmail.com`
    - Password: `password`

---

## 📄 Lisensi

Proyek ini dikembangkan untuk kebutuhan internal Universitas Harkat Negeri. Berlisensi di bawah [MIT License](LICENSE).
