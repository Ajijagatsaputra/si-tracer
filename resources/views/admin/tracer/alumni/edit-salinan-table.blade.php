@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white border-bottom">
        <div class="content content-full py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="hero-content">
                    <h1 class="h2 fw-bold text-dark mb-2">
                        <i class="fa fa-edit text-primary me-2"></i>Edit Tracer Study Alumni
                    </h1>
                    <p class="text-muted mb-0 fs-sm">
                        Perbarui data tracer study alumni sesuai dengan informasi terbaru.
                    </p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('listtraceralumni.index') }}" class="btn btn-outline-secondary px-4 rounded-pill shadow-sm">
                        <i class="fa fa-arrow-left me-2"></i>Kembali ke List
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content content-full">
        <div class="row g-4">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center mb-4">
                        <i class="fa fa-exclamation-circle fa-2x me-3 opacity-50"></i>
                        <div>
                            <h6 class="alert-heading fw-bold mb-1">Perhatian: Terjadi Kesalahan</h6>
                            <ul class="mb-0 fs-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('listtraceralumni.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Pribadi -->
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-user-circle text-primary me-2"></i>Informasi Pribadi
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="nama" class="form-control rounded-3 border-light bg-light p-3"
                                               value="{{ old('nama', $data->nama) }}" required placeholder="Masukkan nama lengkap">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control rounded-3 border-light bg-light p-3"
                                               value="{{ old('email', $data->email) }}" required placeholder="nama@email.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">No. HP <span class="text-danger">*</span></label>
                                        <input type="text" name="no_hp" class="form-control rounded-3 border-light bg-light p-3"
                                               value="{{ old('no_hp', $data->no_hp) }}" required placeholder="08xxxxxxxxxx">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">NIM <span class="text-danger">*</span></label>
                                        <input type="text" name="nim" class="form-control rounded-3 border-light bg-light p-3"
                                               value="{{ old('nim', $data->nim) }}" required placeholder="Masukkan NIM">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Program Studi <span class="text-danger">*</span></label>
                                        <select name="prodi" class="form-select rounded-3 border-light bg-light p-3" required>
                                            <option value="teknik_informatika" {{ old('prodi', $data->prodi) == 'teknik_informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                            <option value="sistem_informasi" {{ old('prodi', $data->prodi) == 'sistem_informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Tahun Lulus <span class="text-danger">*</span></label>
                                        <input type="number" name="tahun_lulus" class="form-control rounded-3 border-light bg-light p-3"
                                               value="{{ old('tahun_lulus', $data->tahun_lulus) }}"
                                               min="2000" max="2030" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating-custom">
                                        <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Alamat Domisili <span class="text-danger">*</span></label>
                                        <textarea name="alamat" class="form-control rounded-3 border-light bg-light p-3" rows="3" required placeholder="Masukkan alamat lengkap">{{ old('alamat', $data->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pekerjaan -->
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-briefcase text-primary me-2"></i>Status Pekerjaan Saat Ini
                            </h5>
                            <p class="text-muted fs-sm mb-4">Pilih satu status yang paling menggambarkan kondisi Anda saat ini:</p>
                            <div class="row g-4">
                                @php
                                    $statuses = [
                                        ['id' => 'bekerja_full', 'label' => 'Bekerja', 'desc' => 'Full/Part Time', 'icon' => 'fa-briefcase', 'color' => 'success'],
                                        ['id' => 'wirausaha', 'label' => 'Wirausaha', 'desc' => 'Usaha Sendiri', 'icon' => 'fa-store', 'color' => 'info'],
                                        ['id' => 'lanjutstudy', 'label' => 'Studi Lanjut', 'desc' => 'S2/S3/Kursus', 'icon' => 'fa-graduation-cap', 'color' => 'primary'],
                                        ['id' => 'belum_bekerja', 'label' => 'Belum Bekerja', 'desc' => 'Kondisi Tertentu', 'icon' => 'fa-clock', 'color' => 'warning'],
                                        ['id' => 'tidak', 'label' => 'Mencari Kerja', 'desc' => 'Sedang Mencari', 'icon' => 'fa-search', 'color' => 'secondary'],
                                    ];
                                @endphp
                                @foreach($statuses as $status)
                                    <div class="col-md-6 col-lg-2-4">
                                        <div class="form-check card-radio-modern h-100">
                                            <input class="form-check-input d-none" type="radio" name="status_pekerjaan"
                                                   id="{{ $status['id'] }}" value="{{ $status['id'] }}"
                                                   {{ old('status_pekerjaan', $data->status_pekerjaan) == $status['id'] ? 'checked' : '' }} required>
                                            <label class="form-check-label w-100 h-100" for="{{ $status['id'] }}">
                                                <div class="radio-content text-center p-3 rounded-4 border-2">
                                                    <div class="icon-circle bg-{{ $status['color'] }}-light text-{{ $status['color'] }} mb-3 mx-auto shadow-sm">
                                                        <i class="fa {{ $status['icon'] }} fa-lg"></i>
                                                    </div>
                                                    <div class="fw-bold text-dark mb-1">{{ $status['label'] }}</div>
                                                    <div class="text-muted fs-xs">{{ $status['desc'] }}</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pekerjaan -->
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-success mb-4" id="detailPekerjaan" style="display: none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-briefcase text-success me-2"></i>Detail Pekerjaan
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('nama_perusahaan', $data->pekerjaan->nama_perusahaan ?? '') }}" placeholder="Contoh: PT. Maju Jaya">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('jabatan', $data->pekerjaan->jabatan ?? '') }}" placeholder="Contoh: Software Engineer">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Lokasi Kerja</label>
                                    <input type="text" name="alamat_pekerjaan" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('alamat_pekerjaan', $data->pekerjaan->alamat_pekerjaan ?? '') }}" placeholder="Contoh: Jakarta Selatan">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Pendapatan Bulanan (Rp)</label>
                                    <input type="number" name="pendapatan" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('pendapatan', $data->pekerjaan->pendapatan ?? '') }}" placeholder="Masukkan nominal pendapatan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Wirausaha -->
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-info mb-4" id="detailWirausaha" style="display: none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-store text-info me-2"></i>Detail Wirausaha
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Nama Usaha</label>
                                    <input type="text" name="nama_usaha" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('nama_usaha', $data->wirausaha->nama_usaha ?? '') }}" placeholder="Masukkan nama usaha">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Posisi Usaha</label>
                                    <select name="posisi_usaha" class="form-select rounded-3 border-light bg-light p-3">
                                        <option value="">-- Pilih Posisi --</option>
                                        <option value="pemilik" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                        <option value="partner" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'partner' ? 'selected' : '' }}>Partner</option>
                                        <option value="karyawan" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Tingkat Usaha</label>
                                    <select name="tingkat_usaha" class="form-select rounded-3 border-light bg-light p-3">
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="lokal" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                        <option value="nasional" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="internasional" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Penghasilan Usaha (Rp)</label>
                                    <input type="number" name="pendapatan_usaha" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('pendapatan_usaha', $data->wirausaha->pendapatan_usaha ?? '') }}" placeholder="Masukkan nominal penghasilan">
                                </div>
                                <div class="col-12">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Alamat Usaha</label>
                                    <textarea name="alamat_usaha" class="form-control rounded-3 border-light bg-light p-3" rows="2" placeholder="Masukkan lokasi usaha">{{ old('alamat_usaha', $data->wirausaha->alamat_usaha ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pendidikan -->
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-primary mb-4" id="detailPendidikan" style="display: none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-graduation-cap text-primary me-2"></i>Detail Pendidikan Lanjutan
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Universitas / Institusi</label>
                                    <input type="text" name="nama_universitas" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('nama_universitas', $data->pendidikan->universitas ?? '') }}" placeholder="Contoh: Universitas Indonesia">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Program Studi</label>
                                    <input type="text" name="program_studi" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('program_studi', $data->pendidikan->program_studi ?? '') }}" placeholder="Contoh: Magister Teknik Informatika">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Sumber Biaya</label>
                                    <select name="sumber_biaya" class="form-select rounded-3 border-light bg-light p-3">
                                        <option value="">-- Pilih Sumber Biaya --</option>
                                        <option value="biaya_sendiri" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'biaya_sendiri' ? 'selected' : '' }}>Biaya Sendiri/Keluarga</option>
                                        <option value="beasiswa_pemerintah" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_pemerintah' ? 'selected' : '' }}>Beasiswa Pemerintah</option>
                                        <option value="beasiswa_swasta" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_swasta' ? 'selected' : '' }}>Beasiswa Swasta</option>
                                        <option value="beasiswa_institusi" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_institusi' ? 'selected' : '' }}>Beasiswa Institusi</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="form-control rounded-3 border-light bg-light p-3"
                                           value="{{ old('tanggal_masuk', isset($data->pendidikan->tanggal_masuk) ? \Carbon\Carbon::parse($data->pendidikan->tanggal_masuk)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kompetensi -->
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-warning mb-4" id="kompetensiSection" style="display: none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-chart-line text-warning me-2"></i>Penilaian Kompetensi (Awal vs Sekarang)
                            </h5>
                            <div class="alert alert-light border-0 rounded-4 p-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-info-circle text-primary me-3"></i>
                                    <div class="fs-sm text-dark">
                                        Berikan penilaian tingkat kompetensi Anda saat pertama kali lulus dibandingkan dengan saat ini.
                                    </div>
                                </div>
                            </div>
                            
                            @php
                                $komFields = [
                                    'etika' => 'Etika Dasar',
                                    'keahlian' => 'Keahlian Bidang',
                                    'komunikasi' => 'Kemampuan Komunikasi',
                                    'kerjasama' => 'Kerjasama Tim',
                                    'teknologi' => 'Pemanfaatan Teknologi',
                                    'bahasa_inggris' => 'Bahasa Inggris'
                                ];
                                $lvlOpts = [
                                    'sangat_baik' => 'Sangat Baik',
                                    'baik' => 'Baik',
                                    'cukup' => 'Cukup',
                                    'kurang_baik' => 'Kurang Baik',
                                    'tidak_baik' => 'Tidak Baik',
                                ];
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-borderless table-vcenter">
                                    <thead>
                                        <tr class="text-uppercase fs-xs fw-bold text-muted ls-wider border-bottom">
                                            <th style="min-width: 200px;">Jenis Kompetensi</th>
                                            <th class="text-center">Level Awal (Lulus)</th>
                                            <th class="text-center">Level Saat Ini</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($komFields as $f => $l)
                                        <tr>
                                            <td class="fw-bold py-3 text-dark fs-sm">{{ $l }}</td>
                                            <td>
                                                <select name="{{ $f }}_awal" class="form-select form-select-sm rounded-pill border-light bg-light-soft">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($lvlOpts as $v => $t)
                                                        <option value="{{ $v }}" {{ old($f.'_awal', $data->kompetensi->{$f.'_awal'} ?? '') == $v ? 'selected' : '' }}>{{ $t }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="{{ $f }}_sekarang" class="form-select form-select-sm rounded-pill border-light bg-light-soft">
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($lvlOpts as $v => $t)
                                                        <option value="{{ $v }}" {{ old($f.'_sekarang', $data->kompetensi->{$f.'_sekarang'} ?? '') == $v ? 'selected' : '' }}>{{ $t }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Evaluasi -->
                    <div class="card card-modern border-0 shadow-sm border-start border-4 border-info mb-4" id="evaluasiSection" style="display: none;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom">
                                <i class="fa fa-graduation-cap text-info me-2"></i>Evaluasi Proses Pembelajaran
                            </h5>
                            @php
                                $evalFields = [
                                    'perkuliahan' => 'Materi Perkuliahan',
                                    'praktikum' => 'Kualitas Praktikum',
                                    'demonstrasi' => 'Demonstrasi Matkul',
                                    'riset' => 'Kegiatan Riset',
                                    'magang' => 'Program Magang',
                                    'kerja_lapangan' => 'Kuliah Kerja Lapangan',
                                    'diskusi' => 'Interaksi Diskusi'
                                ];
                            @endphp
                            <div class="row g-4">
                                @foreach($evalFields as $f => $l)
                                <div class="col-md-6 col-lg-4">
                                    <label class="text-uppercase fs-xs fw-bold text-muted ls-wider d-block mb-2">{{ $l }}</label>
                                    <select name="{{ $f }}" class="form-select rounded-3 border-light bg-light p-3">
                                        <option value="">-- Pilih Rating --</option>
                                        @foreach($lvlOpts as $v => $t)
                                            <option value="{{ $v }}" {{ old($f, $data->evaluasiPendidikan->{$f} ?? '') == $v ? 'selected' : '' }}>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Saran -->
                    {{-- <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0"><i class="fa fa-comment me-2"></i>Saran & Masukan</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Saran untuk Kampus</label>
                                <textarea name="saran" class="form-control" rows="4"
                                          placeholder="Berikan saran dan masukan untuk pengembangan kampus...">{{ old('saran', $data->saran) }}</textarea>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Submit Button -->
                    <div class="card card-modern border-0 shadow-sm mb-4">
                        <div class="card-body p-4 text-end">
                            <button type="button" class="btn btn-outline-secondary px-5 rounded-pill me-2 shadow-sm" onclick="window.history.back()">
                                <i class="fa fa-times me-2"></i>Batal
                            </button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
                                <i class="fa fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .col-lg-2-4 {
            flex: 0 0 auto;
            width: 20%;
        }
        @media (max-width: 1200px) {
            .col-lg-2-4 { width: 33.3333%; }
        }
        @media (max-width: 768px) {
            .col-lg-2-4 { width: 50%; }
        }
        @media (max-width: 480px) {
            .col-lg-2-4 { width: 100%; }
        }

        .card-radio-modern .radio-content {
            border: 2px solid transparent;
            background: #fff;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            cursor: pointer;
        }

        .card-radio-modern .radio-content:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.08);
            border-color: #f0f0f0;
        }

        .card-radio-modern input:checked + label .radio-content {
            border-color: var(--bs-primary);
            background: var(--bs-primary-light);
            box-shadow: 0 4px 20px rgba(0,123,255,0.15);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
        }

        .bg-success-light { background-color: rgba(40, 167, 69, 0.1); }
        .bg-info-light { background-color: rgba(23, 162, 184, 0.1); }
        .bg-primary-light { background-color: rgba(0, 123, 255, 0.08); }
        .bg-warning-light { background-color: rgba(255, 193, 7, 0.1); }
        .bg-secondary-light { background-color: rgba(108, 117, 125, 0.1); }
        .bg-light-soft { background-color: #fcfcfd; }

        .form-floating-custom label {
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: var(--bs-primary);
            box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusRadios = document.querySelectorAll('input[name="status_pekerjaan"]');

            function toggleSections() {
                const sections = {
                    'bekerja_full': ['detailPekerjaan', 'kompetensiSection', 'evaluasiSection'],
                    'wirausaha': ['detailWirausaha', 'kompetensiSection', 'evaluasiSection'],
                    'lanjutstudy': ['detailPendidikan']
                };

                // Hide all dynamic sections
                document.querySelectorAll('[id^="detail"], #kompetensiSection, #evaluasiSection').forEach(el => {
                    el.style.display = 'none';
                });

                // Show relevant sections
                const checked = document.querySelector('input[name="status_pekerjaan"]:checked');
                if (checked && sections[checked.value]) {
                    sections[checked.value].forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.style.display = 'block';
                    });
                }
            }

            statusRadios.forEach(radio => radio.addEventListener('change', toggleSections));
            toggleSections(); // Initial call
        });
    </script>
@endsection
