@extends('layout')

@section('content')
    <main id="main-container" class="main">
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
                <div
                    class="alert alert-danger rounded-4 mb-4 animate-fade-in shadow-sm border-0 border-start border-4 border-danger">
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

                    <!-- STEP 1: IDENTITAS (Kemdikbud Style) -->
                    <div class="form-section active" data-step="1">
                        <div class="section-header mb-4">
                            <h3 class="fw-bold mb-0"><i class="fas fa-id-card me-2 text-primary"></i> Identitas</h3>
                            <p class="text-muted">Lengkapi data identitas Anda sebelum mengisi kuesioner</p>
                        </div>

                        <div class="row g-3">
                            <!-- NIM (readonly) -->
                            <div class="col-md-6">
                                <label class="form-label">NIM</label>
                                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                    value="{{ old('nim', $alumni->nim ?? '') }}" readonly>
                                @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>


                            <!-- Tahun Lulus -->
                            <div class="col-md-6">
                                <label class="form-label">Tahun Lulus</label>
                                <select name="tahun_lulus" class="form-select @error('tahun_lulus') is-invalid @enderror"
                                    required>
                                    <option value="" disabled {{ old('tahun_lulus', $alumni->tahun_lulus ?? '') == '' ? 'selected' : '' }}>-- Pilih Tahun Lulus --</option>
                                    @php
                                        $currentYear = date('Y');
                                        $selectedYear = old('tahun_lulus', $alumni->tahun_lulus ?? '');
                                    @endphp
                                    @for ($year = $currentYear; $year >= 2010; $year--)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                                @error('tahun_lulus')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Nama & NIK -->
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $alumni->nama_lengkap ?? '') }}" readonly>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <!-- <div class="col-md-6">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik') }}" placeholder="16 digit NIK KTP">
                                @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div> -->

                            <!-- Email & Telepon -->
                            <div class="col-md-6">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $alumni->users->email ?? auth()->user()->email) }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor Telepon/HP</label>
                                <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp', $alumni->no_hp ?? '') }}" placeholder="08xxxxxxxxxx" required>
                                @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- NPWP -->
                            <!-- <div class="col-md-6">
                                <label class="form-label">NPWP</label>
                                <input type="text" name="npwp" class="form-control @error('npwp') is-invalid @enderror"
                                    value="{{ old('npwp') }}" placeholder="Opsional">
                                @error('npwp')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div> -->

                            <!-- Alamat -->
                            <div class="col-md-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                    placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi"
                                    required>{{ old('alamat', $alumni->alamat ?? '') }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: STATUS PEKERJAAN -->
                    <div class="form-section" data-step="2">
                        <div class="section-header mb-4">
                            <h3 class="fw-bold mb-0"><i class="fas fa-briefcase me-2 text-primary"></i> Status Anda Saat Ini
                            </h3>
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
                                        <h5 class="mb-0 fw-bold">Wiraswasta</h5>
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
                                <h3 class="fw-bold mb-0"><i class="fas fa-building me-2 text-primary"></i> Detail Pekerjaan
                                </h3>
                                <p class="text-muted">Informasi mengenai tempat Anda berkarir saat ini</p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Perusahaan/Instansi</label>
                                    <input type="text" name="nama_perusahaan" class="form-control"
                                        placeholder="Nama perusahaan/instansi tempat bekerja">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan/Posisi</label>
                                    <input type="text" name="jabatan" class="form-control"
                                        placeholder="Jabatan/posisi saat ini">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tingkat Tempat Kerja</label>
                                    <select name="tingkat_usaha_level" class="form-select">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="lokal">Lokal/Wilayah (tidak berbadan hukum)</option>
                                        <option value="nasional">Nasional (berbadan hukum)</option>
                                        <option value="multinasional">Multinasional/Internasional</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pendapatan per bulan (Rp)</label>
                                    <input type="number" name="pendapatan" class="form-control"
                                        placeholder="Contoh: 5000000" min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Erat hubungan bidang studi dengan pekerjaan?</label>
                                    <select name="hubungan_studi_kerja" class="form-select">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="sangat_erat">Sangat Erat</option>
                                        <option value="erat">Erat</option>
                                        <option value="cukup_erat">Cukup Erat</option>
                                        <option value="kurang_erat">Kurang Erat</option>
                                        <option value="tidak_sama_sekali">Tidak Sama Sekali</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Perusahaan</label>
                                    <select name="jenis_perusahaan" class="form-select">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="instansi_pemerintah">Instansi pemerintah</option>
                                        <option value="bumn_bumd">BUMN/BUMD</option>
                                        <option value="swasta">Organisasi/Perusahaan swasta</option>
                                        <option value="nirlaba">Organisasi non-profit/Lembaga Swadaya Masyarakat</option>
                                        <option value="wirausaha">Wirausaha/Perusahaan sendiri</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Alamat Kantor</label>
                                    <textarea name="alamat_pekerjaan" class="form-control" rows="2"
                                        placeholder="Alamat lengkap tempat bekerja"></textarea>
                                </div>
                            </div>

                            <!-- Data Atasan Section -->
                            <div class="section-header mb-4 mt-4">
                                <h3 class="fw-bold mb-0"><i class="fas fa-user-tie me-2 text-primary"></i> Data Atasan
                                    (User)</h3>
                                <p class="text-muted">Informasi atasan langsung Anda untuk evaluasi pengguna lulusan</p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Atasan</label>
                                    <input type="text" name="nama_atasan" class="form-control"
                                        placeholder="Nama lengkap atasan langsung">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan Atasan</label>
                                    <input type="text" name="jabatan_atasan" class="form-control"
                                        placeholder="Jabatan/posisi atasan">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor HP/WhatsApp Atasan</label>
                                    <input type="text" name="wa_atasan" class="form-control" placeholder="08xxxxxxxxxx">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Atasan</label>
                                    <input type="email" name="email_atasan" class="form-control"
                                        placeholder="email@perusahaan.com">
                                </div>
                            </div>
                        </div>

                        <div id="study_details" style="display: none;">
                            <div class="section-header mb-4">
                                <h3 class="fw-bold mb-0"><i class="fas fa-university me-2 text-primary"></i> Detail Studi
                                    Lanjut</h3>
                                <p class="text-muted">Informasi mengenai pendidikan lanjut yang Anda tempuh</p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Perguruan Tinggi</label>
                                    <input type="text" name="universitas" class="form-control"
                                        placeholder="Nama universitas/perguruan tinggi">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program Studi</label>
                                    <input type="text" name="program_studi" class="form-control"
                                        placeholder="Program studi yang ditempuh">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sumber Biaya</label>
                                    <select name="sumber_biaya_studi" class="form-select">
                                        <option value="" disabled selected>-- Pilih --</option>
                                        <option value="sendiri">Biaya Sendiri</option>
                                        <option value="beasiswa">Beasiswa</option>
                                        <option value="orangtua">Orang Tua/Keluarga</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="no_details" style="display: none;" class="text-center py-5">
                            <div
                                style="width:64px;height:64px;background:var(--success-light);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                <i class="fas fa-check fa-2x" style="color:var(--success)"></i>
                            </div>
                            <h5 class="fw-bold">Tidak ada data tambahan</h5>
                            <p class="text-muted small">Silakan lanjut ke tahap berikutnya.</p>
                        </div>
                    </div>

                    <!-- STEP 4: PENCARIAN KERJA -->
                    <div class="form-section" data-step="4">
                        <div class="section-header mb-4">
                            <h3 class="fw-bold mb-0"><i class="fas fa-search-plus me-2 text-primary"></i> Proses Pencarian
                                Kerja</h3>
                            <p class="text-muted">Bagaimana histori Anda dalam menemukan kesempatan berkarir?</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kapan Anda mulai mencari kerja?</label>
                                <select name="waktu_cari_kerja" class="form-select">
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="sebelum_lulus">Kira-kira 6 bulan sebelum lulus</option>
                                    <option value="setelah_lulus">Sesudah lulus</option>
                                    <option value="tidak_mencari">Tidak mencari kerja</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Berapa bulan sampai mendapat kerja pertama?</label>
                                <input type="number" name="bulan_kerja" class="form-control" placeholder="Jumlah bulan"
                                    min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Berapa perusahaan/instansi yang sudah dilamar?</label>
                                <input type="number" name="jumlah_lamar" class="form-control"
                                    placeholder="Jumlah perusahaan" min="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Berapa perusahaan/instansi yang merespon lamaran?</label>
                                <input type="number" name="jumlah_respon" class="form-control"
                                    placeholder="Jumlah yang merespon" min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Bagaimana Anda mencari pekerjaan tersebut? (Bisa pilih
                                    beberapa)</label>
                                <div class="row g-2">
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="internet">
                                            Melalui internet/iklan online/milis
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="cdc">
                                            Menghubungi kantor kemahasiswaan/CDC
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="iklankoran">
                                            Iklan di koran/majalah
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="pergi_langsung">
                                            Pergi ke bursa/pameran kerja
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="jaringan">
                                            Membangun jaringan (networking)
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="relasi">
                                            Melalui relasi (keluarga, teman, dosen)
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="perusahaan">
                                            Menghubungi perusahaan langsung
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="direkrut">
                                            Direkrut oleh perusahaan
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-6">
                                        <label class="checkbox-card">
                                            <input type="checkbox" name="metode_cari_kerja[]" value="wirausaha">
                                            Membangun bisnis sendiri
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 5: KOMPETENSI -->
                    <div class="form-section" data-step="5">
                        <div class="section-header mb-4">
                            <h3 class="fw-bold mb-0"><i class="fas fa-chart-bar me-2 text-primary"></i> Evaluasi Kompetensi
                            </h3>
                            <p class="text-muted">Menurut Anda seberapa besar penekanan kompetensi di bawah ini diperlukan
                                dalam pekerjaan?<br>
                                <small><strong>Skala:</strong> 1 = Sangat Rendah &nbsp; 2 = Rendah &nbsp; 3 = Cukup &nbsp; 4
                                    = Tinggi &nbsp; 5 = Sangat Tinggi</small>
                            </p>
                        </div>

                        <div class="competency-table-wrapper">
                            <table class="table competency-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Aspek Kompetensi</th>
                                        <th style="width:30%">Saat Lulus</th>
                                        <th style="width:30%">Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $aspeks = [
                                            'etika' => 'Etika',
                                            'keahlian' => 'Keahlian berdasarkan bidang ilmu',
                                            'bahasa_inggris' => 'Bahasa Inggris',
                                            'teknologi' => 'Penggunaan Teknologi Informasi',
                                            'komunikasi' => 'Komunikasi',
                                            'kerjasama' => 'Kerjasama Tim',
                                            'pengembangan' => 'Pengembangan Diri'
                                        ];
                                        $skalaOptions = [
                                            '' => '-- Pilih --',
                                            '1' => '1 - Sangat Rendah',
                                            '2' => '2 - Rendah',
                                            '3' => '3 - Cukup',
                                            '4' => '4 - Tinggi',
                                            '5' => '5 - Sangat Tinggi',
                                        ];
                                    @endphp
                                    @foreach($aspeks as $key => $label)
                                        <tr>
                                            <td><span class="fw-semibold">{{ $label }}</span></td>
                                            <td>
                                                <select name="{{ $key }}_awal" class="form-select form-select-sm">
                                                    @foreach($skalaOptions as $val => $text)
                                                        <option value="{{ $val }}" {{ $val === '' ? 'disabled selected' : '' }}>
                                                            {{ $text }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="{{ $key }}_sekarang" class="form-select form-select-sm">
                                                    @foreach($skalaOptions as $val => $text)
                                                        <option value="{{ $val }}" {{ $val === '' ? 'disabled selected' : '' }}>
                                                            {{ $text }}</option>
                                                    @endforeach
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
                            <h3 class="fw-bold mb-0"><i class="fas fa-magic me-2 text-primary"></i> Prediksi Karir & Penutup
                            </h3>
                            <p class="text-muted">Unggah transkrip untuk analisis AI dan berikan masukan untuk kampus</p>
                        </div>

                        <div class="upload-area p-4 p-md-5 text-center mb-4 position-relative">
                            <div id="ai_loading" style="z-index: 10;"
                                class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 rounded-4 d-none flex-column align-items-center justify-content-center">
                                <button type="button" id="close_ai_loading"
                                    class="btn-close position-absolute top-0 end-0 m-3" aria-label="Close"></button>
                                <div class="spinner-border text-primary mb-3" role="status"></div>
                                <h6 class="fw-bold">AI Sedang Menganalisis Transkrip...</h6>
                                <p id="ai_status_text" class="small text-muted">Mohon tunggu sebentar</p>
                            </div>

                            <div
                                style="width:56px;height:56px;background:var(--primary-lighter);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                <i class="fas fa-cloud-upload-alt fa-lg" style="color:var(--primary)"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Unggah Transkrip Nilai</h5>
                            <p class="small text-muted mb-3">Format: PDF, JPG, JPEG, atau PNG &mdash; Maks. 5MB</p>
                            <input type="file" name="transcript" id="transcript_input" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" style="max-width:400px;margin:0 auto;">
                        </div>

                        <!-- Prediction Results Area -->
                        <div id="prediction_results" style="display: none;" class="mb-4 animate-fade-in">
                            <div class="glass-card p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div
                                        style="width:40px;height:40px;background:var(--primary-lighter);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;margin-right:0.75rem;">
                                        <i class="fas fa-robot" style="color:var(--primary)"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Rekomendasi Karir (AI Prediction)</h5>
                                </div>
                                <div id="prediction_text" class="text-muted mb-0" style="line-height: 1.7;">
                                    <!-- AI Content will be injected here -->
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Saran & Masukan untuk Almamater</label>
                            <textarea name="saran" class="form-control" rows="4"
                                placeholder="Tuliskan saran konstruktif Anda untuk peningkatan kualitas pendidikan..."></textarea>
                        </div>

                        <div class="alert alert-info py-3 rounded-3">
                            <div class="d-flex align-items-start">
                                <div
                                    style="width:36px;height:36px;background:rgba(13,71,161,0.1);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;margin-right:0.75rem;flex-shrink:0;">
                                    <i class="fas fa-shield-alt" style="color:var(--accent)"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-size:0.85rem">Kerahasiaan Data Terjamin</h6>
                                    <small>Data yang Anda berikan bersifat rahasia dan hanya digunakan untuk keperluan
                                        akreditasi
                                        serta peningkatan mutu pendidikan.</small>
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
            document.addEventListener('DOMContentLoaded', function () {
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
                window.wizard.showStep = function (step) {
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