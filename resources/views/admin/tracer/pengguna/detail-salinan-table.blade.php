@extends('layouts.admin')

@section('content')
    @php
        $konversiNilai = [
            '5' => ['label' => 'Sangat Baik', 'rating' => 5],
            '4' => ['label' => 'Baik', 'rating' => 4],
            '3' => ['label' => 'Cukup', 'rating' => 3],
            '2' => ['label' => 'Kurang', 'rating' => 2],
            '1' => ['label' => 'Tidak Baik', 'rating' => 1],
            'sangat_baik' => ['label' => 'Sangat Baik', 'rating' => 5],
            'baik' => ['label' => 'Baik', 'rating' => 4],
            'cukup' => ['label' => 'Cukup', 'rating' => 3],
            'kurang' => ['label' => 'Kurang', 'rating' => 2],
            'kurang_baik' => ['label' => 'Kurang Baik', 'rating' => 2],
            'tidak_baik' => ['label' => 'Tidak Baik', 'rating' => 1],
        ];

        $kompetensiAll = [
            'Integritas (Etika)' => $data->integritas,
            'Keahlian Bidang Ilmu' => $data->keahlian,
            'Kemampuan Bahasa Asing' => $data->kemampuan,
            'Penguasaan TIK' => $data->penguasaan,
            'Komunikasi' => $data->komunikasi,
            'Kerjasama Tim' => $data->kerja_tim,
            'Pengembangan Diri' => $data->pengembangan,
        ];

        $namaTampil = $data->nama ?: ($data->nama_alumni ?: 'Data Tracer Pengguna');
        $atasanTampil = $data->nama_atasan ?: '-';
        $jabatanAtasanTampil = $data->posisi_jabatan_atasan ?: ($data->jabatan_atasan ?: '-');
        $saranTampil = $data->saran ?: ($data->saran_perbaikan ?: null);
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
            <span class="active">{{ $namaTampil }}</span>
        </div>

        <!-- Top Summary Card -->
        <div class="akila-detail-card">
            <div class="akila-detail-top">
                <div class="akila-detail-identity">
                    <div class="akila-detail-icon">
                        <i class="fa fa-clipboard-check"></i>
                    </div>
                    <div>
                        <div class="akila-detail-title-row">
                            <h1 class="akila-detail-title">{{ $namaTampil }}</h1>
                            <span class="akila-status-dot-badge {{ $data->created_at ? 'st-green' : 'st-amber' }}">
                                <span class="dot"></span> {{ $data->created_at ? 'Sudah Mengisi' : 'Belum Mengisi' }}
                            </span>
                        </div>
                        <p class="akila-subtitle">
                            Data rekapan kuesioner pengguna lulusan pada <strong>{{ $data->nama_perusahaan ?: '-' }}</strong>.
                        </p>
                    </div>
                </div>

                <div class="akila-header-actions">
                    @if(Auth::user() && Auth::user()->role !== 'superadmin')
                        <a href="{{ route('listtracerpengguna.edit', $data->id) }}" class="btn-akila-outline">
                            <i class="far fa-edit"></i> Edit Data
                        </a>
                    @endif
                    <a href="{{ route('listtracerpengguna.index') }}" class="btn-akila-dark">
                        <i class="fa fa-arrow-left"></i> Daftar Salinan Pengguna
                    </a>
                </div>
            </div>

            <!-- Meta Info Boxes -->
            <div class="akila-meta-grid">
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Nama Atasan / Penilai</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-user text-warning"></i>
                        <span>{{ $atasanTampil }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Perusahaan</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-building text-primary"></i>
                        <span>{{ $data->nama_perusahaan ?: '-' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Program Studi</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-graduation-cap text-success"></i>
                        <span>{{ $data->prodi_name ?: 'Teknik Informatika' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Tanggal Tercatat</div>
                    <div class="akila-meta-value">
                        <i class="far fa-calendar-alt text-secondary"></i>
                        <span>{{ optional($data->created_at)->format('d M Y') ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Tabbed Detail Card -->
        <div class="akila-tabs-card">
            <div class="akila-tabs-nav" role="tablist">
                <button type="button" class="akila-tab-btn active" data-tab="tab-info-sp">
                    <i class="fa fa-info-circle"></i> Informasi Personal & Perusahaan
                </button>
                <button type="button" class="akila-tab-btn" data-tab="tab-komp-sp">
                    <i class="fa fa-star"></i> Penilaian Kompetensi (7)
                </button>
            </div>

            <!-- TAB 1 -->
            <div class="akila-tab-pane active" id="tab-info-sp">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="akila-field-group">
                            <div class="akila-field-label">Nama & Jabatan</div>
                            <div class="akila-field-value">{{ $namaTampil }}</div>
                            <small class="text-muted">Jabatan: {{ $data->jabatan ?: ($data->jabatan_alumni ?: '-') }}</small>
                        </div>
                        <div class="akila-field-group">
                            <div class="akila-field-label">Alamat Lengkap</div>
                            <div class="akila-field-text">{{ $data->alamat ?: '-' }}</div>
                        </div>
                        <div class="mb-0 akila-field-group">
                            <div class="akila-field-label">Saran & Komentar Industri</div>
                            <div class="akila-field-text">{{ $saranTampil ?: 'Tidak ada saran tertulis.' }}</div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="akila-competency-panel">
                            <div class="mb-1 akila-field-label">Ringkasan Penilaian Kompetensi</div>
                            <div class="akila-comp-grid">
                                @foreach($kompetensiAll as $label => $val)
                                    @php $disp = $konversiNilai[(string) $val] ?? ['label' => '-', 'rating' => 0]; @endphp
                                    <span class="akila-comp-chip">
                                        <i class="fa fa-check"></i> {{ $label }} ({{ $disp['label'] }})
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="akila-field-label">Atasan Penilai</div>
                                <div class="mb-0 akila-field-value">{{ $atasanTampil }}</div>
                                <small class="text-muted">{{ $jabatanAtasanTampil }} {{ $data->nip_atasan ? '• NIP: ' . $data->nip_atasan : '' }}</small>
                            </div>
                            <div class="col-sm-6">
                                <div class="akila-field-label">Alamat Perusahaan</div>
                                <div class="akila-field-text">{{ $data->alamat_perusahaan ?: '-' }}</div>
                            </div>
                        </div>

                        <div class="akila-audit-grid">
                            <div class="akila-audit-item">
                                <small>Dibuat Pada</small>
                                <span>{{ optional($data->created_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                            <div class="akila-audit-item">
                                <small>Terakhir Diperbarui</small>
                                <span>{{ optional($data->updated_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2 -->
            <div class="akila-tab-pane" id="tab-komp-sp">
                <div class="akila-table-wrapper">
                    <table class="table mb-0 align-middle akila-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 56px;">No.</th>
                                <th>Indikator Kompetensi</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Kategori Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $idx = 1; @endphp
                            @foreach ($kompetensiAll as $label => $value)
                                @php $display = $konversiNilai[(string) $value] ?? ['label' => 'Belum Diisi', 'rating' => 0]; @endphp
                                <tr>
                                    <td class="text-center text-muted fw-semibold">{{ $idx++ }}</td>
                                    <td class="akila-cell-title">{{ $label }}</td>
                                    <td class="text-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star {{ $i <= $display['rating'] ? 'text-warning' : 'text-muted opacity-25' }}" style="font-size: 0.78rem;"></i>
                                        @endfor
                                    </td>
                                    <td class="text-center">
                                        <span class="akila-badge {{ $display['rating'] >= 4 ? 'akila-badge-green' : ($display['rating'] >= 3 ? 'akila-badge-blue' : 'akila-badge-slate') }}">
                                            {{ $display['label'] }} ({{ $display['rating'] }}/5)
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.akila-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-tab');
                    document.querySelectorAll('.akila-tab-btn').forEach(b => b.classList.remove('active'));
                    document.querySelectorAll('.akila-tab-pane').forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    document.getElementById(targetId)?.classList.add('active');
                });
            });
        });
    </script>
@endsection
