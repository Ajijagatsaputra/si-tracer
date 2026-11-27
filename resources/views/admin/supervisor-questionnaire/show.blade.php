@extends('layouts.admin')

@section('content')
    @php
        $scores = array_filter([
            $questionnaire->integritas,
            $questionnaire->keahlian,
            $questionnaire->kemampuan,
            $questionnaire->penguasaan,
            $questionnaire->komunikasi,
            $questionnaire->kerja_tim,
            $questionnaire->pengembangan,
        ], fn($v) => is_numeric($v) && (int) $v > 0);

        $filledCount = count($scores);
        $hasScores = $filledCount > 0;
        $avgScore = $hasScores ? number_format(array_sum($scores) / $filledCount, 2) : null;
        $progressPct = round(($filledCount / 7) * 100);

        $isExpired = !$hasScores
            && $questionnaire->status_pengisian !== 'completed'
            && $questionnaire->expires_at
            && \Carbon\Carbon::parse($questionnaire->expires_at)->isPast();

        if ($questionnaire->status_pengisian === 'completed' || $filledCount === 7) {
            $statusLabel = 'Selesai';
            $statusDotClass = 'st-green';
        } elseif ($isExpired || $questionnaire->status_pengisian === 'expired') {
            $statusLabel = 'Kadaluarsa';
            $statusDotClass = 'st-red';
        } elseif ($questionnaire->status_pengisian === 'sent') {
            $statusLabel = 'Terkirim';
            $statusDotClass = 'st-blue';
        } else {
            $statusLabel = 'Menunggu';
            $statusDotClass = 'st-amber';
        }

        $indicators = [
            ['label' => 'Integritas (Etika)', 'val' => (int) ($questionnaire->integritas ?? 0)],
            ['label' => 'Keahlian Bidang Ilmu', 'val' => (int) ($questionnaire->keahlian ?? 0)],
            ['label' => 'Kemampuan Bahasa Asing', 'val' => (int) ($questionnaire->kemampuan ?? 0)],
            ['label' => 'Penguasaan Teknologi', 'val' => (int) ($questionnaire->penguasaan ?? 0)],
            ['label' => 'Komunikasi', 'val' => (int) ($questionnaire->komunikasi ?? 0)],
            ['label' => 'Kerjasama Tim', 'val' => (int) ($questionnaire->kerja_tim ?? 0)],
            ['label' => 'Pengembangan Diri', 'val' => (int) ($questionnaire->pengembangan ?? 0)],
        ];

        $kualitasMap = [
            'sangat_baik' => 'Sangat Baik',
            'baik' => 'Baik',
            'cukup' => 'Cukup',
            'kurang' => 'Kurang',
            'sangat_kurang' => 'Sangat Kurang',
        ];
        $kesesuaianMap = [
            'sangat_sesuai' => 'Sangat Sesuai',
            'sesuai' => 'Sesuai',
            'cukup_sesuai' => 'Cukup Sesuai',
            'kurang_sesuai' => 'Kurang Sesuai',
            'tidak_sesuai' => 'Tidak Sesuai',
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
            <span class="active">{{ $questionnaire->nama_alumni }}</span>
        </div>

        @if(session('success'))
            <div class="mb-3 akila-alert-banner" style="background: #f0fdf4; border-color: #bbf7d0; color: #166534;">
                <div class="akila-alert-body">
                    <div class="akila-alert-icon" style="background: #dcfce7; color: #16a34a;"><i class="fa fa-check-circle"></i></div>
                    <div class="akila-alert-content">
                        <div class="akila-alert-title" style="color: #14532d;">Berhasil</div>
                        <p class="akila-alert-desc" style="color: #166534;">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Top Summary Card -->
        <div class="akila-detail-card">
            <div class="akila-detail-top">
                <div class="akila-detail-identity">
                    <div class="akila-detail-icon">
                        <i class="fa fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="akila-detail-title-row">
                            <h1 class="akila-detail-title">{{ $questionnaire->nama_alumni }}</h1>
                            <span class="akila-status-dot-badge {{ $statusDotClass }}">
                                <span class="dot"></span> {{ $statusLabel }}
                            </span>
                        </div>
                        <p class="akila-subtitle">
                            Evaluasi kinerja lulusan sebagai <strong>{{ $questionnaire->jabatan_alumni ?: '-' }}</strong> pada <strong>{{ $questionnaire->nama_perusahaan ?: '-' }}</strong>.
                        </p>
                    </div>
                </div>

                <div class="akila-header-actions">
                    @if (Auth::user() && Auth::user()->role === 'admin')
                        <a href="{{ route('admin.supervisor-questionnaire.edit', $questionnaire->id) }}" class="btn-akila-outline">
                            <i class="far fa-edit"></i> Edit & Isi Nilai
                        </a>
                    @endif
                    <a href="{{ route('admin.supervisor-questionnaire.index') }}" class="btn-akila-dark">
                        <i class="fa fa-arrow-left"></i> Daftar Survei Pengguna
                    </a>
                </div>
            </div>

            <!-- Meta Info Boxes -->
            <div class="akila-meta-grid">
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Supervisor / Penilai</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-user text-warning"></i>
                        <span>{{ $questionnaire->nama_atasan ?: '-' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Perusahaan</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-building text-primary"></i>
                        <span>{{ $questionnaire->nama_perusahaan ?: '-' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Progress Evaluasi</div>
                    <div class="akila-meta-value">
                        <i class="fa fa-chart-pie {{ $hasScores ? 'text-success' : 'text-muted' }}"></i>
                        <span>{{ $hasScores ? "{$filledCount}/7 Indikator (Skor {$avgScore})" : '0/7 Indikator (0%)' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Batas Pengisian</div>
                    <div class="akila-meta-value">
                        <i class="far fa-calendar-alt {{ $isExpired ? 'text-danger' : 'text-secondary' }}"></i>
                        <span class="{{ $isExpired ? 'text-danger' : '' }}">{{ $questionnaire->expires_at ? \Carbon\Carbon::parse($questionnaire->expires_at)->format('d M Y') : '-' }}</span>
                    </div>
                </div>
                <div class="akila-meta-box">
                    <div class="akila-meta-label">Status Kuesioner</div>
                    <div class="akila-meta-value">
                        <span class="{{ $hasScores ? 'text-success' : ($isExpired ? 'text-danger' : 'text-warning') }}" style="font-size: 0.6rem;">
                            <i class="fa fa-circle"></i>
                        </span>
                        <span>{{ $statusLabel }} ({{ $progressPct }}%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Tabbed Detail Card -->
        <div class="akila-tabs-card">
            <div class="akila-tabs-nav" role="tablist">
                <button type="button" class="akila-tab-btn active" data-tab="tab-overview">
                    <i class="fa fa-info-circle"></i> Informasi Evaluasi
                </button>
                <button type="button" class="akila-tab-btn" data-tab="tab-skor">
                    <i class="fa fa-chart-line"></i> Grafik & Skor ({{ $filledCount }}/7)
                </button>
                <button type="button" class="akila-tab-btn" data-tab="tab-akses">
                    <i class="fa fa-link"></i> Link Akses & Kontrol
                </button>
            </div>

            <!-- TAB 1: Informasi Evaluasi -->
            <div class="akila-tab-pane active" id="tab-overview">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="akila-field-group">
                            <div class="akila-field-label">Alumni yang Dinilai</div>
                            <div class="akila-field-value">{{ $questionnaire->nama_alumni }}</div>
                            <small class="text-muted">Posisi: {{ $questionnaire->jabatan_alumni ?: '-' }} &bull; Mulai Kerja: {{ $questionnaire->tanggal_mulai_kerja ? $questionnaire->tanggal_mulai_kerja->format('d M Y') : '-' }}</small>
                        </div>

                        <div class="akila-field-group">
                            <div class="akila-field-label">Perusahaan / Instansi</div>
                            <div class="akila-field-value">{{ $questionnaire->nama_perusahaan ?: '-' }}</div>
                        </div>

                        <div class="mb-0 akila-field-group">
                            <div class="akila-field-label">Saran & Masukan dari Atasan</div>
                            <div class="akila-field-text">
                                {{ $questionnaire->saran_perbaikan ?: 'Belum ada catatan saran perbaikan kurikulum dari supervisor.' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="akila-competency-panel">
                            <div class="mb-1 akila-field-label">Kompetensi yang Dinilai ({{ $filledCount }}/7 Terisi)</div>
                            <div class="akila-comp-grid">
                                @foreach($indicators as $ind)
                                    <span class="akila-comp-chip" style="{{ $ind['val'] === 0 ? 'opacity: 0.65;' : '' }}">
                                        @if($ind['val'] > 0)
                                            <i class="fa fa-check"></i> {{ $ind['label'] }} ({{ $ind['val'] }}/5)
                                        @else
                                            <i class="far fa-clock text-warning"></i> {{ $ind['label'] }} (Belum Diisi)
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="akila-field-label">Supervisor Ditugaskan</div>
                                <div class="mb-0 akila-field-value">{{ $questionnaire->nama_atasan ?: '-' }}</div>
                                <small class="text-muted">{{ $questionnaire->jabatan_atasan ?: '-' }}{{ $questionnaire->nipy ? ' • NIP/ID: ' . $questionnaire->nipy : '' }}</small>
                            </div>
                            <div class="col-sm-6">
                                <div class="akila-field-label">Kontak Supervisor</div>
                                <div class="mb-0 akila-field-value" style="font-size: 0.82rem;">{{ $questionnaire->email_atasan ?: '-' }}</div>
                                @if($questionnaire->wa_atasan)
                                    <small class="text-success fw-semibold"><i class="fab fa-whatsapp me-1"></i>{{ $questionnaire->wa_atasan }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="akila-audit-grid">
                            <div class="akila-audit-item">
                                <small>Dibuat Pada</small>
                                <span>{{ optional($questionnaire->created_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                            <div class="akila-audit-item">
                                <small>Tanggal Diisi Atasan</small>
                                <span>{{ $questionnaire->tanggal_isi ? \Carbon\Carbon::parse($questionnaire->tanggal_isi)->format('d/m/Y H:i') : 'Belum diisi' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Grafik & Skor -->
            <div class="akila-tab-pane" id="tab-skor">
                @if (!$hasScores)
                    <div class="mb-4 akila-alert-banner">
                        <div class="akila-alert-body">
                            <div class="akila-alert-icon">
                                <i class="fa fa-info-circle"></i>
                            </div>
                            <div class="akila-alert-content">
                                <div class="akila-alert-title">Belum Ada Skor Penilaian Masuk (0/7 Indikator)</div>
                                <p class="akila-alert-desc">
                                    Supervisor (<strong>{{ $questionnaire->nama_atasan ?: '-' }}</strong> — {{ $questionnaire->nama_perusahaan ?: '-' }}) belum mengirimkan kuesioner evaluasi untuk <strong>{{ $questionnaire->nama_alumni }}</strong>.
                                    @if($isExpired)
                                        Masa berlaku link akses telah habis pada {{ \Carbon\Carbon::parse($questionnaire->expires_at)->format('d M Y') }} — silakan perpanjang masa berlaku terlebih dahulu atau input nilai melalui halaman Edit Survei.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="akila-alert-actions">
                            @if($isExpired)
                                <button type="button" class="btn-akila-retry" onclick="extendExpiry({{ $questionnaire->id }})">
                                    <i class="fa fa-clock"></i> Perpanjang 7 Hari
                                </button>
                            @elseif($questionnaire->token_akses)
                                <a href="{{ $questionnaire->getQuestionnaireUrl() }}" target="_blank" class="btn-akila-retry text-decoration-none">
                                    <i class="fa fa-external-link-alt"></i> Buka Form Kuesioner
                                </a>
                            @endif
                            @if (Auth::user() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin.supervisor-questionnaire.edit', $questionnaire->id) }}#section-evaluasi" class="btn-akila-dark">
                                    <i class="far fa-edit"></i> Isi Nilai Manual
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="mb-4 akila-stats-strip">
                        <div class="akila-stat-chip">
                            <i class="fa fa-star text-warning"></i>
                            <span>Rata-rata Skor: <strong>{{ $avgScore }} / 5.00</strong></span>
                        </div>
                        <div class="akila-stat-chip">
                            <i class="fa fa-award text-success"></i>
                            <span>Kualitas Lulusan: <strong>{{ $kualitasMap[$questionnaire->kualitas_lulusan] ?? '-' }}</strong></span>
                        </div>
                        <div class="akila-stat-chip">
                            <i class="fa fa-check-circle text-primary"></i>
                            <span>Kesesuaian Prodi: <strong>{{ $kesesuaianMap[$questionnaire->kesesuaian_pendidikan_pekerjaan] ?? '-' }}</strong></span>
                        </div>
                    </div>
                @endif

                <div class="row g-4 align-items-center">
                    <div class="col-lg-5">
                        <div class="p-3 border rounded-3 bg-light" style="height: 310px; background: #fafafa !important;">
                            <canvas id="evaluationChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="akila-table-wrapper">
                            <table class="table mb-0 align-middle akila-table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No.</th>
                                        <th>Indikator Kompetensi</th>
                                        <th class="text-center">Rating Bintang</th>
                                        <th class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($indicators as $idx => $ind)
                                        <tr>
                                            <td class="text-center text-muted fw-semibold">{{ $idx + 1 }}</td>
                                            <td class="akila-cell-title">{{ $ind['label'] }}</td>
                                            <td class="text-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star {{ $i <= $ind['val'] ? 'text-warning' : 'text-muted opacity-25' }}" style="font-size: 0.78rem;"></i>
                                                @endfor
                                            </td>
                                            <td class="text-center">
                                                @if($ind['val'] > 0)
                                                    <span class="akila-badge {{ $ind['val'] >= 4 ? 'akila-badge-green' : ($ind['val'] >= 3 ? 'akila-badge-blue' : 'akila-badge-amber') }}">
                                                        {{ $ind['val'] }} / 5
                                                    </span>
                                                @else
                                                    <span class="akila-badge akila-badge-slate">Belum Diisi</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 3: Link Akses & Kontrol -->
            <div class="akila-tab-pane" id="tab-akses">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="mb-2 akila-field-label">Link Kuesioner Khusus Supervisor</div>
                        <div class="gap-2 mb-3 d-flex flex-column flex-sm-row">
                            <input type="text" class="akila-control font-monospace" value="{{ $questionnaire->getQuestionnaireUrl() }}" readonly id="copyUrlInput">
                            <button type="button" class="btn-akila-dark" onclick="copyToClipboard(this)" style="white-space: nowrap;">
                                <i class="far fa-copy"></i> Salin Link
                            </button>
                            @if(!$isExpired && !$hasScores && $questionnaire->token_akses)
                                <a href="{{ $questionnaire->getQuestionnaireUrl() }}" target="_blank" class="btn-akila-outline" style="white-space: nowrap;">
                                    <i class="fa fa-external-link-alt"></i> Buka Form
                                </a>
                            @endif
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="akila-meta-box">
                                    <div class="akila-meta-label">Token Akses</div>
                                    <div class="akila-meta-value font-monospace">{{ $questionnaire->token_akses ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="akila-meta-box">
                                    <div class="akila-meta-label">Masa Berlaku Link</div>
                                    <div class="akila-meta-value {{ $isExpired ? 'text-danger' : '' }}">
                                        {{ $questionnaire->expires_at ? \Carbon\Carbon::parse($questionnaire->expires_at)->format('d/m/Y H:i') : '-' }}
                                        {{ $isExpired ? '(Kadaluarsa)' : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="mb-0 akila-competency-panel">
                            <div class="mb-2 akila-field-label">Tindakan Cepat Admin</div>
                            <div class="flex-wrap gap-2 d-flex">
                                @if (!$hasScores)
                                    <button type="button" class="btn-akila-outline" onclick="resendNotification({{ $questionnaire->id }})">
                                        <i class="far fa-paper-plane text-primary"></i> Kirim Ulang Notifikasi
                                    </button>
                                    <button type="button" class="btn-akila-outline" onclick="extendExpiry({{ $questionnaire->id }})">
                                        <i class="fa fa-clock text-success"></i> Perpanjang 7 Hari
                                    </button>
                                @endif
                                @if (Auth::user() && Auth::user()->role === 'admin')
                                    <button type="button" class="btn-akila-outline text-danger" onclick="deleteQuestionnaire({{ $questionnaire->id }})">
                                        <i class="far fa-trash-alt text-danger"></i> Hapus Survei
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let evalChartInstance = null;

            document.querySelectorAll('.akila-tab-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-tab');
                    document.querySelectorAll('.akila-tab-btn').forEach(b => b.classList.remove('active'));
                    document.querySelectorAll('.akila-tab-pane').forEach(p => p.classList.remove('active'));
                    this.classList.add('active');
                    document.getElementById(targetId)?.classList.add('active');
                    if (targetId === 'tab-skor' && evalChartInstance) {
                        setTimeout(() => evalChartInstance.resize(), 30);
                    }
                });
            });

            const ctx = document.getElementById('evaluationChart');
            if (ctx && typeof Chart !== 'undefined') {
                evalChartInstance = new Chart(ctx.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: ['Integritas', 'Keahlian', 'Bahasa', 'Teknologi', 'Komunikasi', 'Kerja Tim', 'Pengembangan'],
                        datasets: [{
                            label: 'Skor Evaluasi',
                            data: [
                                {{ (int) ($questionnaire->integritas ?? 0) }},
                                {{ (int) ($questionnaire->keahlian ?? 0) }},
                                {{ (int) ($questionnaire->kemampuan ?? 0) }},
                                {{ (int) ($questionnaire->penguasaan ?? 0) }},
                                {{ (int) ($questionnaire->komunikasi ?? 0) }},
                                {{ (int) ($questionnaire->kerja_tim ?? 0) }},
                                {{ (int) ($questionnaire->pengembangan ?? 0) }}
                            ],
                            backgroundColor: '{{ $hasScores ? "rgba(202, 138, 4, 0.16)" : "rgba(148, 163, 184, 0.12)" }}',
                            borderColor: '{{ $hasScores ? "#ca8a04" : "#94a3b8" }}',
                            borderWidth: 2,
                            pointBackgroundColor: '{{ $hasScores ? "#0f172a" : "#cbd5e1" }}'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                min: 0,
                                max: 5,
                                beginAtZero: true,
                                ticks: { stepSize: 1, backdropColor: 'transparent', font: { size: 10 } }
                            }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            }
        });

        function copyToClipboard(button) {
            const input = document.getElementById('copyUrlInput');
            navigator.clipboard.writeText(input.value).then(() => {
                const orig = button.innerHTML;
                button.innerHTML = '<i class="fa fa-check"></i> Tersalin';
                setTimeout(() => { button.innerHTML = orig; }, 1800);
            });
        }

        function resendNotification(id) {
            Swal.fire({
                title: 'Kirim Ulang Notifikasi?',
                text: 'Apakah Anda yakin ingin mengirim ulang link kuesioner ke supervisor?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal',
                customClass: { popup: 'swal-modern', confirmButton: 'btn-modern btn-modern-primary', cancelButton: 'btn-modern btn-modern-secondary' },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}".replace(':id', id);
                }
            });
        }

        function extendExpiry(id) {
            Swal.fire({
                title: 'Perpanjang Masa Berlaku?',
                text: 'Link akses kuesioner akan diperpanjang 7 hari dari sekarang.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Perpanjang',
                cancelButtonText: 'Batal',
                customClass: { popup: 'swal-modern', confirmButton: 'btn-modern btn-modern-primary', cancelButton: 'btn-modern btn-modern-secondary' },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/supervisor-questionnaire/${id}/extend-expiry`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        Swal.fire(data.success ? 'Berhasil!' : 'Gagal!', data.message, data.success ? 'success' : 'error')
                            .then(() => { if (data.success) location.reload(); });
                    });
                }
            });
        }

        function deleteQuestionnaire(id) {
            Swal.fire({
                title: 'Hapus Data Survei?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: { popup: 'swal-modern', confirmButton: 'btn-modern btn-modern-danger', cancelButton: 'btn-modern btn-modern-secondary' },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('admin.supervisor-questionnaire.destroy', ':id') }}".replace(':id', id);
                    form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
