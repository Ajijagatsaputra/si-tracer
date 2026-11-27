@extends('layouts.admin')

@section('content')
    @php
        $normalizeVal = function ($val) {
            $map = [
                '5' => 'sangat_baik',
                '4' => 'baik',
                '3' => 'cukup',
                '2' => 'kurang_baik',
                '1' => 'tidak_baik',
            ];
            return $map[(string) $val] ?? $val;
        };

        $opsiKompetensi = [
            'sangat_baik' => 'Sangat Baik (5)',
            'baik' => 'Baik (4)',
            'cukup' => 'Cukup (3)',
            'kurang_baik' => 'Kurang Baik (2)',
            'tidak_baik' => 'Tidak Baik (1)',
        ];

        $indikatorFields = [
            'integritas' => 'Integritas (Etika)',
            'keahlian' => 'Keahlian Bidang Ilmu',
            'kemampuan' => 'Kemampuan Bahasa Asing',
            'penguasaan' => 'Penguasaan Teknologi Informasi',
            'komunikasi' => 'Kemampuan Komunikasi',
            'kerja_tim' => 'Kerjasama Tim',
            'pengembangan' => 'Pengembangan Diri',
        ];
    @endphp

    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <a href="{{ route('listtracerpengguna.index') }}">Salinan Pengguna</a>
            <span class="sep">&rsaquo;</span>
            <span class="active">Edit Data Pengguna</span>
        </div>

        <!-- Outer Main Card -->
        <div class="akila-list-card">
            <div class="pb-3 mb-4 akila-card-header border-bottom">
                <div>
                    <h1 class="akila-title">
                        <i class="far fa-edit text-primary me-2"></i>Edit Data Tracer Pengguna Alumni
                    </h1>
                    <p class="akila-subtitle">
                        Perbarui informasi kuesioner pengguna lulusan: <strong class="text-dark">{{ $data->nama ?: ($data->nama_alumni ?: '-') }}</strong>
                    </p>
                </div>
                <div class="akila-header-actions">
                    <a href="{{ route('listtracerpengguna.index') }}" class="btn-akila-outline">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Pengguna
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 akila-alert-banner" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    <div class="akila-alert-body">
                        <div class="akila-alert-icon" style="background: #fee2e2; color: #dc2626;"><i class="fa fa-exclamation-circle"></i></div>
                        <div class="akila-alert-content">
                            <div class="akila-alert-title" style="color: #7f1d1d;">Mohon Periksa Kembali Input Anda</div>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('listtracerpengguna.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- SECTION 1: Informasi Personal -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">1</span>
                            <h2 class="akila-section-title">Informasi Personal & Jabatan</h2>
                        </div>
                        <span class="akila-section-hint">Identitas dasar yang dievaluasi</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="akila-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi" class="form-select" required>
                                <option value="teknik_informatika" {{ old('prodi', $data->prodi ?? '') == 'teknik_informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="sistem_informasi" {{ old('prodi', $data->prodi ?? '') == 'sistem_informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="manajemen" {{ old('prodi', $data->prodi ?? '') == 'manajemen' ? 'selected' : '' }}>Manajemen</option>
                                <option value="akuntansi" {{ old('prodi', $data->prodi ?? '') == 'akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $data->jabatan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $data->alamat) }}" required>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Informasi Perusahaan & Atasan -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">2</span>
                            <h2 class="akila-section-title">Informasi Perusahaan & Atasan</h2>
                        </div>
                        <span class="akila-section-hint">Data perusahaan tempat bekerja</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="akila-label">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $data->nama_perusahaan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Alamat Perusahaan</label>
                            <input type="text" name="alamat_perusahaan" class="form-control" value="{{ old('alamat_perusahaan', $data->alamat_perusahaan) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="akila-label">Nama Atasan</label>
                            <input type="text" name="nama_atasan" class="form-control" value="{{ old('nama_atasan', $data->nama_atasan) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="akila-label">NIP / ID Atasan</label>
                            <input type="text" name="nip_atasan" class="form-control" value="{{ old('nip_atasan', $data->nip_atasan) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="akila-label">Posisi / Jabatan Atasan</label>
                            <input type="text" name="posisi_jabatan_atasan" class="form-control" value="{{ old('posisi_jabatan_atasan', $data->posisi_jabatan_atasan) }}">
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Penilaian Kompetensi Lulusan -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">3</span>
                            <h2 class="akila-section-title">Survei Kompetensi Lulusan (7 Indikator)</h2>
                        </div>
                        <span class="akila-section-hint">Penilaian kinerja lulusan oleh industri</span>
                    </div>

                    <div class="row g-3">
                        @foreach ($indikatorFields as $field => $label)
                            @php $selectedVal = $normalizeVal(old($field, $data->{$field})); @endphp
                            <div class="col-md-6 col-lg-4">
                                <label class="akila-label">{{ $label }} <span class="text-danger">*</span></label>
                                <select name="{{ $field }}" class="form-select" required>
                                    @foreach ($opsiKompetensi as $key => $optLabel)
                                        <option value="{{ $key }}" {{ $selectedVal === $key ? 'selected' : '' }}>{{ $optLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- SECTION 4: Saran & Komentar -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">4</span>
                            <h2 class="akila-section-title">Saran & Masukan Pengembangan</h2>
                        </div>
                        <span class="akila-section-hint">Masukan konstruktif untuk kurikulum prodi</span>
                    </div>

                    <div>
                        <label class="akila-label">Saran & Komentar</label>
                        <textarea name="saran" class="form-control" rows="3" placeholder="Tuliskan saran atau masukan dari pengguna lulusan...">{{ old('saran', $data->saran) }}</textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="akila-form-footer">
                    <a href="{{ route('listtracerpengguna.show', $data->id) }}" class="btn-akila-outline">
                        Batal
                    </a>
                    <button type="submit" class="btn-akila-dark">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
