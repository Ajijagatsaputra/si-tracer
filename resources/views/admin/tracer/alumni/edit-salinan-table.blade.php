@extends('layouts.admin')

@section('content')
    @php
        $normalizeComp = function ($val) {
            $numToStr = [
                '5' => 'sangat_baik',
                '4' => 'baik',
                '3' => 'cukup',
                '2' => 'kurang_baik',
                '1' => 'tidak_baik',
            ];
            return $numToStr[(string) $val] ?? $val;
        };

        $komFields = [
            'etika' => 'Etika & Moral',
            'keahlian' => 'Keahlian Bidang Ilmu',
            'komunikasi' => 'Kemampuan Komunikasi',
            'kerjasama' => 'Kerjasama Tim',
            'teknologi' => 'Pemanfaatan Teknologi Informasi',
            'bahasa_inggris' => 'Kemampuan Bahasa Inggris',
        ];

        $lvlOpts = [
            'sangat_baik' => 'Sangat Baik (5)',
            'baik' => 'Baik (4)',
            'cukup' => 'Cukup (3)',
            'kurang_baik' => 'Kurang Baik (2)',
            'tidak_baik' => 'Tidak Baik (1)',
        ];
    @endphp

    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <a href="{{ route('listtraceralumni.index') }}">Tracer Alumni</a>
            <span class="sep">&rsaquo;</span>
            <span class="active">Edit Tracer Alumni</span>
        </div>

        <!-- Outer Main Card -->
        <div class="akila-list-card">
            <div class="pb-3 mb-4 akila-card-header border-bottom">
                <div>
                    <h1 class="akila-title">
                        <i class="far fa-edit text-primary me-2"></i>Edit Data Tracer Alumni
                    </h1>
                    <p class="akila-subtitle">
                        Perbarui informasi kuesioner tracer alumni: <strong class="text-dark">{{ $data->nama }}</strong>
                    </p>
                </div>
                <div class="akila-header-actions">
                    <a href="{{ route('listtraceralumni.index') }}" class="btn-akila-outline">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Tracer
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-4 akila-alert-banner" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    <div class="akila-alert-body">
                        <div class="akila-alert-icon" style="background: #fee2e2; color: #dc2626;">
                            <i class="fa fa-exclamation-circle"></i>
                        </div>
                        <div class="akila-alert-content">
                            <div class="akila-alert-title" style="color: #7f1d1d;">Terdapat Kesalahan Input</div>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('listtraceralumni.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- SECTION 1: Informasi Pribadi -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">1</span>
                            <h2 class="akila-section-title">Informasi Identitas Alumni</h2>
                        </div>
                        <span class="akila-section-hint">Data dasar & kontak aktif alumni</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="akila-label">Nama Lengkap Alumni <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" name="nim" class="form-control" value="{{ old('nim', $data->nim) }}" required placeholder="Masukkan NIM">
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $data->email) }}" required placeholder="nama@email.com">
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $data->no_hp) }}" required placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Program Studi <span class="text-danger">*</span></label>
                            <select name="prodi" class="form-select" required>
                                <option value="teknik_informatika" {{ old('prodi', $data->prodi) == 'teknik_informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="sistem_informasi" {{ old('prodi', $data->prodi) == 'sistem_informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="akila-label">Tahun Lulus <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus', $data->tahun_lulus) }}" min="2000" max="2035" required>
                        </div>
                        <div class="col-12">
                            <label class="akila-label">Alamat Domisili <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required placeholder="Masukkan alamat lengkap domisili saat ini">{{ old('alamat', $data->alamat) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Status & Detail Aktivitas Karier -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">2</span>
                            <h2 class="akila-section-title">Status & Aktivitas Karier Saat Ini</h2>
                        </div>
                        <span class="akila-section-hint">Pilih status karier utama alumni</span>
                    </div>

                    @php
                        $statuses = [
                            ['id' => 'bekerja_full', 'label' => 'Bekerja', 'desc' => 'Full / Part Time', 'icon' => 'fa-briefcase'],
                            ['id' => 'wirausaha', 'label' => 'Wirausaha', 'desc' => 'Usaha Mandiri', 'icon' => 'fa-store'],
                            ['id' => 'lanjutstudy', 'label' => 'Studi Lanjut', 'desc' => 'Pascasarjana / Profesi', 'icon' => 'fa-graduation-cap'],
                            ['id' => 'belum_bekerja', 'label' => 'Belum Bekerja', 'desc' => 'Persiapan Karier', 'icon' => 'fa-clock'],
                            ['id' => 'tidak', 'label' => 'Mencari Kerja', 'desc' => 'Aktif Melamar', 'icon' => 'fa-search'],
                        ];
                    @endphp

                    <div class="mb-3 akila-radio-grid">
                        @foreach($statuses as $status)
                            <label class="akila-radio-option" for="st_{{ $status['id'] }}">
                                <input type="radio" name="status_pekerjaan" id="st_{{ $status['id'] }}" value="{{ $status['id'] }}"
                                    {{ old('status_pekerjaan', $data->status_pekerjaan) == $status['id'] ? 'checked' : '' }} required>
                                <span class="akila-radio-card">
                                    <span class="akila-radio-icon"><i class="fa {{ $status['icon'] }}"></i></span>
                                    <span>
                                        <span class="d-block fw-bold text-dark" style="font-size: 0.82rem;">{{ $status['label'] }}</span>
                                        <span class="d-block text-muted" style="font-size: 0.72rem;">{{ $status['desc'] }}</span>
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Sub-form: Bekerja -->
                    <div id="detailPekerjaan" class="pt-3 mt-3 border-top" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="akila-label">Nama Perusahaan / Instansi</label>
                                <input type="text" name="nama_perusahaan" class="form-control" value="{{ old('nama_perusahaan', $data->pekerjaan->nama_perusahaan ?? '') }}" placeholder="Contoh: PT Teknologi Nusantara">
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Jabatan / Posisi</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $data->pekerjaan->jabatan ?? '') }}" placeholder="Contoh: Software Engineer">
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Lokasi Kerja</label>
                                <input type="text" name="alamat_pekerjaan" class="form-control" value="{{ old('alamat_pekerjaan', $data->pekerjaan->alamat_pekerjaan ?? '') }}" placeholder="Contoh: Jakarta Selatan">
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Pendapatan Bulanan (Rp)</label>
                                <input type="number" name="pendapatan" class="form-control" value="{{ old('pendapatan', $data->pekerjaan->pendapatan ?? '') }}" placeholder="Nominal angka tanpa titik">
                            </div>
                        </div>
                    </div>

                    <!-- Sub-form: Wirausaha -->
                    <div id="detailWirausaha" class="pt-3 mt-3 border-top" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="akila-label">Nama Usaha</label>
                                <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha', $data->wirausaha->nama_usaha ?? '') }}" placeholder="Masukkan nama usaha">
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Posisi Usaha</label>
                                <select name="posisi_usaha" class="form-select">
                                    <option value="">-- Pilih Posisi --</option>
                                    <option value="pemilik" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'pemilik' ? 'selected' : '' }}>Pemilik (Founder)</option>
                                    <option value="partner" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'partner' ? 'selected' : '' }}>Partner / Co-Founder</option>
                                    <option value="karyawan" {{ old('posisi_usaha', $data->wirausaha->posisi_usaha ?? '') == 'karyawan' ? 'selected' : '' }}>Pengelola</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Tingkat Usaha</label>
                                <select name="tingkat_usaha" class="form-select">
                                    <option value="">-- Pilih Skala --</option>
                                    <option value="lokal" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'lokal' ? 'selected' : '' }}>Lokal / Wilayah</option>
                                    <option value="nasional" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="internasional" {{ old('tingkat_usaha', $data->wirausaha->tingkat_usaha ?? '') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Penghasilan Usaha (Rp)</label>
                                <input type="number" name="pendapatan_usaha" class="form-control" value="{{ old('pendapatan_usaha', $data->wirausaha->pendapatan_usaha ?? '') }}" placeholder="Nominal penghasilan bulanan">
                            </div>
                            <div class="col-12">
                                <label class="akila-label">Alamat Usaha</label>
                                <textarea name="alamat_usaha" class="form-control" rows="2" placeholder="Lokasi operasional usaha">{{ old('alamat_usaha', $data->wirausaha->alamat_usaha ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-form: Studi Lanjut -->
                    <div id="detailPendidikan" class="pt-3 mt-3 border-top" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="akila-label">Universitas / Perguruan Tinggi</label>
                                <input type="text" name="nama_universitas" class="form-control" value="{{ old('nama_universitas', $data->pendidikan->universitas ?? '') }}" placeholder="Contoh: Universitas Gadjah Mada">
                            </div>
                            <div class="col-md-6">
                                <label class="akila-label">Program Studi Lanjutan</label>
                                <input type="text" name="program_studi" class="form-control" value="{{ old('program_studi', $data->pendidikan->program_studi ?? '') }}" placeholder="Contoh: Magister Ilmu Komputer">
                            </div>
                            <div class="col-md-4">
                                <label class="akila-label">Sumber Biaya</label>
                                <select name="sumber_biaya" class="form-select">
                                    <option value="">-- Pilih Sumber Biaya --</option>
                                    <option value="biaya_sendiri" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'biaya_sendiri' ? 'selected' : '' }}>Biaya Sendiri / Keluarga</option>
                                    <option value="beasiswa_pemerintah" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_pemerintah' ? 'selected' : '' }}>Beasiswa Pemerintah</option>
                                    <option value="beasiswa_swasta" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_swasta' ? 'selected' : '' }}>Beasiswa Swasta</option>
                                    <option value="beasiswa_institusi" {{ old('sumber_biaya', $data->pendidikan->sumber_biaya ?? '') == 'beasiswa_institusi' ? 'selected' : '' }}>Beasiswa Institusi</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="akila-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', isset($data->pendidikan->tanggal_masuk) ? \Carbon\Carbon::parse($data->pendidikan->tanggal_masuk)->format('Y-m-d') : '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="akila-label">Kota / Lokasi Kampus</label>
                                <input type="text" name="lokasi_universitas" class="form-control" value="{{ old('lokasi_universitas', $data->pendidikan->lokasi_universitas ?? '') }}" placeholder="Contoh: Yogyakarta">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Kompetensi -->
                <div class="akila-form-section" id="kompetensiSection" style="display: none;">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">3</span>
                            <h2 class="akila-section-title">Evaluasi Kompetensi Alumni</h2>
                        </div>
                        <span class="akila-section-hint">Perbandingan kompetensi awal lulus dan saat ini</span>
                    </div>

                    <div class="row g-3">
                        @foreach($komFields as $f => $label)
                            @php
                                $curAwal = $normalizeComp(old($f . '_awal', $data->kompetensi->{$f . '_awal'} ?? ''));
                                $curSkrg = $normalizeComp(old($f . '_sekarang', $data->kompetensi->{$f . '_sekarang'} ?? ''));
                            @endphp
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light" style="background: #fafafa !important;">
                                    <div class="mb-2 fw-bold text-dark" style="font-size: 0.82rem;">{{ $label }}</div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <label class="akila-label text-muted" style="font-size: 0.72rem;">Saat Awal Lulus</label>
                                            <select name="{{ $f }}_awal" class="form-select">
                                                <option value="">Pilih Level</option>
                                                @foreach($lvlOpts as $v => $t)
                                                    <option value="{{ $v }}" {{ $curAwal == $v ? 'selected' : '' }}>{{ $t }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="akila-label text-muted" style="font-size: 0.72rem;">Saat Ini</label>
                                            <select name="{{ $f }}_sekarang" class="form-select">
                                                <option value="">Pilih Level</option>
                                                @foreach($lvlOpts as $v => $t)
                                                    <option value="{{ $v }}" {{ $curSkrg == $v ? 'selected' : '' }}>{{ $t }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="akila-form-footer">
                    <a href="{{ route('listtraceralumni.show', $data->id) }}" class="btn-akila-outline">
                        Batal
                    </a>
                    <button type="submit" class="btn-akila-dark">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusRadios = document.querySelectorAll('input[name="status_pekerjaan"]');

            function toggleSections() {
                const map = {
                    'bekerja_full': ['detailPekerjaan', 'kompetensiSection'],
                    'wirausaha': ['detailWirausaha', 'kompetensiSection'],
                    'lanjutstudy': ['detailPendidikan', 'kompetensiSection'],
                    'belum_bekerja': ['kompetensiSection']
                };

                ['detailPekerjaan', 'detailWirausaha', 'detailPendidikan', 'kompetensiSection'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.style.display = 'none';
                });

                const checked = document.querySelector('input[name="status_pekerjaan"]:checked');
                if (checked) {
                    const sections = map[checked.value] || ['kompetensiSection'];
                    sections.forEach(id => {
                        const el = document.getElementById(id);
                        if (el) el.style.display = 'block';
                    });
                }
            }

            statusRadios.forEach(r => r.addEventListener('change', toggleSections));
            toggleSections();
        });
    </script>
@endsection
