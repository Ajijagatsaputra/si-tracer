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
            <i class="fas fa-edit fa-3x text-primary mb-3"></i>
            <h1>Perbarui Tracer Study</h1>
            <p>Pastikan data karir Anda selalu mutakhir untuk mendukung data alumni kami</p>
        </div>

        <!-- Step Indicator -->
        <div class="step-indicator animate-fade-in">
            <div class="step-item active" data-step="1">1<span class="step-label">Identitas</span></div>
            <div class="step-item" data-step="2">2<span class="step-label">Status</span></div>
            <div class="step-item" data-step="3">3<span class="step-label">Karir</span></div>
            <div class="step-item" data-step="4">4<span class="step-label">Pencarian</span></div>
            <div class="step-item" data-step="5">5<span class="step-label">Kompetensi</span></div>
            <div class="step-item" data-step="6">6<span class="step-label">Evaluasi</span></div>
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
            <form id="alumniForm" action="{{ route('new-tracer.update', $tracer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- STEP 1: INFORMASI PRIBADI -->
                <div class="form-section active" data-step="1">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0 text-primary"><i class="fas fa-user-edit me-2"></i> Identitas Alumni</h3>
                        <p class="text-muted">Informasi data diri Anda saat ini</p>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $tracer->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $tracer->no_hp) }}" required>
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $tracer->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Lulus</label>
                            <input type="number" name="tahun_lulus" class="form-control @error('tahun_lulus') is-invalid @enderror" value="{{ old('tahun_lulus', $tracer->tahun_lulus) }}" required>
                            @error('tahun_lulus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control bg-light @error('nim') is-invalid @enderror" value="{{ old('nim', $tracer->nim) }}" readonly>
                            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Studi</label>
                            <input type="text" name="prodi" class="form-control bg-light" value="Teknik Informatika" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $tracer->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- STEP 2: STATUS PEKERJAAN -->
                <div class="form-section" data-step="2">
                    <div class="section-header mb-4">
                        <h3 class="fw-bold mb-0 text-primary"><i class="fas fa-briefcase me-2"></i> Status Aktivitas</h3>
                        <p class="text-muted">Pilih status Anda yang paling terbaru</p>
                    </div>

                    <div class="custom-radio-group">
                        @php $status = old('bekerja', $tracer->status_pekerjaan); @endphp
                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="bekerja_full" {{ $status == 'bekerja_full' ? 'checked' : '' }} required>
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-building"></i></div>
                                <div><h5 class="mb-0 fw-bold">Bekerja</h5><small class="text-muted">Karyawan Full-time / Part-time</small></div>
                            </div>
                        </label>
                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="wirausaha" {{ $status == 'wirausaha' ? 'checked' : '' }}>
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-store"></i></div>
                                <div><h5 class="mb-0 fw-bold">Wirausaha</h5><small class="text-muted">Memiliki bisnis mandiri</small></div>
                            </div>
                        </label>
                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="lanjutstudy" {{ $status == 'lanjutstudy' ? 'checked' : '' }}>
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-graduation-cap"></i></div>
                                <div><h5 class="mb-0 fw-bold">Studi Lanjut</h5><small class="text-muted">Melanjutkan pendidikan resmi</small></div>
                            </div>
                        </label>
                        <label class="custom-radio-item">
                            <input type="radio" name="bekerja" value="tidak" {{ $status == 'tidak' ? 'checked' : '' }}>
                            <div class="radio-content">
                                <div class="radio-icon"><i class="fas fa-search"></i></div>
                                <div><h5 class="mb-0 fw-bold">Mencari Kerja</h5><small class="text-muted">Sedang mencari peluang baru</small></div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- STEP 3: DETAIL SPESIFIK -->
                <div class="form-section" data-step="3">
                    <div id="working_details" style="display: none;">
                        <h4 class="mb-4 text-primary fw-bold">Detail Pekerjaan/Usaha</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Perusahaan/Usaha</label>
                                <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $tracer->pekerjaan->nama_perusahaan ?? ($tracer->wirausaha->nama_usaha ?? '')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $tracer->pekerjaan->jabatan ?? ($tracer->wirausaha->posisi_usaha ?? '')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pendapatan (Rp)</label>
                                <input type="number" name="pendapatan" class="form-control" value="{{ old('pendapatan', $tracer->pekerjaan->pendapatan ?? ($tracer->wirausaha->pendapatan_usaha ?? '')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tingkat Usaha</label>
                                <select name="tingkat_usaha_level" class="form-select">
                                    @php $lvl = old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? ($tracer->wirausaha->tingkat_usaha_level ?? '')); @endphp
                                    <option value="lokal" {{ $lvl == 'lokal' ? 'selected' : '' }}>Lokal</option>
                                    <option value="nasional" {{ $lvl == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="multinasional" {{ $lvl == 'multinasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>
                        </div>
                        </div>

                        <!-- Data Atasan Section -->
                        <h4 class="mb-4 mt-5 text-primary fw-bold">Data Atasan (User)</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Atasan</label>
                                <input type="text" name="nama_atasan" class="form-control" value="{{ old('nama_atasan', $tracer->pekerjaan->nama_atasan ?? '') }}" placeholder="Nama atasan langsung">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan Atasan</label>
                                <input type="text" name="jabatan_atasan" class="form-control" value="{{ old('jabatan_atasan', $tracer->pekerjaan->jabatan_atasan ?? '') }}" placeholder="Jabatan atasan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">WhatsApp Atasan</label>
                                <input type="text" name="wa_atasan" class="form-control" value="{{ old('wa_atasan', $tracer->pekerjaan->wa_atasan ?? '') }}" placeholder="+62812xxx">
                                <small class="text-muted">Wajib diawali +62</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Atasan</label>
                                <input type="email" name="email_atasan" class="form-control" value="{{ old('email_atasan', $tracer->pekerjaan->email_atasan ?? '') }}" placeholder="email@perusahaan.com">
                            </div>
                        </div>
                    </div>

                    <div id="study_details" style="display: none;">
                        <h4 class="mb-4 text-primary fw-bold">Detail Pendidikan</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Universitas</label>
                                <input type="text" name="universitas" class="form-control" value="{{ old('universitas', $tracer->pendidikan->universitas ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Program Studi</label>
                                <input type="text" name="program_studi" class="form-control" value="{{ old('program_studi', $tracer->pendidikan->program_studi ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div id="no_details" style="display: none;" class="text-center py-5">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h4>Data Sudah Sesuai</h4>
                        <p class="text-muted">Tidak ada detail tambahan untuk status ini.</p>
                    </div>
                </div>

                <!-- STEP 4: PENCARIAN -->
                <div class="form-section" data-step="4">
                    <h4 class="mb-4 text-primary fw-bold">Proses Mendapatkan Pekerjaan</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Kapan mulai mencari kerja?</label>
                            @php $waktu = old('waktu_cari_kerja', $tracer->pencarianKerja->waktu_cari_kerja ?? ''); @endphp
                            <select name="waktu_cari_kerja" class="form-select">
                                <option value="sebelum_lulus" {{ $waktu == 'sebelum_lulus' ? 'selected' : '' }}>Sebelum Lulus</option>
                                <option value="setelah_lulus" {{ $waktu == 'setelah_lulus' ? 'selected' : '' }}>Setelah Lulus</option>
                                <option value="tidak_mencari" {{ $waktu == 'tidak_mencari' ? 'selected' : '' }}>Tidak Mencari</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bulan tunggu bekerja</label>
                            <input type="number" name="bulan_kerja" class="form-control" value="{{ old('bulan_kerja', $tracer->pekerjaan->bulan_kerja ?? '') }}">
                        </div>
                    </div>
                </div>

                <!-- STEP 5: KOMPETENSI -->
                <div class="form-section" data-step="5">
                    <h4 class="mb-4 text-primary fw-bold">Analisis Kompetensi</h4>
                    <div class="table-responsive competency-table-wrapper">
                        <table class="table align-middle">
                            <thead>
                                <tr><th>Kompetensi</th><th>Awal Lulus</th><th>Saat Ini</th></tr>
                            </thead>
                            <tbody>
                                @php
                                    $aspeks = ['etika','keahlian','bahasa_inggris','teknologi','komunikasi','kerjasama','pengembangan'];
                                @endphp
                                @foreach($aspeks as $key)
                                <tr>
                                    <td class="fw-bold">{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    <td>
                                        <select name="{{ $key }}_awal" class="form-select">
                                            @php $val = $tracer->kompetensi->{$key.'_awal'} ?? ''; @endphp
                                            <option value="sangat_baik" {{ $val == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                                            <option value="baik" {{ $val == 'baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="cukup" {{ $val == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="{{ $key }}_sekarang" class="form-select">
                                            @php $val = $tracer->kompetensi->{$key.'_sekarang'} ?? ''; @endphp
                                            <option value="sangat_baik" {{ $val == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                                            <option value="baik" {{ $val == 'baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="cukup" {{ $val == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- STEP 6: SARAN & EVALUASI -->
                <div class="form-section" data-step="6">
                    <h4 class="mb-4 text-primary fw-bold">Prediksi & Evaluasi</h4>
                    
                    <div class="upload-area p-5 text-center border-2 border-dashed rounded-4 bg-light mb-4 position-relative">
                        <div id="ai_loading" style="z-index: 10;" class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 rounded-4 d-none flex-column align-items-center justify-content-center">
                            <button type="button" id="close_ai_loading" class="btn-close position-absolute top-0 end-0 m-3" aria-label="Close"></button>
                            <div class="spinner-border text-primary mb-3" role="status"></div>
                            <h6 class="fw-bold">AI Sedang Menganalisis Transkrip...</h6>
                            <p id="ai_status_text" class="small text-muted">Mohon tunggu sebentar</p>
                        </div>

                        <i class="fas fa-file-pdf fa-4x text-primary mb-3"></i>
                        <h5>Perbarui Transkrip Nilai (PDF/IMG)</h5>
                        <p class="small text-muted">Unggah ulang transkrip Anda untuk mendapatkan analisis AI terbaru</p>
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
                        <label class="form-label">Saran untuk Pengembangan Institusi</label>
                        <textarea name="saran" class="form-control" rows="5">{{ old('saran', $tracer->evaluasiPendidikan->saran ?? '') }}</textarea>
                    </div>
                    <div class="alert alert-primary rounded-4">
                        <i class="fas fa-info-circle me-2"></i> Klik tombol di bawah untuk memperbarui data kuesioner Anda secara permanen.
                    </div>
                </div>

                <!-- Wizard Navigation -->
                <div class="wizard-nav">
                    <button type="button" class="btn btn-wizard btn-prev"><i class="fas fa-arrow-left me-2"></i> Sebelumnya</button>
                    <button type="button" class="btn btn-wizard btn-next">Selanjutnya <i class="fas fa-arrow-right ms-2"></i></button>
                    <button type="submit" class="btn btn-wizard btn-submit" style="display:none;"><i class="fas fa-save me-2"></i> Update Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/tracer-wizard.js') }}"></script>
    <script src="{{ asset('js/gemini-integration.js') }}?v={{ time() }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusRadios = document.querySelectorAll('input[name="bekerja"]');
            const workDetail = document.getElementById('working_details');
            const studyDetail = document.getElementById('study_details');
            const noDetail = document.getElementById('no_details');

            function toggleDetails() {
                const selected = document.querySelector('input[name="bekerja"]:checked')?.value;
                const atasanFields = workDetail.querySelectorAll('input');

                workDetail.style.display = 'none';
                studyDetail.style.display = 'none';
                noDetail.style.display = 'none';

                // Reset required attributes
                atasanFields.forEach(f => f.required = false);

                if (selected === 'bekerja_full' || selected === 'wirausaha') {
                    workDetail.style.display = 'block';
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
            toggleDetails();

            // Navigation Toggle
            const btnPrev = document.querySelector('.btn-prev');
            const btnNext = document.querySelector('.btn-next');
            const btnSubmit = document.querySelector('.btn-submit');

            const wizardInstance = window.wizard;
            const originalShow = wizardInstance.showStep;

            wizardInstance.showStep = function(step) {
                originalShow.call(wizardInstance, step);
                btnPrev.style.visibility = step === 1 ? 'hidden' : 'visible';
                if (step === this.totalSteps) {
                    btnNext.style.display = 'none';
                    btnSubmit.style.display = 'inline-block';
                } else {
                    btnNext.style.display = 'inline-block';
                    btnSubmit.style.display = 'none';
                }
            };
            wizardInstance.showStep(1);
        });
    </script>
</main>
@endsection
