@extends('layouts.admin')

@section('content')
    @php
        $indikatorFields = [
            'integritas' => 'Integritas (Etika)',
            'keahlian' => 'Keahlian Bidang Ilmu',
            'kemampuan' => 'Kemampuan Bahasa Asing',
            'penguasaan' => 'Penguasaan Teknologi Informasi',
            'komunikasi' => 'Kemampuan Komunikasi',
            'kerja_tim' => 'Kerjasama Tim',
            'pengembangan' => 'Pengembangan Diri',
        ];

        $skorOptions = [
            '5' => '5 — Sangat Baik',
            '4' => '4 — Baik',
            '3' => '3 — Cukup',
            '2' => '2 — Kurang',
            '1' => '1 — Sangat Kurang',
        ];
    @endphp

    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <a href="{{ route('admin.supervisor-questionnaire.index') }}">Survei Pengguna</a>
            <span class="sep">&rsaquo;</span>
            <span class="active">Edit Survei Pengguna</span>
        </div>

        <!-- Outer Main Card -->
        <div class="akila-list-card">
            <div class="pb-3 mb-4 akila-card-header border-bottom">
                <div>
                    <h1 class="akila-title">
                        <i class="far fa-edit text-primary me-2"></i>Edit Survei Pengguna (Atasan)
                    </h1>
                    <p class="akila-subtitle">
                        Perbarui informasi & penilaian kuesioner evaluasi untuk alumni: <strong class="text-dark">{{ $questionnaire->nama_alumni }}</strong>
                    </p>
                </div>
                <div class="akila-header-actions">
                    <a href="{{ route('admin.supervisor-questionnaire.show', $questionnaire->id) }}" class="btn-akila-outline">
                        <i class="fa fa-arrow-left"></i> Kembali ke Detail Survei
                    </a>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-4 akila-alert-banner" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    <div class="akila-alert-body">
                        <div class="akila-alert-icon" style="background: #fee2e2; color: #dc2626;"><i class="fa fa-exclamation-circle"></i></div>
                        <div class="akila-alert-content">
                            <div class="akila-alert-title" style="color: #7f1d1d;">Gagal Menyimpan</div>
                            <p class="akila-alert-desc" style="color: #991b1b;">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 akila-alert-banner" style="background: #fef2f2; border-color: #fecaca; color: #991b1b;">
                    <div class="akila-alert-body">
                        <div class="akila-alert-icon" style="background: #fee2e2; color: #dc2626;"><i class="fa fa-exclamation-circle"></i></div>
                        <div class="akila-alert-content">
                            <div class="akila-alert-title" style="color: #7f1d1d;">Mohon Periksa Input Anda</div>
                            <ul class="mb-0 ps-3 small">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.supervisor-questionnaire.update', $questionnaire->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- SECTION 1: Informasi Alumni & Perusahaan -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">1</span>
                            <h2 class="akila-section-title">Informasi Alumni & Tempat Kerja</h2>
                        </div>
                        <span class="akila-section-hint">Data penempatan kerja alumni</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_alumni" class="akila-label">Nama Alumni <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_alumni') is-invalid @enderror"
                                id="nama_alumni" name="nama_alumni"
                                value="{{ old('nama_alumni', $questionnaire->nama_alumni) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jabatan_alumni" class="akila-label">Jabatan / Posisi Alumni <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan_alumni') is-invalid @enderror"
                                id="jabatan_alumni" name="jabatan_alumni"
                                value="{{ old('jabatan_alumni', $questionnaire->jabatan_alumni) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_perusahaan" class="akila-label">Nama Perusahaan / Instansi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                id="nama_perusahaan" name="nama_perusahaan"
                                value="{{ old('nama_perusahaan', $questionnaire->nama_perusahaan) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_mulai_kerja" class="akila-label">Tanggal Mulai Bekerja</label>
                            <input type="date" class="form-control @error('tanggal_mulai_kerja') is-invalid @enderror"
                                id="tanggal_mulai_kerja" name="tanggal_mulai_kerja"
                                value="{{ old('tanggal_mulai_kerja', $questionnaire->tanggal_mulai_kerja ? $questionnaire->tanggal_mulai_kerja->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Penugasan Supervisor / Atasan -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">2</span>
                            <h2 class="akila-section-title">Penugasan Supervisor (Atasan Penilai)</h2>
                        </div>
                        <span class="akila-section-hint">Kontak tujuan pengiriman link kuesioner</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_atasan" class="akila-label">Nama Lengkap Atasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_atasan') is-invalid @enderror"
                                id="nama_atasan" name="nama_atasan"
                                value="{{ old('nama_atasan', $questionnaire->nama_atasan) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jabatan_atasan" class="akila-label">Jabatan Atasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan_atasan') is-invalid @enderror"
                                id="jabatan_atasan" name="jabatan_atasan"
                                value="{{ old('jabatan_atasan', $questionnaire->jabatan_atasan) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email_atasan" class="akila-label">Email Atasan</label>
                            <input type="email" class="form-control @error('email_atasan') is-invalid @enderror"
                                id="email_atasan" name="email_atasan"
                                value="{{ old('email_atasan', $questionnaire->email_atasan) }}" placeholder="atasan@perusahaan.com">
                        </div>

                        <div class="col-md-6">
                            <label for="wa_atasan" class="akila-label">Nomor WhatsApp Atasan</label>
                            <input type="text" class="form-control @error('wa_atasan') is-invalid @enderror"
                                id="wa_atasan" name="wa_atasan"
                                value="{{ old('wa_atasan', $questionnaire->wa_atasan) }}" placeholder="6281234567890">
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: Periode & Status Survei -->
                <div class="akila-form-section">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">3</span>
                            <h2 class="akila-section-title">Periode & Status Pengisian</h2>
                        </div>
                        <span class="akila-section-hint">Pengaturan akses & masa berlaku link</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="status_pengisian" class="akila-label">Status Pengisian <span class="text-danger">*</span></label>
                            <select class="form-select @error('status_pengisian') is-invalid @enderror"
                                id="status_pengisian" name="status_pengisian" required>
                                <option value="pending" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                                <option value="sent" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'sent' ? 'selected' : '' }}>Terkirim (Sent)</option>
                                <option value="completed" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'completed' ? 'selected' : '' }}>Selesai (Completed)</option>
                                <option value="expired" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'expired' ? 'selected' : '' }}>Kadaluarsa (Expired)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="expires_at" class="akila-label">Batas Waktu Pengisian <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                id="expires_at" name="expires_at"
                                value="{{ old('expires_at', $questionnaire->expires_at ? (is_object($questionnaire->expires_at) ? $questionnaire->expires_at->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($questionnaire->expires_at)->format('Y-m-d\TH:i')) : '') }}" required>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: Penilaian 7 Indikator Kompetensi & Evaluasi -->
                <div class="akila-form-section" id="section-evaluasi">
                    <div class="akila-section-header">
                        <div class="akila-section-title-wrap">
                            <span class="akila-step-badge">4</span>
                            <h2 class="akila-section-title">Skor Penilaian Kompetensi (7 Indikator)</h2>
                        </div>
                        <span class="akila-section-hint">Jika ke-7 skor diisi, status otomatis menjadi Selesai</span>
                    </div>

                    <div class="mb-3 row g-3">
                        @foreach($indikatorFields as $field => $label)
                            <div class="col-md-6 col-lg-4">
                                <label for="{{ $field }}" class="akila-label">{{ $label }}</label>
                                <select id="{{ $field }}" name="{{ $field }}" class="form-select">
                                    <option value="">-- Belum Diisi --</option>
                                    @foreach($skorOptions as $val => $optText)
                                        <option value="{{ $val }}" {{ (string) old($field, $questionnaire->{$field}) === (string) $val ? 'selected' : '' }}>
                                            {{ $optText }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div class="col-md-6 col-lg-4">
                            <label for="kesesuaian_pendidikan_pekerjaan" class="akila-label">Kesesuaian Pendidikan & Pekerjaan</label>
                            <select id="kesesuaian_pendidikan_pekerjaan" name="kesesuaian_pendidikan_pekerjaan" class="form-select">
                                <option value="">-- Pilih Kesesuaian --</option>
                                <option value="sangat_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan', $questionnaire->kesesuaian_pendidikan_pekerjaan) == 'sangat_sesuai' ? 'selected' : '' }}>Sangat Sesuai</option>
                                <option value="sesuai" {{ old('kesesuaian_pendidikan_pekerjaan', $questionnaire->kesesuaian_pendidikan_pekerjaan) == 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                                <option value="cukup_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan', $questionnaire->kesesuaian_pendidikan_pekerjaan) == 'cukup_sesuai' ? 'selected' : '' }}>Cukup Sesuai</option>
                                <option value="kurang_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan', $questionnaire->kesesuaian_pendidikan_pekerjaan) == 'kurang_sesuai' ? 'selected' : '' }}>Kurang Sesuai</option>
                                <option value="tidak_sesuai" {{ old('kesesuaian_pendidikan_pekerjaan', $questionnaire->kesesuaian_pendidikan_pekerjaan) == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label for="kualitas_lulusan" class="akila-label">Penilaian Kualitas Lulusan</label>
                            <select id="kualitas_lulusan" name="kualitas_lulusan" class="form-select">
                                <option value="">-- Pilih Kualitas --</option>
                                <option value="sangat_baik" {{ old('kualitas_lulusan', $questionnaire->kualitas_lulusan) == 'sangat_baik' ? 'selected' : '' }}>Sangat Baik</option>
                                <option value="baik" {{ old('kualitas_lulusan', $questionnaire->kualitas_lulusan) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="cukup" {{ old('kualitas_lulusan', $questionnaire->kualitas_lulusan) == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="kurang" {{ old('kualitas_lulusan', $questionnaire->kualitas_lulusan) == 'kurang' ? 'selected' : '' }}>Kurang</option>
                                <option value="sangat_kurang" {{ old('kualitas_lulusan', $questionnaire->kualitas_lulusan) == 'sangat_kurang' ? 'selected' : '' }}>Sangat Kurang</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="saran_perbaikan" class="akila-label">Saran & Masukan dari Atasan</label>
                        <textarea id="saran_perbaikan" name="saran_perbaikan" class="form-control" rows="3"
                            placeholder="Tuliskan saran perbaikan dari perusahaan/atasan...">{{ old('saran_perbaikan', $questionnaire->saran_perbaikan) }}</textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="akila-form-footer">
                    <a href="{{ route('admin.supervisor-questionnaire.show', $questionnaire->id) }}" class="btn-akila-outline">
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

@section('scripts')
    <script>
        document.getElementById('wa_atasan')?.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (!value) {
                e.target.value = '';
                return;
            }
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            } else if (!value.startsWith('62')) {
                value = '62' + value;
            }
            e.target.value = value;
        });

        document.addEventListener('DOMContentLoaded', function () {
            const expiresAtField = document.getElementById('expires_at');
            if (expiresAtField && !expiresAtField.value) {
                const now = new Date();
                now.setDate(now.getDate() + 7);
                expiresAtField.value = now.toISOString().slice(0, 16);
            }
        });
    </script>
@endsection
