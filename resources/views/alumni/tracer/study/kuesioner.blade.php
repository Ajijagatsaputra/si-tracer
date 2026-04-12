@extends('layout')

@section('content')
<main class="main">
    @include('components.navbar')

    <!-- Premium Assets -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tracer-wizard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container mt-5 pt-4">
        <div class="wizard-header animate-fade-in">
            <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
            <h1>Tracer Study Alumni</h1>
            <p>Bantu kami meningkatkan kualitas pendidikan dengan berbagi progres karir Anda</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator animate-fade-in">
            <div class="step-item active" data-step="1">
                1 <span class="step-label">Identitas</span>
            </div>
            <div class="step-item" data-step="2">
                2 <span class="step-label">Status</span>
            </div>
            <div class="step-item" data-step="3">
                3 <span class="step-label">Karir</span>
            </div>
            <div class="step-item" data-step="4">
                4 <span class="step-label">Pencarian</span>
            </div>
            <div class="step-item" data-step="5">
                5 <span class="step-label">Kompetensi</span>
            </div>
            <div class="step-item" data-step="6">
                6 <span class="step-label">Prediksi</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger rounded-4 mb-4 animate-fade-in shadow-sm border-0 border-start border-4 border-danger">
                <div class="d-flex align-items-center">
                    <div class="alert-icon-container me-3 bg-danger bg-opacity-10 p-2 rounded-3 text-danger">
                        <i class="fas fa-exclamation-circle fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-danger">Terjadi Kesalahan!</h6>
                        <ul class="mb-0 small text-danger-emphasis">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="wizard-card animate-fade-in">
            <form id="alumniForm" action="{{ route('new-tracer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- STEP 1: INFORMASI PRIBADI -->
                <div class="form-section active" data-step="1">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0"><i class="fas fa-user-circle me-2 text-primary"></i> Data Diri Anda</h3>
                        <p class="text-muted">Pastikan informasi kontak Anda valid agar kami dapat menghubungi Anda</p>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $alumni->nama_lengkap ?? '') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $alumni->nim ?? '') }}" required>
                            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $alumni->no_hp ?? '') }}" placeholder="+62..." required>
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $alumni->users->email ?? auth()->user()->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control @error('tahun_lulus') is-invalid @enderror" value="{{ old('tahun_lulus', $alumni->tahun_lulus ?? '') }}" required>
                            @error('tahun_lulus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $alumni->alamat ?? '') }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- STEP 2: STATUS PEKERJAAN -->
                <div class="form-section" data-step="2">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0"><i class="fas fa-briefcase me-2 text-primary"></i> Status Anda Saat Ini</h3>
                        <p class="text-muted">Pilih kondisi yang paling mendeskripsikan aktivitas Anda</p>
                    </div>

                    <div class="custom-radio-group">
                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="bekerja_full" required>
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-building"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Bekerja</h5>
                                    <small class="text-muted">Karyawan Full-time atau Part-time</small>
                                </div>
                            </div>
                        </label>

                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="wirausaha">
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-store"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Wirausaha</h5>
                                    <small class="text-muted">Memiliki bisnis atau usaha mandiri</small>
                                </div>
                            </div>
                        </label>

                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="lanjutstudy">
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-graduation-cap"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Studi Lanjut</h5>
                                    <small class="text-muted">Sedang menempuh pendidikan resmi</small>
                                </div>
                            </div>
                        </label>

                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="tidak">
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-search"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Mencari Kerja</h5>
                                    <small class="text-muted">Sedang proses melamar/mencari peluang</small>
                                </div>
                            </div>
                        </label>
                        
                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="belum_bekerja">
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-clock"></i></div>
                                <div>
                                    <h5 class="mb-0 fw-bold">Belum Bekerja</h5>
                                    <small class="text-muted">Belum memungkinkan untuk bekerja</small>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- STEP 3: DETAIL KARIR / USAHA -->
                <div class="form-section" data-step="3">
                    <div id="working_details" style="display: none;">
                        <div class="section-header mb-4">
                            <h3 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Detail Pekerjaan</h3>
                            <p class="text-muted">Informasi mengenai tempat Anda berkarir</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan/Usaha</label>
                                <input type="text" name="nama_perusahaan" class="form-control" placeholder="Contoh: PT. Maju Bersama">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan/Posisi</label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Senior Developer">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tingkat Tempat Kerja</label>
                                <select name="tingkat_usaha_level" class="form-select">
                                    <option value="lokal">Lokal/Wilayah</option>
                                    <option value="nasional">Nasional</option>
                                    <option value="multinasional">Multinasional/Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pendapatan Rata-rata (Rp)</label>
                                <input type="number" name="pendapatan" class="form-control" placeholder="Contoh: 5000000">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Alamat Kantor</label>
                                <textarea name="alamat_pekerjaan" class="form-control" rows="2"></textarea>
                            </div>
                        </div>

                        <!-- Data Atasan Section -->
                        <div class="section-header mb-4 mt-5">
                            <h3 class="fw-bold mb-0"><i class="fas fa-user-tie me-2 text-primary"></i> Data Atasan (User)</h3>
                            <p class="text-muted">Informasi atasan langsung Anda untuk evaluasi pengguna lulusan</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Atasan</label>
                                <input type="text" name="nama_atasan" class="form-control" placeholder="Nama atasan langsung">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Atasan</label>
                                <input type="text" name="jabatan_atasan" class="form-control" placeholder="Jabatan atasan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">WhatsApp Atasan</label>
                                <input type="text" name="wa_atasan" class="form-control" placeholder="+62812xxx">
                                <small class="text-muted">Wajib diawali +62</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Atasan</label>
                                <input type="email" name="email_atasan" class="form-control" placeholder="email@perusahaan.com">
                            </div>
                        </div>
                    </div>

                    <div id="study_details" style="display: none;">
                        <div class="section-header mb-4">
                            <h3 class="fw-bold mb-0"><i class="fas fa-university me-2 text-primary"></i> Detail Pendidikan</h3>
                            <p class="text-muted">Informasi mengenai studi yang Anda tempuh</p>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Universitas</label>
                                <input type="text" name="universitas" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Program Studi</label>
                                <input type="text" name="program_studi" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div id="no_details" style="display: none;" class="text-center py-5">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h4>Lanjutkan ke tahap berikutnya</h4>
                        <p class="text-muted">Data detail spesifik tidak diperlukan untuk status Anda.</p>
                    </div>
                </div>

                <!-- STEP 4: PENCARIAN KERJA -->
                <div class="form-section" data-step="4">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0"><i class="fas fa-search-plus me-2 text-primary"></i> Proses Pencarian Kerja</h3>
                        <p class="text-muted">Bagaimana histori Anda dalam menemukan kesempatan berkarir?</p>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Kapan Anda mulai mencari kerja?</label>
                            <select name="waktu_cari_kerja" class="form-select">
                                <option value="sebelum_lulus">Sebelum Lulus</option>
                                <option value="setelah_lulus">Setelah Lulus</option>
                                <option value="tidak_mencari">Tidak Mencari</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mendapatkan kerja dalam berapa bulan?</label>
                            <input type="number" name="bulan_kerja" class="form-control" placeholder="Jumlah bulan">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Metode yang Anda gunakan dalam mencari kerja? (Bisa pilih beberapa)</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="p-2 border rounded">
                                        <input type="checkbox" name="metode_cari_kerja[]" value="cdc"> CDC/Alumni Career Center
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2 border rounded">
                                        <input type="checkbox" name="metode_cari_kerja[]" value="iklankoran"> Iklan Koran/Media
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2 border rounded">
                                        <input type="checkbox" name="metode_cari_kerja[]" value="internet"> Internet/Portal Kerja
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 5: KOMPETENSI -->
                <div class="form-section" data-step="5">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0"><i class="fas fa-award me-2 text-primary"></i> Evaluasi Kompetensi</h3>
                        <p class="text-muted">Seberapa besar dampak pendidikan di kampus terhadap skill Anda saat ini?</p>
                    </div>

                    <div class="table-responsive competency-table-wrapper">
                        <table class="table table-hover competency-table align-middle">
                            <thead>
                                <tr>
                                    <th>Aspek Kompetensi</th>
                                    <th>Saat Lulus (Awal)</th>
                                    <th>Saat Ini (Sekarang)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $aspeks = [
                                        'etika' => 'Etika & Profesionalisme',
                                        'keahlian' => 'Keahlian Bidang Ilmu',
                                        'bahasa_inggris' => 'Kemampuan Bahasa Inggris',
                                        'teknologi' => 'Teknologi Informasi',
                                        'komunikasi' => 'Kemampuan Komunikasi',
                                        'kerjasama' => 'Bekerjasama dalam Tim',
                                        'pengembangan' => 'Pengembangan Diri'
                                    ];
                                @endphp
                                @foreach($aspeks as $key => $label)
                                <tr>
                                    <td><span class="fw-semibold">{{ $label }}</span></td>
                                    <td>
                                        <select name="{{ $key }}_awal" class="form-select form-select-sm">
                                            <option value="sangat_baik">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                            <option value="baik">⭐⭐⭐⭐ Baik</option>
                                            <option value="cukup">⭐⭐⭐ Cukup</option>
                                            <option value="kurang">⭐⭐ Kurang</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="{{ $key }}_sekarang" class="form-select form-select-sm">
                                            <option value="sangat_baik">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                            <option value="baik">⭐⭐⭐⭐ Baik</option>
                                            <option value="cukup">⭐⭐⭐ Cukup</option>
                                            <option value="kurang">⭐⭐ Kurang</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STEP 6: PREDIKSI & SUBMIT -->
                <div class="form-section" data-step="6">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0"><i class="fas fa-magic me-2 text-primary"></i> Prediksi Karir Masa Depan</h3>
                        <p class="text-muted">Unggah transkrip Anda untuk mendapatkan analisis AI mengenai kecocokan karir</p>
                    </div>

                    <div class="upload-area p-5 text-center border-2 border-dashed rounded-4 bg-light mb-4 position-relative">
                        <div id="ai_loading" style="z-index: 10;" class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 rounded-4 d-none flex-column align-items-center justify-content-center">
                            <button type="button" id="close_ai_loading" class="btn-close position-absolute top-0 end-0 m-3" aria-label="Close"></button>
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <h6 class="fw-bold">AI Sedang Menganalisis Transkrip...</h6>
                            <p id="ai_status_text" class="small text-muted">Mohon tunggu sebentar</p>
                        </div>

                        <i class="fas fa-file-pdf fa-4x text-primary mb-3"></i>
                        <h5>Unggah Transkrip Nilai (PDF/IMG)</h5>
                        <p class="small text-muted">Data ini akan dianalisis secara otomatis oleh AI kami</p>
                        <input type="file" name="transcript" id="transcript_input" class="form-control mt-3" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <!-- Prediction Results Area -->
                    <div id="prediction_results" style="display: none;" class="mb-4 animate-fade-in">
                        <div class="glass-card p-4 border-primary">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-robot fa-2x text-primary me-3"></i>
                                <h5 class="fw-bold mb-0">Rekomendasi Karir (AI Prediction)</h5>
                            </div>
                            <div id="prediction_text" class="text-muted mb-0" style="line-height: 1.6;">
                                <!-- AI Content will be injected here -->
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Saran & Masukan untuk Kampus</label>
                        <textarea name="saran" class="form-control" rows="4" placeholder="Tuliskan saran konstruktif Anda di sini..."></textarea>
                    </div>

                    <div class="alert alert-info py-3 border-0 rounded-4">
                        <div class="d-flex">
                            <i class="fas fa-user-shield fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Privasi Terjamin</h6>
                                <small>Data yang Anda berikan akan dipergunakan secara anonim untuk keperluan akreditasi dan peningkatan kualitas kampus Politeknik Harapan Bersama.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NAvigation -->
                <div class="wizard-nav">
                    <button type="button" class="btn btn-wizard btn-prev" style="visibility: hidden;">
                        <i class="fas fa-arrow-left me-2"></i> Sebelumnya
                    </button>
                    <button type="button" class="btn btn-wizard btn-next">
                        Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-wizard btn-submit" style="display: none;">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Form Alumni
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Wizard Scripts -->
    <script src="{{ asset('js/tracer-wizard.js') }}"></script>
    <script src="{{ asset('js/gemini-integration.js') }}?v={{ time() }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Conditional Display Logic
            const statusRadios = document.querySelectorAll('input[name="bekerja"]');
            const workDetail = document.getElementById('working_details');
            const studyDetail = document.getElementById('study_details');
            const noDetail = document.getElementById('no_details');

            function toggleDetails() {
                const selected = document.querySelector('input[name="bekerja"]:checked')?.value;
                const atasanFields = workDetail.querySelectorAll('input'); // includes atasan fields
                
                workDetail.style.display = 'none';
                studyDetail.style.display = 'none';
                noDetail.style.display = 'none';

                // Reset required attributes
                atasanFields.forEach(f => f.required = false);

                if (selected === 'bekerja_full' || selected === 'wirausaha') {
                    workDetail.style.display = 'block';
                    // Only require atasan info for bekerja_full (as per backend logic)
                    if (selected === 'bekerja_full') {
                        ['nama_atasan', 'jabatan_atasan', 'wa_atasan', 'email_atasan'].forEach(name => {
                            const field = workDetail.querySelector(`[name="${name}"]`);
                            if (field) field.required = true;
                        });
                    }
                } else if (selected === 'lanjutstudy') {
                    studyDetail.style.display = 'block';
                } else if (selected) {
                    noDetail.style.display = 'block';
                }
            }

            statusRadios.forEach(r => r.addEventListener('change', toggleDetails));

            // Wizard Step Override for UI Buttons
            const btnPrev = document.querySelector('.btn-prev');
            const btnNext = document.querySelector('.btn-next');
            const btnSubmit = document.querySelector('.btn-submit');

            // Hook into the TracerWizard instance created in public/js/tracer-wizard.js
            const originalShowStep = window.wizard.showStep;
            window.wizard.showStep = function(step) {
                originalShowStep.call(window.wizard, step);
                
                btnPrev.style.visibility = step === 1 ? 'hidden' : 'visible';
                
                if (step === this.totalSteps) {
                    btnNext.style.display = 'none';
                    btnSubmit.style.display = 'inline-block';
                } else {
                    btnNext.style.display = 'inline-block';
                    btnSubmit.style.display = 'none';
                }
            };
            
            // Initial call
            window.wizard.showStep(1);
        });
    </script>
</main>
@endsection
