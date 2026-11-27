@extends('layouts.admin')

@section('content')
    @php
        $statusMap = [
            'bekerja_full'  => ['label' => 'Bekerja Full-Time', 'dot' => 'st-green'],
            'wirausaha'     => ['label' => 'Wirausaha', 'dot' => 'st-blue'],
            'lanjutstudy'   => ['label' => 'Studi Lanjut', 'dot' => 'st-blue'],
            'belum_bekerja' => ['label' => 'Belum Bekerja', 'dot' => 'st-amber'],
            'tidak'         => ['label' => 'Mencari Kerja', 'dot' => 'st-slate'],
        ];
        $st = $statusMap[$tracerStudy->status_pekerjaan] ?? ['label' => ucfirst($tracerStudy->status_pekerjaan ?? 'Terdata'), 'dot' => 'st-green'];

        $instansi = '-';
        $posisi = '-';
        if ($tracerStudy->status_pekerjaan === 'bekerja_full' && $tracerStudy->pekerjaan) {
            $instansi = $tracerStudy->pekerjaan->nama_perusahaan ?: '-';
            $posisi = $tracerStudy->pekerjaan->jabatan ?: '-';
        } elseif ($tracerStudy->status_pekerjaan === 'wirausaha' && $tracerStudy->wirausaha) {
            $instansi = $tracerStudy->wirausaha->nama_usaha ?: '-';
            $posisi = ucfirst($tracerStudy->wirausaha->posisi_usaha ?? '-');
        } elseif ($tracerStudy->status_pekerjaan === 'lanjutstudy' && $tracerStudy->pendidikan) {
            $instansi = $tracerStudy->pendidikan->universitas ?? $tracerStudy->pendidikan->nama_universitas ?? '-';
            $posisi = $tracerStudy->pendidikan->program_studi ?: '-';
        }

        $formatLevel = function ($val) {
            $map = [
                '5' => ['label' => 'Sangat Baik', 'score' => 5],
                '4' => ['label' => 'Baik', 'score' => 4],
                '3' => ['label' => 'Cukup', 'score' => 3],
                '2' => ['label' => 'Kurang Baik', 'score' => 2],
                '1' => ['label' => 'Tidak Baik', 'score' => 1],
                'sangat_baik' => ['label' => 'Sangat Baik', 'score' => 5],
                'baik' => ['label' => 'Baik', 'score' => 4],
                'cukup' => ['label' => 'Cukup', 'score' => 3],
                'kurang_baik' => ['label' => 'Kurang Baik', 'score' => 2],
                'kurang' => ['label' => 'Kurang Baik', 'score' => 2],
                'tidak_baik' => ['label' => 'Tidak Baik', 'score' => 1],
            ];
            return $map[(string) $val] ?? ['label' => $val ? ucwords(str_replace('_', ' ', $val)) : 'Belum Diisi', 'score' => 0];
        };

        $kompLabels = [
            'etika' => 'Etika & Moral',
            'keahlian' => 'Keahlian Bidang Ilmu',
            'bahasa_inggris' => 'Bahasa Inggris',
            'teknologi' => 'Penggunaan Teknologi Informasi',
            'kerjasama' => 'Kerjasama Tim',
            'komunikasi' => 'Komunikasi',
        ];

        $evalLabels = [
            'perkuliahan' => 'Materi Perkuliahan',
            'praktikum' => 'Kualitas Praktikum',
            'demonstrasi' => 'Demonstrasi Mata Kuliah',
            'riset' => 'Pelaksanaan Riset',
            'magang' => 'Program Magang / PKL',
            'kerja_lapangan' => 'Kuliah Kerja Lapangan',
            'diskusi' => 'Interaksi & Diskusi Kelas',
        ];

        $prodiFormatted = ucwords(str_replace('_', ' ', $tracerStudy->prodi ?: ($tracerStudy->alumni->prodi ?? 'Teknik Informatika')));
    @endphp

    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb d-print-none">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <a href="{{ route('listtraceralumni.index') }}">Tracer Alumni</a>
            <span class="sep">&rsaquo;</span>
            <span class="active">{{ $tracerStudy->nama }}</span>
        </div>

        <!-- Top Summary Card -->
        <div class="akila-detail-card">
            <div class="akila-detail-top">
                <div class="akila-detail-identity">
                    <div class="akila-detail-icon">
                        <i class="fa fa-user-graduate"></i>
                    </div>
                    <div>
                        <div class="akila-detail-title-row">
                            <h1 class="akila-detail-title">{{ $tracerStudy->nama }}</h1>
                            <span class="akila-status-dot-badge {{ $st['dot'] }}">
                                <span class="dot"></span> {{ $st['label'] }}
                            </span>
                        </div>
                        <p class="akila-subtitle">
                            Data pengisian kuesioner Tracer Study Alumni Program Studi {{ $prodiFormatted }} (NIM: {{ $tracerStudy->nim ?: ($tracerStudy->alumni->nim ?? '-') }}).
                        </p>
                    </div>
                </div>

                <div class="akila-header-actions d-print-none">
                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <a href="{{ route('listtraceralumni.edit', $tracerStudy->id) }}" class="btn-akila-outline">
                            <i class="far fa-edit"></i> Edit Data
                        </a>
                    @endif
                    <button type="button" onclick="window.print()" class="btn-akila-outline">
                        <i class="fa fa-print"></i> Cetak
                    </button>
                    <a href="{{ route('listtraceralumni.index') }}" class="btn-akila-dark">
                        <i class="fa fa-arrow-left"></i> Daftar Tracer Alumni
                    </a>
                </div>
            </div>

            <!-- Meta Info Boxes -->
            <div class="akila-meta-grid">
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Alumni / NIM</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-id-card text-warning"></i>
                        <span>{{ $tracerStudy->nim ?: ($tracerStudy->alumni->nim ?? '-') }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Tahun Lulus</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-graduation-cap text-primary"></i>
                        <span>Angkatan Lulus {{ $tracerStudy->tahun_lulus ?: '-' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Instansi / Tempat Berkarya</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-building text-success"></i>
                        <span>{{ $instansi }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Tanggal Pengisian</div>
                    <div class="akila-meta-value">
                        <i class="far fa-calendar-alt text-secondary"></i>
                        <span>{{ optional($tracerStudy->created_at)->format('d M Y') ?? '-' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Status Kuesioner</div>
                    <div class="akila-meta-value">
                        <span class="text-success" style="font-size: 0.6rem;"><i class="fa fa-circle"></i></span>
                        <span>Submitted (Lengkap)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Tabbed Detail Card -->
        <div class="akila-tabs-card">
            <div class="akila-tabs-nav d-print-none" role="tablist">
                <button type="button" class="akila-tab-btn active" data-tab="tab-info">
                    <i class="fa fa-info-circle"></i> Informasi Alumni
                </button>
                <button type="button" class="akila-tab-btn" data-tab="tab-karier">
                    <i class="fa fa-briefcase"></i> Detail Karier / Studi
                </button>
                <button type="button" class="akila-tab-btn" data-tab="tab-kompetensi">
                    <i class="fa fa-check-double"></i> Kompetensi {{ $tracerStudy->kompetensi ? '(' . count($kompLabels) . ')' : '(0)' }}
                </button>
                <button type="button" class="akila-tab-btn" data-tab="tab-evaluasi">
                    <i class="fa fa-chart-bar"></i> Evaluasi & Masukan
                </button>
            </div>

            <!-- TAB 1: Informasi Alumni -->
            <div class="akila-tab-pane active" id="tab-info">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="akila-field-group">
                            <div class="akila-field-label">Nama Lengkap Alumni</div>
                            <div class="akila-field-value">{{ $tracerStudy->nama }}</div>
                        </div>
                        <div class="akila-field-group">
                            <div class="akila-field-label">Alamat Domisili Lengkap</div>
                            <div class="akila-field-text">{{ $tracerStudy->alamat ?: 'Belum ada data alamat domisili.' }}</div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="mb-0 akila-field-group">
                                    <div class="akila-field-label">Email Aktif</div>
                                    <div class="akila-field-value">{{ $tracerStudy->email ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-0 akila-field-group">
                                    <div class="akila-field-label">Nomor WhatsApp / HP</div>
                                    <div class="akila-field-value">
                                        @if($tracerStudy->no_hp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tracerStudy->no_hp) }}" target="_blank" class="text-success text-decoration-none">
                                                <i class="fab fa-whatsapp me-1"></i>{{ $tracerStudy->no_hp }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="akila-competency-panel">
                            <div class="mb-1 akila-field-label">Kompetensi yang Dikuasai Saat Ini</div>
                            <div class="akila-comp-grid">
                                @if($tracerStudy->kompetensi)
                                    @foreach($kompLabels as $key => $label)
                                        @php $lv = $formatLevel($tracerStudy->kompetensi->{$key . '_sekarang'} ?? null); @endphp
                                        <span class="akila-comp-chip">
                                            <i class="fa fa-check"></i> {{ $label }} ({{ $lv['label'] }})
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">Data evaluasi kompetensi mandiri belum diisi.</span>
                                @endif
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="akila-field-label">Program Studi</div>
                                <div class="mb-0 akila-field-value">{{ $prodiFormatted }}</div>
                                <small class="text-muted">NIM: {{ $tracerStudy->nim ?: '-' }}</small>
                            </div>
                            <div class="col-sm-6">
                                <div class="akila-field-label">Posisi / Jabatan Saat Ini</div>
                                <div class="mb-0 akila-field-value">{{ $posisi }}</div>
                                <small class="text-muted">{{ $instansi }}</small>
                            </div>
                        </div>

                        <div class="akila-audit-grid">
                            <div class="akila-audit-item">
                                <small>Dibuat Pada</small>
                                <span>{{ optional($tracerStudy->created_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                            <div class="akila-audit-item">
                                <small>Terakhir Diperbarui</small>
                                <span>{{ optional($tracerStudy->updated_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Detail Karier / Studi -->
            <div class="akila-tab-pane" id="tab-karier">
                @if ($tracerStudy->status_pekerjaan === 'bekerja_full' && $tracerStudy->pekerjaan)
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="akila-field-label">Nama Perusahaan</div>
                            <div class="akila-field-value">{{ $tracerStudy->pekerjaan->nama_perusahaan ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Jabatan / Posisi</div>
                            <div class="akila-field-value">{{ $tracerStudy->pekerjaan->jabatan ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Pendapatan Bulanan</div>
                            <div class="akila-field-value text-success">
                                {{ is_numeric($tracerStudy->pekerjaan->pendapatan) ? 'Rp ' . number_format((float) $tracerStudy->pekerjaan->pendapatan, 0, ',', '.') : ($tracerStudy->pekerjaan->pendapatan ?: '-') }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Lokasi Pekerjaan</div>
                            <div class="akila-field-text">{{ $tracerStudy->pekerjaan->alamat_pekerjaan ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Waktu Tunggu Kerja</div>
                            <div class="akila-field-value">{{ $tracerStudy->pekerjaan->mendapatkan_pekerjaan ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Kesesuaian Bidang Studi</div>
                            <div class="akila-field-value">
                                <span class="akila-badge akila-badge-green">
                                    {{ ucwords(str_replace('_', ' ', $tracerStudy->pekerjaan->hubungan_studi_pekerjaan ?: 'Sesuai')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @elseif ($tracerStudy->status_pekerjaan === 'wirausaha' && $tracerStudy->wirausaha)
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="akila-field-label">Nama Usaha</div>
                            <div class="akila-field-value">{{ $tracerStudy->wirausaha->nama_usaha ?: '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Posisi dalam Usaha</div>
                            <div class="akila-field-value">{{ ucfirst($tracerStudy->wirausaha->posisi_usaha ?: '-') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="akila-field-label">Tingkat / Skala Usaha</div>
                            <div class="akila-field-value">{{ ucfirst($tracerStudy->wirausaha->tingkat_usaha ?: '-') }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="akila-field-label">Omzet / Pendapatan Usaha</div>
                            <div class="akila-field-value text-success">
                                {{ is_numeric($tracerStudy->wirausaha->pendapatan_usaha) ? 'Rp ' . number_format((float) $tracerStudy->wirausaha->pendapatan_usaha, 0, ',', '.') : ($tracerStudy->wirausaha->pendapatan_usaha ?: '-') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="akila-field-label">Alamat Usaha</div>
                            <div class="akila-field-text">{{ $tracerStudy->wirausaha->alamat_usaha ?: '-' }}</div>
                        </div>
                    </div>
                @elseif ($tracerStudy->status_pekerjaan === 'lanjutstudy' && $tracerStudy->pendidikan)
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="akila-field-label">Universitas / Perguruan Tinggi</div>
                            <div class="akila-field-value">{{ $tracerStudy->pendidikan->universitas ?? $tracerStudy->pendidikan->nama_universitas ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="akila-field-label">Program Studi Lanjutan</div>
                            <div class="akila-field-value">{{ $tracerStudy->pendidikan->program_studi ?: '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="akila-field-label">Sumber Pembiayaan</div>
                            <div class="akila-field-value">{{ ucwords(str_replace('_', ' ', $tracerStudy->pendidikan->sumber_biaya ?: '-')) }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="akila-field-label">Tanggal Masuk Studi</div>
                            <div class="akila-field-value">{{ $tracerStudy->pendidikan->tanggal_masuk ?: '-' }}</div>
                        </div>
                    </div>
                @else
                    <div class="py-4 text-center text-muted">
                        <i class="mb-2 opacity-50 fa fa-briefcase fa-2x"></i>
                        <p class="mb-0 small">Status alumni saat ini adalah <strong>{{ $st['label'] }}</strong> sehingga belum ada rincian instansi pekerjaan/studi lanjutan.</p>
                    </div>
                @endif
            </div>

            <!-- TAB 3: Kompetensi -->
            <div class="akila-tab-pane" id="tab-kompetensi">
                @if($tracerStudy->kompetensi)
                    <div class="akila-table-wrapper">
                        <table class="table mb-0 align-middle akila-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 56px;">No.</th>
                                    <th>Aspek Kompetensi</th>
                                    <th class="text-center">Saat Awal Lulus</th>
                                    <th class="text-center">Kondisi Saat Ini</th>
                                    <th class="text-center">Perkembangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($kompLabels as $key => $label)
                                    @php
                                        $awal = $formatLevel($tracerStudy->kompetensi->{$key . '_awal'} ?? null);
                                        $skrg = $formatLevel($tracerStudy->kompetensi->{$key . '_sekarang'} ?? null);
                                        $diff = $skrg['score'] - $awal['score'];
                                    @endphp
                                    <tr>
                                        <td class="text-center text-muted fw-semibold">{{ $no++ }}</td>
                                        <td class="akila-cell-title">{{ $label }}</td>
                                        <td class="text-center">
                                            <span class="akila-badge akila-badge-outline">{{ $awal['label'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="akila-badge akila-badge-green">{{ $skrg['label'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($diff > 0)
                                                <span class="akila-substatus-ok"><i class="fa fa-arrow-up me-1"></i>Meningkat (+{{ $diff }})</span>
                                            @elseif($diff < 0)
                                                <span class="akila-substatus-warn"><i class="fa fa-arrow-down me-1"></i>{{ $diff }}</span>
                                            @else
                                                <span class="akila-substatus-muted">Stabil</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mb-0 text-muted">Belum ada data penilaian kompetensi mandiri.</p>
                @endif
            </div>

            <!-- TAB 4: Evaluasi & Masukan -->
            <div class="akila-tab-pane" id="tab-evaluasi">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="mb-3 akila-field-label">Penilaian Metode Pembelajaran di Kampus</div>
                        @if($tracerStudy->evaluasiPendidikan)
                            <div class="row g-2">
                                @foreach($evalLabels as $eKey => $eLabel)
                                    @php $ev = $formatLevel($tracerStudy->evaluasiPendidikan->{$eKey} ?? null); @endphp
                                    <div class="col-sm-6">
                                        <div class="akila-meta-box d-flex justify-content-between align-items-center">
                                            <span class="small fw-semibold text-dark">{{ $eLabel }}</span>
                                            <span class="akila-badge akila-badge-blue">{{ $ev['label'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small">Data evaluasi metode pembelajaran belum diisi.</p>
                        @endif
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-0 akila-competency-panel h-100">
                            <div class="mb-2 akila-field-label">Saran & Masukan untuk Almamater</div>
                            <div class="akila-field-text">
                                {{ $tracerStudy->evaluasiPendidikan->saran ?? $tracerStudy->saran ?? 'Tidak ada catatan saran tambahan dari alumni.' }}
                            </div>
                        </div>
                    </div>
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
