@extends('layout')

@section('content')
    <main class="main">
        @include('components.navbar')

        <!-- Panggil CSS di FolderPublic -->
        <link rel="stylesheet" href="{{ asset('css/kuesioner-tracer-study.css') }}">
        <link rel="stylesheet" href="{{ asset('css/form-autosave.css') }}">

        <body>
            @if ($errors->any())
                <div class="container">
                    <div class="alert alert-danger mt-3 animate-fade-in">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Terdapat beberapa kesalahan dalam pengisian form:
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="container">
                    <div class="alert alert-danger mt-3 animate-fade-in">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="container">
                    <div class="alert alert-success mt-3 animate-fade-in">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="container mt-2">
                <div class="questionnaire-container animate-fade-in">
                    <!-- Header -->
                    <div class="header-section">
                        <i class="fas fa-graduation-cap"></i>
                        <h1>Tracer Study Alumni Tahun 2025</h1>
                        <h2 style="font-size: 1.8rem; font-weight: 600; margin: 0.5rem 0;">Politeknik Harapan Bersama</h2>
                        <p>Kuesioner untuk mengetahui perkembangan karir dan evaluasi pendidikan alumni</p>
                    </div>

                    <div class="p-4">
                        <!-- Auto-Save Status Banner -->
                        {{-- <div id="autosave-banner" class="alert alert-info alert-dismissible fade show mb-4" style="display: none;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="fas fa-shield-alt me-2"></i>
                                    <strong>Auto-Save Aktif!</strong>
                                    <span id="autosave-status">Data form Anda akan tersimpan otomatis setiap 5 detik</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div> --}}

                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted fw-semibold">Progress Pengisian</small>
                                <small class="text-primary fw-bold"><span id="progressText">0%</span></small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar progress-bar-custom" role="progressbar" style="width: 0%"
                                    id="progressBar"></div>
                            </div>

                            <!-- Data Management Section -->
                            {{-- <div id="data-management-section" class="mt-3" style="display: none;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="text-success small">
                                        <i class="fas fa-check-circle me-1"></i>
                                        <span id="saved-data-info">Data tersimpan otomatis</span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-success btn-sm" onclick="restoreLastSavedData()">
                                            <i class="fas fa-undo me-1"></i>Restore
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearSavedData()">
                                            <i class="fas fa-trash me-1"></i>Clear
                                        </button>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <form id="alumniForm" action="{{ route('new-tracer.store') }}" method="POST">
                            @csrf

                            <!-- Debug Info -->
                            {{-- @if(config('app.debug'))
                                <div class="alert alert-info">
                                    <strong>Debug Mode:</strong> Form akan dikirim ke {{ route('new-tracer.store') }}
                                    <br><strong>CSRF Token:</strong> {{ csrf_token() }}
                                    <br><strong>Session ID:</strong> {{ session()->getId() }}
                                </div>
                            @endif --}}

                            <!-- Informasi Pribadi -->
                            <div class="section-card animate-fade-in">
                                <div class="section-header">
                                    <i class="fas fa-user"></i>
                                    Informasi Pribadi
                                </div>
                                <div class="section-body">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-id-card text-primary"></i>
                                                Nama Lengkap
                                            </label>
                                            <input type="text" name="nama" class="form-control"
                                                placeholder="Masukkan nama lengkap"
                                                value="{{ $alumni->nama_lengkap ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-phone text-primary"></i>
                                                Nomor HP/Whatsapp
                                            </label>
                                            <input type="text" name="no_hp" class="form-control"
                                                value="{{ $alumni->no_hp ?? '' }}" placeholder="+62812xxxxxxxx" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-envelope text-primary"></i>
                                                Alamat Email
                                            </label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $alumni->users->email ?? (auth()->user()->email ?? '')) }}"
                                                placeholder="contoh@email.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-graduation-cap text-primary"></i>
                                                Tahun Lulus
                                            </label>
                                            <input type="number" name="tahun_lulus" class="form-control"
                                                value="{{ $alumni->tahun_lulus ?? '' }}" placeholder="2023" min="2000"
                                                max="2030" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-id-card text-primary"></i>
                                                NIM
                                            </label>
                                            <input type="number" name="nim" class="form-control"
                                                value="{{ old('nim', $alumni->nim ?? (auth()->user()->nim ?? '')) }}"
                                                placeholder="20210001" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                <i class="fas fa-book text-primary"></i> Program Studi
                                            </label>
                                            <input type="text" name="prodi" value="Teknik Informatika"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                <i class="fas fa-map-marker-alt text-primary"></i>
                                                Alamat Lengkap
                                            </label>
                                            <textarea name="alamat" class="form-control" rows="3"
                                                placeholder="Desa Pengabean RT. 008/003 Kec. Margadana, Kota Tegal" required>{{ $alumni->alamat ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Pekerjaan -->
                            <div class="section-card animate-fade-in">
                                <div class="section-header">
                                    <i class="fas fa-briefcase"></i>
                                    Status Pekerjaan
                                </div>
                                <div class="section-body">
                                    <label class="form-label mb-3">
                                        <i class="fas fa-question-circle text-primary"></i>
                                        Jelaskan status anda saat ini?
                                    </label>
                                    <div class="radio-group">
                                        <div class="radio-option">
                                            <input type="radio" name="bekerja" value="bekerja_full" id="bekerja_full"
                                                class="form-check-input" required>
                                            <label for="bekerja_full" class="form-check-label">
                                                <i class="fas fa-briefcase text-success"></i>
                                                Bekerja (full time / part time)
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="bekerja" value="belum_bekerja"
                                                id="belum_bekerja" class="form-check-input" required>
                                            <label for="belum_bekerja" class="form-check-label">
                                                <i class="fas fa-clock"></i>
                                                Belum memungkinkan bekerja
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="bekerja" value="wirausaha"
                                                id="bekerja_wirausaha" class="form-check-input">
                                            <label for="bekerja_wirausaha" class="form-check-label">
                                                <i class="fas fa-store text-warning"></i>
                                                Wiraswasta
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="bekerja" value="lanjutstudy"
                                                id="bekerja_lanjutstudy" class="form-check-input">
                                            <label for="bekerja_lanjutstudy" class="form-check-label">
                                                <i class="fas fa-graduation-cap"></i>
                                                Melanjutkan Pendidikan
                                            </label>
                                        </div>
                                        <div class="radio-option">
                                            <input type="radio" name="bekerja" value="tidak" id="bekerja_tidak"
                                                class="form-check-input">
                                            <label for="bekerja_tidak" class="form-check-label">
                                                <i class="fas fa-search text-danger"></i>
                                                Tidak kerja, tetapi sedang mencari kerja
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('components.form-alumni.bagian2-3-4')
                            @include('components.form-alumni.bagian3-8')
                            @include('components.form-alumni.bagian5')


                            <!-- Kesesuaian berkerja bagian 8 -->
                            @include('components.form-alumni.bagian8')

                            <!-- Kompetensi Point Alumni bagian 9-->
                            @include('components.form-alumni.bagian9')

                            <!-- Cara Mendapatkan Pekerjaan bagian 10-11-12-->
                            @include('components.form-alumni.bagian10-11-12')
                    </div>

                    <!-- Detail LanjutStudy bagian 7-->
                    {{-- @include('components.form-alumni.bagian7') --}}


                    {{-- <!-- Kompetensi Point Alumni bagian 9-->
                    @include('components.form-alumni.bagian9') --}}

                    <!-- Bagaimana anda mencari pekerjaan bagian 13-->
                    @include('components.form-alumni.bagian13')

                    <!-- Bagaimana anda mencari pekerjaan bagian 14-->
                    @include('components.form-alumni.bagian14')

                    <!-- Saran dan Masukan bagian 15-->
                    {{-- @include('components.form-alumni.bagian15') --}}

                    <!-- Tombol Kirim -->
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>
                            Kirim Kuesioner
                        </button>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>
                                Data Anda akan dijaga kerahasiaannya dan digunakan untuk pengembangan kampus
                            </small>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            </div>

            <!-- Floating Action Button untuk kembali ke atas -->
            <button id="backToTop" class="btn"
                style="
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            box-shadow: var(--shadow-lg);
            display: none;
            z-index: 1000;
            transition: all 0.3s ease;
        "
                onclick="scrollToTop()">
                <i class="fas fa-arrow-up"></i>
            </button>

            {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
            <script src="{{ asset('js/script-kuesioner-alumni.js') }}"></script>
            <script src="{{ asset('js/tracer-study-form.js') }}"></script>
            <script src="{{ asset('js/form-autosave.js') }}"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const select = document.getElementById('mendapatkanPekerjaan');
                    const detailKurang6 = document.getElementById('detailKurang6Bulan');
                    const detailLebih6 = document.getElementById('detailLebih6Bulan');

                    function toggleDetail() {
                        const selectedValue = select.value;

                        // Reset
                        detailKurang6.style.display = 'none';
                        detailLebih6.style.display = 'none';

                        // Tampilkan bagian sesuai pilihan
                        if (selectedValue === '<=6bulan') {
                            detailKurang6.style.display = 'flex';
                        } else if (selectedValue === '>6bulan') {
                            detailLebih6.style.display = 'flex';
                        }
                    }

                    select.addEventListener('change', toggleDetail);

                    // Cek jika ada nilai sebelumnya (untuk edit form)
                    toggleDetail();

                    // Validasi kontak pekerjaan (WA atau Email harus diisi salah satu)
                    const waPekerjaan = document.getElementById('wa_pekerjaan');
                    const emailPekerjaan = document.getElementById('email_pekerjaan');
                    const form = document.getElementById('alumniForm');

                    form.addEventListener('submit', function(e) {
                        const waValue = waPekerjaan.value.trim();
                        const emailValue = emailPekerjaan.value.trim();

                        // Reset error styling
                        waPekerjaan.classList.remove('is-invalid');
                        emailPekerjaan.classList.remove('is-invalid');

                        // Hapus pesan error yang ada
                        const existingError = document.querySelector('.kontak-error');
                        if (existingError) {
                            existingError.remove();
                        }

                        // Validasi: minimal salah satu harus diisi
                        if (!waValue && !emailValue) {
                            e.preventDefault();

                            // Tambahkan styling error
                            waPekerjaan.classList.add('is-invalid');
                            emailPekerjaan.classList.add('is-invalid');

                            // Tambahkan pesan error
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'alert alert-danger mt-2 kontak-error';
                            errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Minimal salah satu kontak (WhatsApp atau Email) harus diisi untuk keperluan komunikasi langsung.';

                            emailPekerjaan.parentNode.appendChild(errorDiv);

                            // Scroll ke bagian kontak
                            emailPekerjaan.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
                });
            </script>

            <script>
                // Data Management Functions
                function restoreLastSavedData() {
                    if (window.formAutoSave) {
                        window.formAutoSave.restoreFormData();

                        // Show success notification
                        showNotification('Data berhasil dipulihkan!', 'success');

                        // Update progress bar
                        updateProgressBar();
                    }
                }

                function clearSavedData() {
                    if (confirm('Yakin ingin menghapus semua data tersimpan? Data yang sudah diisi di form tidak akan terpengaruh.')) {
                        if (window.formAutoSave) {
                            window.formAutoSave.clearSavedData();

                            // Hide data management section
                            document.getElementById('data-management-section').style.display = 'none';

                            showNotification('Data tersimpan berhasil dihapus!', 'info');
                        }
                    }
                }

                function showNotification(message, type = 'info') {
                    const notification = document.createElement('div');
                    notification.className = `alert alert-${type} alert-dismissible fade show mt-3`;
                    notification.innerHTML = `
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;

                    // Insert setelah alert errors
                    const firstAlert = document.querySelector('.alert');
                    if (firstAlert) {
                        firstAlert.parentNode.insertBefore(notification, firstAlert.nextSibling);
                    }

                    // Auto-hide setelah 5 detik
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.remove();
                        }
                    }, 5000);
                }

                function updateProgressBar() {
                    // Trigger progress bar update
                    const progressEvent = new Event('change', { bubbles: true });
                    document.dispatchEvent(progressEvent);
                }

                // Check for saved data on page load
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(() => {
                        const savedData = localStorage.getItem('alumni_tracer_form');
                        if (savedData) {
                            try {
                                const data = JSON.parse(savedData);
                                if (data._lastSaved) {
                                    const lastSaved = new Date(data._lastSaved);
                                    const timeAgo = getTimeAgo(lastSaved);

                                    document.getElementById('saved-data-info').textContent =
                                        `Data tersimpan ${timeAgo}`;
                                    document.getElementById('data-management-section').style.display = 'block';

                                    // Show auto-save banner with saved data info
                                    showAutoSaveBanner(`Data tersimpan ${timeAgo}. Auto-save aktif untuk mencegah kehilangan data.`);
                                }
                            } catch (error) {
                                console.error('Error parsing saved data:', error);
                            }
                        } else {
                            // Show auto-save banner for new users
                            showAutoSaveBanner('Auto-save aktif untuk mencegah kehilangan data saat pengisian form.');
                        }
                    }, 1000);
                });

                function showAutoSaveBanner(message) {
                    const banner = document.getElementById('autosave-banner');
                    const status = document.getElementById('autosave-status');

                    if (banner && status) {
                        status.textContent = message;
                        banner.style.display = 'block';

                        // Auto-hide after 15 seconds
                        setTimeout(() => {
                            if (banner.parentNode) {
                                banner.style.display = 'none';
                            }
                        }, 15000);
                    }
                }

                function getTimeAgo(date) {
                    const now = new Date();
                    const diffMs = now - date;
                    const diffSecs = Math.floor(diffMs / 1000);
                    const diffMins = Math.floor(diffMs / 60000);
                    const diffHours = Math.floor(diffMs / 3600000);
                    const diffDays = Math.floor(diffMs / 86400000);

                    if (diffSecs < 60) return 'baru saja';
                    if (diffMins < 60) return `${diffMins} menit yang lalu`;
                    if (diffHours < 24) return `${diffHours} jam yang lalu`;
                    if (diffDays < 7) return `${diffDays} hari yang lalu`;
                    return 'lebih dari seminggu yang lalu';
                }
            </script>

        </body>
    </main>
@endsection
