@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="py-3 bg-body-light border-bottom">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="mb-0 h3 fw-bold text-primary">
                    <i class="fa fa-eye me-2"></i> Detail Atasan (Pengguna Alumni)
                </h1>
                <p class="mb-0 text-muted fs-sm">Lihat detail lengkap kuesioner pengguna alumni (atasan).</p>
            </div>
            <div>
                <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn btn-primary ms-2">
                    <i class="fa fa-chart-pie me-1"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <!-- Informasi Utama -->
            <div class="col-lg-8">
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-info-circle me-2"></i> Informasi Utama
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Alumni</label>
                                <p class="form-control-plaintext">{{ $questionnaire->nama_alumni }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jabatan Alumni</label>
                                <p class="form-control-plaintext">{{ $questionnaire->jabatan_alumni }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Atasan</label>
                                <p class="form-control-plaintext">{{ $questionnaire->nama_atasan }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jabatan Atasan</label>
                                <p class="form-control-plaintext">{{ $questionnaire->jabatan_atasan }}</p>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label fw-semibold">NIPY</label>
                                <p class="form-control-plaintext">{{ $questionnaire->nipy }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Perusahaan</label>
                                <p class="form-control-plaintext">{{ $questionnaire->nama_perusahaan }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Mulai Kerja</label>
                                <p class="form-control-plaintext">
                                    {{ $questionnaire->tanggal_mulai_kerja ? $questionnaire->tanggal_mulai_kerja->format('d-m-Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Kontak -->
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-address-book me-2"></i> Informasi Kontak
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email Atasan</label>
                                <p class="form-control-plaintext">
                                    @if ($questionnaire->email_atasan)
                                        <i class="fa fa-envelope me-2"></i>{{ $questionnaire->email_atasan }}
                                    @else
                                        <span class="text-muted">Tidak ada email</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">WhatsApp Atasan</label>
                                <p class="form-control-plaintext">
                                    @if ($questionnaire->wa_atasan)
                                        <i class="fa fa-whatsapp me-2"></i>{{ $questionnaire->wa_atasan }}
                                    @else
                                        <span class="text-muted">Tidak ada WhatsApp</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status dan Token -->
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-key me-2"></i> Status dan Akses
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status Pengisian</label>
                                <div>
                                    @if ($questionnaire->status_pengisian == 'completed')
                                        <span class="badge bg-success fs-6">Selesai</span>
                                    @elseif($questionnaire->status_pengisian == 'sent')
                                        <span class="badge bg-info fs-6">Terkirim</span>
                                    @elseif($questionnaire->status_pengisian == 'pending')
                                        @if ($questionnaire->expires_at < now())
                                            <span class="badge bg-danger fs-6">Kadaluarsa</span>
                                        @else
                                            <span class="badge bg-warning text-dark fs-6">Menunggu</span>
                                        @endif
                                    @else
                                        <span
                                            class="badge bg-secondary fs-6">{{ ucfirst($questionnaire->status_pengisian) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Token Akses</label>
                                <p class="form-control-plaintext font-monospace">{{ $questionnaire->token_akses }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Link Kuesioner</label>
                                <div class="gap-2 d-flex">
                                    <input type="text" class="form-control form-control-sm"
                                        value="{{ $questionnaire->getQuestionnaireUrl() }}" readonly>
                                    <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard(this)">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Dibuat</label>
                                <p class="form-control-plaintext">
                                    {{ $questionnaire->created_at ? $questionnaire->created_at->format('d-m-Y H:i:s') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kadaluarsa</label>
                                <p class="form-control-plaintext">
                                    @if ($questionnaire->expires_at)
                                        <span
                                            class="{{ $questionnaire->expires_at < now() ? 'text-danger' : 'text-muted' }}">
                                            {{ \Carbon\Carbon::parse($questionnaire->expires_at)->format('d-m-Y H:i:s') }}
                                        </span>
                                        @if ($questionnaire->expires_at < now())
                                            <br><small class="text-danger">Link sudah kadaluarsa</small>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Evaluasi Kuesioner -->
                @if ($questionnaire->status_pengisian == 'completed')
                    <div class="block shadow-sm block-rounded">
                        <div class="block-header block-header-default bg-light">
                            <h3 class="mb-0 block-title fw-semibold text-primary">
                                <i class="fa fa-star me-2"></i> Data Evaluasi Kuesioner
                            </h3>
                        </div>
                        <div class="block-content block-content-full">
                            <!-- Evaluasi Kinerja (Point A) -->
                            <div class="mb-4">
                                <h5 class="mb-3 fw-semibold text-dark">
                                    <i class="fa fa-chart-line me-2"></i> Evaluasi Kinerja Alumni
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Integritas</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->integritas ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->integritas ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Keahlian</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->keahlian ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->keahlian ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kemampuan</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->kemampuan ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->kemampuan ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Penguasaan</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->penguasaan ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->penguasaan ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Komunikasi</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->komunikasi ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->komunikasi ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kerja Tim</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->kerja_tim ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->kerja_tim ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Pengembangan</label>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fa fa-star {{ $i <= ($questionnaire->pengembangan ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                            <span
                                                class="badge bg-primary ms-2">{{ $questionnaire->pengembangan ?? '-' }}/5</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluasi Kesesuaian Pendidikan -->
                            <div class="mb-4">
                                <h5 class="mb-3 fw-semibold text-dark">
                                    <i class="fa fa-graduation-cap me-2"></i> Evaluasi Kesesuaian Pendidikan
                                </h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kesesuaian Pendidikan dengan
                                            Pekerjaan</label>
                                        <div>
                                            @if ($questionnaire->kesesuaian_pendidikan_pekerjaan)
                                                @php
                                                    $kesesuaianLabels = [
                                                        'sangat_sesuai' => 'Sangat Sesuai',
                                                        'sesuai' => 'Sesuai',
                                                        'cukup_sesuai' => 'Cukup Sesuai',
                                                        'kurang_sesuai' => 'Kurang Sesuai',
                                                        'tidak_sesuai' => 'Tidak Sesuai',
                                                    ];
                                                    $kesesuaianColor = [
                                                        'sangat_sesuai' => 'success',
                                                        'sesuai' => 'info',
                                                        'cukup_sesuai' => 'warning',
                                                        'kurang_sesuai' => 'danger',
                                                        'tidak_sesuai' => 'dark',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $kesesuaianColor[$questionnaire->kesesuaian_pendidikan_pekerjaan] }} fs-6">
                                                    {{ $kesesuaianLabels[$questionnaire->kesesuaian_pendidikan_pekerjaan] }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kualitas Lulusan</label>
                                        <div>
                                            @if ($questionnaire->kualitas_lulusan)
                                                @php
                                                    $kualitasLabels = [
                                                        'sangat_baik' => 'Sangat Baik',
                                                        'baik' => 'Baik',
                                                        'cukup' => 'Cukup',
                                                        'kurang' => 'Kurang',
                                                        'sangat_kurang' => 'Sangat Kurang',
                                                    ];
                                                    $kualitasColor = [
                                                        'sangat_baik' => 'success',
                                                        'baik' => 'info',
                                                        'cukup' => 'warning',
                                                        'kurang' => 'danger',
                                                        'sangat_kurang' => 'dark',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $kualitasColor[$questionnaire->kualitas_lulusan] }} fs-6">
                                                    {{ $kualitasLabels[$questionnaire->kualitas_lulusan] }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Saran Perbaikan -->
                            @if ($questionnaire->saran_perbaikan)
                                <div class="mb-4">
                                    <h5 class="mb-3 fw-semibold text-dark">
                                        <i class="fa fa-comment me-2"></i> Saran Perbaikan
                                    </h5>
                                    <div class="p-3 rounded bg-light">
                                        <p class="mb-0">{{ $questionnaire->saran_perbaikan }}</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Tanggal Pengisian -->
                            <div class="text-muted small">
                                <i class="fa fa-clock me-1"></i>
                                Diisi pada:
                                {{ $questionnaire->tanggal_isi ? \Carbon\Carbon::parse($questionnaire->tanggal_isi)->format('d-m-Y H:i:s') : '-' }}
                            </div>

                            <!-- Chart Evaluasi -->
                            <div class="mt-4">
                                <h5 class="mb-3 fw-semibold text-dark">
                                    <i class="fa fa-chart-bar me-2"></i> Grafik Evaluasi Kinerja
                                </h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <canvas id="evaluationChart" width="400" height="200"></canvas>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 rounded bg-light">
                                            <h6 class="mb-2 fw-semibold">Ringkasan Skor</h6>
                                            <div class="mb-2">
                                                <small class="text-muted">Skor Tertinggi:</small><br>
                                                <span class="badge bg-success fs-6">
                                                    @php
                                                        $scores = [
                                                            'integritas' => $questionnaire->integritas ?? 0,
                                                            'keahlian' => $questionnaire->keahlian ?? 0,
                                                            'kemampuan' => $questionnaire->kemampuan ?? 0,
                                                            'penguasaan' => $questionnaire->penguasaan ?? 0,
                                                            'komunikasi' => $questionnaire->komunikasi ?? 0,
                                                            'kerja_tim' => $questionnaire->kerja_tim ?? 0,
                                                            'pengembangan' => $questionnaire->pengembangan ?? 0,
                                                        ];
                                                        $labels = [
                                                            'integritas' => 'Integritas',
                                                            'keahlian' => 'Keahlian',
                                                            'kemampuan' => 'Kemampuan',
                                                            'penguasaan' => 'Penguasaan',
                                                            'komunikasi' => 'Komunikasi',
                                                            'kerja_tim' => 'Kerja Tim',
                                                            'pengembangan' => 'Pengembangan',
                                                        ];

                                                        // Filter out zero scores and get max
                                                        $nonZeroScores = array_filter($scores, function ($score) {
                                                            return $score > 0;
                                                        });

                                                        if (!empty($nonZeroScores)) {
                                                            $maxScore = max($nonZeroScores);
                                                            $maxKey = array_search($maxScore, $nonZeroScores);
                                                            echo $labels[$maxKey] . ' (' . $maxScore . '/5)';
                                                        } else {
                                                            echo 'Belum ada data';
                                                        }
                                                    @endphp
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Skor Terendah:</small><br>
                                                <span class="badge bg-warning text-dark fs-6">
                                                    @php
                                                        if (!empty($nonZeroScores)) {
                                                            $minScore = min($nonZeroScores);
                                                            $minKey = array_search($minScore, $nonZeroScores);
                                                            echo $labels[$minKey] . ' (' . $minScore . '/5)';
                                                        } else {
                                                            echo 'Belum ada data';
                                                        }
                                                    @endphp
                                                </span>
                                            </div>
                                            <div>
                                                <small class="text-muted">Rata-rata:</small><br>
                                                <span class="badge bg-primary fs-6">
                                                    @php
                                                        if (!empty($nonZeroScores)) {
                                                            echo number_format(
                                                                array_sum($nonZeroScores) / count($nonZeroScores),
                                                                2,
                                                            ) . '/5';
                                                        } else {
                                                            echo '0.00/5';
                                                        }
                                                    @endphp
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Pesan jika belum diisi -->
                    <div class="block shadow-sm block-rounded">
                        <div class="block-header block-header-default bg-light">
                            <h3 class="mb-0 block-title fw-semibold text-muted">
                                <i class="fa fa-info-circle me-2"></i> Status Kuesioner
                            </h3>
                        </div>
                        <div class="py-4 text-center block-content block-content-full">
                            <i class="mb-3 fa fa-file-alt fa-3x text-muted"></i>
                            <p class="mb-0 text-muted">
                                @if ($questionnaire->status_pengisian == 'pending')
                                    Kuesioner belum diisi oleh supervisor.
                                @elseif($questionnaire->status_pengisian == 'expired')
                                    Link kuesioner sudah kadaluarsa.
                                @else
                                    Kuesioner belum tersedia untuk diisi.
                                @endif
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Aksi -->
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-cogs me-2"></i> Aksi
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="gap-2 d-grid">
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin.supervisor-questionnaire.edit', $questionnaire->id) }}"
                                    class="btn btn-warning">
                                    <i class="fa fa-pencil-alt me-1"></i> Edit
                                </a>
                            @endif

                            @if ($questionnaire->status_pengisian == 'pending')
                                <button type="button" class="btn btn-info"
                                    onclick="resendNotification({{ $questionnaire->id }})">
                                    <i class="fa fa-paper-plane me-1"></i> Kirim Ulang Notifikasi
                                </button>
                            @endif

                            @if ($questionnaire->expires_at < now() && $questionnaire->status_pengisian != 'completed')
                                <button type="button" class="btn btn-success"
                                    onclick="extendExpiry({{ $questionnaire->id }})">
                                    <i class="fa fa-clock me-1"></i> Perpanjang Masa Berlaku
                                </button>
                            @endif
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <button type="button" class="btn btn-danger"
                                    onclick="deleteQuestionnaire({{ $questionnaire->id }})">
                                    <i class="fa fa-trash me-1"></i> Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-chart-bar me-2"></i> Statistik
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="text-center row g-2">
                            <div class="col-6">
                                <div class="p-3 rounded bg-light">
                                    <div class="fs-4 fw-bold text-primary">
                                        {{ $questionnaire->created_at ? $questionnaire->created_at->diffForHumans() : '-' }}
                                    </div>
                                    <div class="text-muted small">Dibuat</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded bg-light">
                                    <div class="fs-4 fw-bold text-warning">
                                        @if ($questionnaire->expires_at)
                                            {{ \Carbon\Carbon::parse($questionnaire->expires_at)->diffForHumans() }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                    <div class="text-muted small">Kadaluarsa</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize chart if questionnaire is completed
        @if ($questionnaire->status_pengisian == 'completed')
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('evaluationChart').getContext('2d');

                const data = {
                    labels: ['Integritas', 'Keahlian', 'Kemampuan', 'Penguasaan', 'Komunikasi', 'Kerja Tim',
                        'Pengembangan'
                    ],
                    datasets: [{
                        label: 'Skor Evaluasi',
                        data: [
                            {{ $questionnaire->integritas ?? 0 }},
                            {{ $questionnaire->keahlian ?? 0 }},
                            {{ $questionnaire->kemampuan ?? 0 }},
                            {{ $questionnaire->penguasaan ?? 0 }},
                            {{ $questionnaire->komunikasi ?? 0 }},
                            {{ $questionnaire->kerja_tim ?? 0 }},
                            {{ $questionnaire->pengembangan ?? 0 }}
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                };

                const config = {
                    type: 'radar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                beginAtZero: true,
                                max: 5,
                                ticks: {
                                    stepSize: 1,
                                    callback: function(value) {
                                        return value + '/5';
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.r + '/5';
                                    }
                                }
                            }
                        }
                    }
                };

                new Chart(ctx, config);
            });
        @endif

        // Copy to clipboard
        function copyToClipboard(button) {
            const input = button.previousElementSibling;
            input.select();
            document.execCommand('copy');

            // Show success message
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fa fa-check"></i>';
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-success');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-primary');
            }, 2000);
        }

        // Resend notification
        function resendNotification(id) {
            Swal.fire({
                title: 'Kirim Ulang Notifikasi?',
                text: 'Apakah Anda yakin ingin mengirim ulang notifikasi ke supervisor?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                }
            });
        }

        // Extend expiry
        function extendExpiry(id) {
            Swal.fire({
                title: 'Perpanjang Masa Berlaku?',
                text: 'Link akan diperpanjang 7 hari dari sekarang.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, perpanjang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memperpanjang masa berlaku',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make AJAX call to extend expiry
                    fetch(`/admin/supervisor-questionnaire/${id}/extend-expiry`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message,
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat memperpanjang masa berlaku.',
                                icon: 'error'
                            });
                        });
                }
            });
        }

        // Delete questionnaire
        function deleteQuestionnaire(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.supervisor-questionnaire.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
