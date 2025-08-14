@extends('layouts.admin')

@section('content')
    <div class="bg-primary bg-gradient py-4 mb-4 text-white">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold"><i class="fa fa-edit me-2"></i>Edit Data Tracer Study Alumni</h1>
                <p class="mb-0">Perbarui data tracer study alumni dengan struktur lengkap</p>
            </div>
            <div>
                <a href="{{ route('listtraceralumni.index') }}" class="btn btn-light">
                    <i class="fa fa-arrow-left me-2"></i>Kembali ke List
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fa fa-form me-2"></i>Form Edit Tracer Study</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">Perhatian: Terdapat beberapa kesalahan dalam pengisian form:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('listtraceralumni.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Informasi Pribadi -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fa fa-user me-2"></i>Informasi Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control"
                                           value="{{ old('nama', $data->nama) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', $data->email) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control"
                                           value="{{ old('no_hp', $data->no_hp) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIM <span class="text-danger">*</span></label>
                                    <input type="text" name="nim" class="form-control"
                                           value="{{ old('nim', $data->nim) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi" class="form-select" required>
                                        <option value="teknik_informatika" {{ old('prodi', $data->prodi) == 'teknik_informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                        <option value="sistem_informasi" {{ old('prodi', $data->prodi) == 'sistem_informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tahun Lulus <span class="text-danger">*</span></label>
                                    <input type="number" name="tahun_lulus" class="form-control"
                                           value="{{ old('tahun_lulus', $data->tahun_lulus) }}"
                                           min="2000" max="2030" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $data->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pekerjaan -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fa fa-briefcase me-2"></i>Status Pekerjaan</h6>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Pilih status pekerjaan saat ini <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="status_pekerjaan"
                                               id="bekerja_full" value="bekerja_full"
                                               {{ old('status_pekerjaan', $data->status_pekerjaan) == 'bekerja_full' ? 'checked' : '' }} required>
                                        <label class="form-check-label w-100" for="bekerja_full">
                                            <div class="text-center p-3">
                                                <i class="fa fa-briefcase fa-2x text-success mb-2"></i>
                                                <div class="fw-bold">Bekerja</div>
                                                <small class="text-muted">Full time/Part time</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="status_pekerjaan"
                                               id="wirausaha" value="wirausaha"
                                               {{ old('status_pekerjaan', $data->status_pekerjaan) == 'wirausaha' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="wirausaha">
                                            <div class="text-center p-3">
                                                <i class="fa fa-store fa-2x text-info mb-2"></i>
                                                <div class="fw-bold">Wiraswasta</div>
                                                <small class="text-muted">Memiliki usaha sendiri</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="status_pekerjaan"
                                               id="lanjutstudy" value="lanjutstudy"
                                               {{ old('status_pekerjaan', $data->status_pekerjaan) == 'lanjutstudy' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="lanjutstudy">
                                            <div class="text-center p-3">
                                                <i class="fa fa-graduation-cap fa-2x text-primary mb-2"></i>
                                                <div class="fw-bold">Melanjutkan Pendidikan</div>
                                                <small class="text-muted">S2/S3/Kursus</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="status_pekerjaan"
                                               id="belum_bekerja" value="belum_bekerja"
                                               {{ old('status_pekerjaan', $data->status_pekerjaan) == 'belum_bekerja' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="belum_bekerja">
                                            <div class="text-center p-3">
                                                <i class="fa fa-clock fa-2x text-warning mb-2"></i>
                                                <div class="fw-bold">Belum Memungkinkan Bekerja</div>
                                                <small class="text-muted">Kondisi tertentu</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="status_pekerjaan"
                                               id="tidak" value="tidak"
                                               {{ old('status_pekerjaan', $data->status_pekerjaan) == 'tidak' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="tidak">
                                            <div class="text-center p-3">
                                                <i class="fa fa-search fa-2x text-secondary mb-2"></i>
                                                <div class="fw-bold">Tidak Kerja</div>
                                                <small class="text-muted">Sedang mencari kerja</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pekerjaan -->
                    <div class="card mb-4" id="detailPekerjaan" style="display: none;">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fa fa-building me-2"></i>Detail Pekerjaan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Perusahaan</label>
                                    <input type="text" name="nama_perusahaan" class="form-control"
                                           value="{{ old('nama_perusahaan', $data->pekerjaan->nama_perusahaan ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" class="form-control"
                                           value="{{ old('jabatan', $data->pekerjaan->jabatan ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat Pekerjaan</label>
                                    <input type="text" name="alamat_pekerjaan" class="form-control"
                                           value="{{ old('alamat_pekerjaan', $data->pekerjaan->alamat_pekerjaan ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pendapatan</label>
                                    <input type="text" name="pendapatan" class="form-control"
                                           value="{{ old('pendapatan', $data->pekerjaan->pendapatan ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Wirausaha -->
                    <div class="card mb-4" id="detailWirausaha" style="display: none;">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fa fa-store me-2"></i>Detail Wirausaha</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Usaha</label>
                                    <input type="text" name="nama_usaha" class="form-control"
                                           value="{{ old('nama_usaha', $data->wirausaha->nama_usaha ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Posisi Usaha</label>
                                    <select name="posisi_usaha" class="form-select">
                                        <option value="">-- Pilih Posisi --</option>
                                        <option value="pemilik" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                                        <option value="partner" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'partner' ? 'selected' : '' }}>Partner</option>
                                        <option value="karyawan" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tingkat Usaha</label>
                                    <select name="tingkat_usaha" class="form-select">
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="lokal" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                                        <option value="nasional" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="internasional" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Alamat Usaha</label>
                                    <input type="text" name="alamat_usaha" class="form-control"
                                           value="{{ old('alamat_usaha', $data->wirausaha->alamat_usaha ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Pendapatan Usaha</label>
                                    <input type="number" name="pendapatan_usaha" class="form-control"
                                           value="{{ old('pendapatan_usaha', $data->wirausaha->pendapatan_usaha ?? '') }}" placeholder="Rp">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pendidikan -->
                    <div class="card mb-4" id="detailPendidikan" style="display: none;">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fa fa-graduation-cap me-2"></i>Detail Pendidikan Lanjutan</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Universitas/Institusi</label>
                                    <input type="text" name="nama_universitas" class="form-control"
                                           value="{{ old('nama_universitas', $data->pendidikan->universitas ?? '') }}" placeholder="Contoh: Universitas Indonesia">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Program Studi</label>
                                    <input type="text" name="program_studi" class="form-control"
                                           value="{{ old('program_studi', $data->pendidikan->program_studi ?? '') }}" placeholder="Contoh: Magister Teknik Informatika">
                                </div>
                                <div class="col-md-6">
                                    <label for="sumber_biaya" class="form-label">Sumber Biaya</label>
                                    <select name="sumber_biaya" id="sumber_biaya" class="form-select">
                                        <option value="">-- Pilih Sumber Biaya --</option>
                                        <option value="biaya_sendiri" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'biaya_sendiri' ? 'selected' : '' }}>Biaya Sendiri/Keluarga</option>
                                        <option value="beasiswa_pemerintah" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_pemerintah' ? 'selected' : '' }}>Beasiswa Pemerintah</option>
                                        <option value="beasiswa_swasta" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_swasta' ? 'selected' : '' }}>Beasiswa Swasta</option>
                                        <option value="beasiswa_institusi" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_institusi' ? 'selected' : '' }}>Beasiswa Institusi</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lokasi Universitas</label>
                                    <input type="text" name="lokasi_universitas" class="form-control"
                                           value="{{ old('lokasi_universitas', $data->pendidikan->lokasi_universitas ?? '') }}" placeholder="Contoh: Jakarta">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Masuk</label>
                                    <input type="date" name="tanggal_masuk" class="form-control"
                                           value="{{ old('tanggal_masuk', isset($data->pendidikan->tanggal_masuk) ? \Carbon\Carbon::parse($data->pendidikan->tanggal_masuk)->format('Y-m-d') : '') }}" placeholder="Contoh: 2020-09-01">
                                </div>
                                {{-- <div class="col-md-6">
                                    <label class="form-label">Jenjang Pendidikan</label>
                                    <select name="jenjang_pendidikan" class="form-select">
                                        <option value="">-- Pilih Jenjang --</option>
                                        <option value="S2" {{ old('jenjang_pendidikan', $data->pendidikan->jenjang_pendidikan ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                                        <option value="S3" {{ old('jenjang_pendidikan', $data->pendidikan->jenjang_pendidikan ?? '') == 'S3' ? 'selected' : '' }}>S3</option>
                                        <option value="Profesi" {{ old('jenjang_pendidikan', $data->pendidikan->jenjang_pendidikan ?? '') == 'Profesi' ? 'selected' : '' }}>Profesi</option>
                                        <option value="Kursus" {{ old('jenjang_pendidikan', $data->pendidikan->jenjang_pendidikan ?? '') == 'Kursus' ? 'selected' : '' }}>Kursus/Pelatihan</option>
                                    </select>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Kompetensi -->
                    <div class="card mb-4" id="kompetensiSection" style="display: none;">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0"><i class="fa fa-star me-2"></i>Kompetensi (Awal vs Sekarang)</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $kompetensiOptions = [
                                    '' => '-- Pilih Level --',
                                    'sangat_baik' => 'Sangat Baik',
                                    'baik' => 'Baik',
                                    'cukup' => 'Cukup',
                                    'kurang_baik' => 'Kurang Baik',
                                    'tidak_baik' => 'Tidak Baik',
                                ];
                                $kompetensiFields = [
                                    'etika' => 'Etika',
                                    'keahlian' => 'Keahlian',
                                    'komunikasi' => 'Komunikasi',
                                    'kerjasama' => 'Kerjasama',
                                    'teknologi' => 'Teknologi',
                                    'bahasa_inggris' => 'Bahasa Inggris'
                                ];
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kompetensi</th>
                                            <th>Level Awal (Saat Lulus)</th>
                                            <th>Level Sekarang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kompetensiFields as $field => $label)
                                        <tr>
                                            <td><strong>{{ $label }}</strong></td>
                                            <td>
                                                <select name="{{ $field }}_awal" class="form-select form-select-sm">
                                                    @foreach($kompetensiOptions as $value => $text)
                                                        <option value="{{ $value }}"
                                                                {{ old($field.'_awal', $data->kompetensi->{$field.'_awal'} ?? '') == $value ? 'selected' : '' }}>
                                                            {{ $text }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="{{ $field }}_sekarang" class="form-select form-select-sm">
                                                    @foreach($kompetensiOptions as $value => $text)
                                                        <option value="{{ $value }}"
                                                                {{ old($field.'_sekarang', $data->kompetensi->{$field.'_sekarang'} ?? '') == $value ? 'selected' : '' }}>
                                                            {{ $text }}
                                                        </option>
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

                    <!-- Evaluasi Pendidikan -->
                    <div class="card mb-4" id="evaluasiSection" style="display: none;">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fa fa-chart-bar me-2"></i>Evaluasi Pendidikan</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $evaluasiOptions = [
                                    '' => '-- Pilih Rating --',
                                    'sangat_baik' => 'Sangat Baik',
                                    'baik' => 'Baik',
                                    'cukup' => 'Cukup',
                                    'kurang_baik' => 'Kurang Baik',
                                    'tidak_baik' => 'Tidak Baik',
                                ];
                                $evaluasiFields = [
                                    'perkuliahan' => 'Perkuliahan',
                                    'praktikum' => 'Praktikum',
                                    'demonstrasi' => 'Demonstrasi',
                                    'riset' => 'Riset',
                                    'magang' => 'Magang',
                                    'kerja_lapangan' => 'Kerja Lapangan',
                                    'diskusi' => 'Diskusi'
                                ];
                            @endphp

                            <div class="row g-3">
                                @foreach($evaluasiFields as $field => $label)
                                <div class="col-md-6">
                                    <label class="form-label">{{ $label }}</label>
                                    <select name="{{ $field }}" class="form-select">
                                        @foreach($evaluasiOptions as $value => $text)
                                            <option value="{{ $value }}"
                                                    {{ old($field, $data->evaluasiPendidikan->{$field} ?? '') == $value ? 'selected' : '' }}>
                                                {{ $text }}
                                            </option>
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
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary me-2" onclick="window.history.back()">
                            <i class="fa fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .card-radio {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .card-radio:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }

        .card-radio input[type="radio"]:checked + label {
            background-color: #f8f9ff;
            border-color: #007bff;
        }

        .card-radio input[type="radio"] {
            display: none;
        }

        .card-radio label {
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .card-header {
            border-bottom: none;
            border-radius: 10px 10px 0 0 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusRadios = document.querySelectorAll('input[name="status_pekerjaan"]');

            // Function to show/hide sections
            function toggleSections() {
                const detailPekerjaan = document.getElementById('detailPekerjaan');
                const detailWirausaha = document.getElementById('detailWirausaha');
                const detailPendidikan = document.getElementById('detailPendidikan');
                const kompetensiSection = document.getElementById('kompetensiSection');
                const evaluasiSection = document.getElementById('evaluasiSection');

                // Hide all sections first
                detailPekerjaan.style.display = 'none';
                detailWirausaha.style.display = 'none';
                detailPendidikan.style.display = 'none';
                kompetensiSection.style.display = 'none';
                evaluasiSection.style.display = 'none';

                // Show section based on selected status
                const checkedStatus = document.querySelector('input[name="status_pekerjaan"]:checked');
                if (checkedStatus) {
                    switch (checkedStatus.value) {
                        case 'bekerja_full':
                            detailPekerjaan.style.display = 'block';
                            kompetensiSection.style.display = 'block';
                            evaluasiSection.style.display = 'block';
                            break;
                        case 'wirausaha':
                            detailWirausaha.style.display = 'block';
                            kompetensiSection.style.display = 'block';
                            evaluasiSection.style.display = 'block';
                            break;
                        case 'lanjutstudy':
                            detailPendidikan.style.display = 'block';
                            break;
                        case 'belum_bekerja':
                        case 'tidak':
                            // Tidak ada section tambahan untuk status ini
                            break;
                    }
                }
            }

            // Add event listeners
            statusRadios.forEach(radio => {
                radio.addEventListener('change', toggleSections);
            });

            // Initial check on page load
            toggleSections();
        });
    </script>
@endsection
