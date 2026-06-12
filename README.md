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

Pastikan server lokal Anda telah terinstal:

- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js & NPM

---

## ⚙️ Langkah Instalasi

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

    _Atur konfigurasi database, API key Gemini/OpenRouter, dan kredensial lainnya pada file `.env`:_

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tracer_revisi
    DB_USERNAME=root
    DB_PASSWORD=

    GEMINI_API_KEY=your_gemini_api_key
    OPENROUTER_API_KEY=your_openrouter_api_key
    ```

4. **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

5. **Jalankan Migrasi & Database Seeder**

    ```bash
    php artisan migrate
    php artisan db:seed --class=DumyUserSeeder
    ```

6. **Buat Symlink Storage**

    ```bash
    php artisan storage:link
    ```

7. **Jalankan Server Lokal**
    - Terminal 1 (Laravel Development Server):
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
