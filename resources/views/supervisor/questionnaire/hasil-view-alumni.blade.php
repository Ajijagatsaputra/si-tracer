@extends('layout')

@section('title', 'Evaluasi Atasan - Tracer Study TI UHN')

@section('content')
<main id="main-container">
    <div class="content content-full">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="fa fa-home me-1"></i> Dashboard</a>
            <span class="sep">&rsaquo;</span>
            <span>Tracer Study</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Evaluasi Atasan</span>
        </div>

        @if (!$tracerPengguna)
            <!-- Empty State jika belum ada data survei atasan -->
            <div class="py-5 text-center akila-detail-card">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                    style="width: 68px; height: 68px; background: #eff6ff; color: #2563eb; font-size: 1.65rem;">
                    <i class="fa fa-user-tie"></i>
                </div>
                <h4 class="mb-2 fw-bold text-dark">Data Evaluasi Atasan Belum Tersedia</h4>
                <p class="mx-auto mb-4 text-muted" style="max-width: 540px; font-size: 0.9rem;">
                    Survei evaluasi pengguna lulusan dibuat secara otomatis ketika Anda mengisi kuesioner Tracer Study dengan status <strong>Bekerja</strong> dan melengkapi kontak atasan/perusahaan.
                </p>
                <div class="flex-wrap gap-2 d-flex justify-content-center">
                    <a href="{{ route('dashboard') }}" class="btn-akila-outline">
                        <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                    @if (!empty($tracerStudy))
                        <a href="{{ route('new-tracer.edit') }}" class="btn-akila-dark">
                            <i class="fa fa-edit"></i> Perbarui Data Tracer Study
                        </a>
                    @else
                        <a href="{{ route('new-tracer.index') }}" class="btn-akila-dark">
                            <i class="fa fa-clipboard-list"></i> Isi Tracer Study Sekarang
                        </a>
                    @endif
                </div>
            </div>
        @else
            @php
                $indicators = [
                    'integritas' => 'Integritas & Etika Profesi',
                    'keahlian' => 'Keahlian Bidang Ilmu (IT)',
                    'kemampuan' => 'Kemampuan Bahasa Inggris',
                    'penguasaan' => 'Penguasaan Teknologi Informasi',
                    'komunikasi' => 'Kemampuan Komunikasi',
                    'kerja_tim' => 'Kerjasama Tim (Teamwork)',
                    'pengembangan' => 'Pengembangan Diri',
                ];

                $filledScores = [];
                foreach ($indicators as $field => $label) {
                    if ($tracerPengguna->$field !== null && (int) $tracerPengguna->$field > 0) {
                        $filledScores[$field] = (int) $tracerPengguna->$field;
                    }
                }

                $filledCount = count($filledScores);
                $hasEvaluationScores = $tracerPengguna->status_pengisian === 'completed' || $filledCount > 0;
                $progressPct = round(($filledCount / 7) * 100);
                $avgScore = $filledCount > 0 ? round(array_sum($filledScores) / $filledCount, 2) : null;

                $expiryDate = $tracerPengguna->expires_at ?? $tracerPengguna->expired_at;
                $isExpired = $tracerPengguna->status_pengisian === 'expired'
                    || (!$hasEvaluationScores && $expiryDate && \Carbon\Carbon::parse($expiryDate)->isPast());

                if ($hasEvaluationScores) {
                    $statusLabel = 'Selesai Diisi';
                    $statusPillClass = 'akila-status-dot-badge st-green';
                } elseif ($isExpired) {
                    $statusLabel = 'Kadaluarsa';
                    $statusPillClass = 'akila-status-dot-badge st-red';
                } elseif ($tracerPengguna->status_pengisian === 'sent') {
                    $statusLabel = 'Terkirim ke Atasan';
                    $statusPillClass = 'akila-status-dot-badge st-blue';
                } else {
                    $statusLabel = 'Menunggu Pengisian';
                    $statusPillClass = 'akila-status-dot-badge st-amber';
                }

                $questionnaireUrl = $tracerPengguna->getQuestionnaireUrl();
                $waNumber = preg_replace('/[^0-9]/', '', (string) $tracerPengguna->wa_atasan);
                if (str_starts_with($waNumber, '0')) {
                    $waNumber = '62' . substr($waNumber, 1);
                }
                $waMessage = rawurlencode("Yth. Bapak/Ibu {$tracerPengguna->nama_atasan},\nMohon kesediaannya untuk mengisi Survei Evaluasi Kinerja Alumni ({$tracerPengguna->nama_alumni}) dari Universitas Harkat Negeri melalui tautan berikut:\n{$questionnaireUrl}\n\nTerima kasih.");
            @endphp

            <!-- Top Summary Card (Akila Detail Style) -->
            <div class="akila-detail-card">
                <div class="akila-detail-top">
                    <div class="akila-detail-identity">
                        <div class="akila-detail-icon">
                            <i class="fa fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="akila-detail-title-row">
                                <h1 class="mb-0 akila-detail-title">{{ strtoupper($tracerPengguna->nama_alumni ?: Auth::user()->username) }}</h1>
                                <span class="{{ $statusPillClass }}">
                                    <span class="dot"></span>
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            <p class="mb-0 text-muted small">
                                Evaluasi kinerja lulusan sebagai <strong>{{ $tracerPengguna->jabatan_alumni ?: '-' }}</strong> pada <strong>{{ $tracerPengguna->nama_perusahaan ?: '-' }}</strong>
                            </p>
                        </div>
                    </div>

                    <div class="akila-header-actions">
                        <a href="{{ route('new-tracer.edit') }}" class="btn-akila-outline">
                            <i class="fa fa-edit"></i> Perbarui Info Kerja
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn-akila-dark">
                            <i class="fa fa-arrow-left"></i> Dashboard
                        </a>
                    </div>
                </div>

                <!-- Stat Boxes -->
                <div class="akila-meta-grid">
                    <div class="akila-meta-box">
                        <div class="akila-meta-label">Supervisor / Penilai</div>
                        <div class="akila-meta-value">
                            <i class="fa fa-user text-warning"></i> {{ $tracerPengguna->nama_atasan ?: '-' }}
                        </div>
                    </div>

                    <div class="akila-meta-box">
                        <div class="akila-meta-label">Perusahaan</div>
                        <div class="akila-meta-value">
                            <i class="fa fa-building text-primary"></i> {{ $tracerPengguna->nama_perusahaan ?: '-' }}
                        </div>
                    </div>

                    <div class="akila-meta-box">
                        <div class="akila-meta-label">Progress Evaluasi</div>
                        <div class="akila-meta-value">
                            <i class="fa fa-chart-pie text-success"></i> {{ $filledCount }}/7 Indikator ({{ $progressPct }}%)
                        </div>
                    </div>

                    <div class="akila-meta-box">
                        <div class="akila-meta-label">{{ $hasEvaluationScores ? 'Tanggal Diisi' : 'Batas Pengisian' }}</div>
                        <div class="akila-meta-value">
                            <i class="fa fa-calendar-alt text-secondary"></i>
                            @if ($hasEvaluationScores && $tracerPengguna->tanggal_isi)
                                {{ \Carbon\Carbon::parse($tracerPengguna->tanggal_isi)->translatedFormat('d M Y') }}
                            @elseif ($expiryDate)
                                {{ \Carbon\Carbon::parse($expiryDate)->translatedFormat('d M Y') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    <div class="akila-meta-box">
                        <div class="akila-meta-label">Rata-rata Skor</div>
                        <div class="akila-meta-value">
                            <i class="fa fa-star text-warning"></i>
                            {{ $avgScore !== null ? number_format($avgScore, 2) . ' / 5.00' : 'Belum Dinilai' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Share Link Banner ketika atasan belum mengisi -->
            @if (!$hasEvaluationScores)
                <div class="akila-detail-card" style="border-left: 4px solid #2563eb;">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-7">
                            <div class="gap-3 d-flex align-items-start">
                                <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center"
                                    style="width: 42px; height: 42px; background: #eff6ff; color: #2563eb;">
                                    <i class="fa fa-link"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">Kuesioner Menunggu Pengisian Atasan</h6>
                                    <p class="mb-2 text-muted small">
                                        Supervisor Anda (<strong>{{ $tracerPengguna->nama_atasan ?: 'Atasan' }}</strong>) belum mengisi kuesioner evaluasi kinerja. Anda dapat menyalin atau mengirimkan tautan khusus di bawah ini kepada atasan Anda:
                                    </p>
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="supervisorShareUrl" class="form-control bg-light text-secondary"
                                            value="{{ $questionnaireUrl }}" readonly>
                                        <button type="button" class="btn btn-primary fw-semibold" id="btnCopySupervisorUrl">
                                            <i class="fa fa-copy me-1"></i> Salin Link
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            @if (!empty($waNumber))
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank"
                                    class="px-3 py-2 shadow-sm btn btn-success btn-sm rounded-pill fw-semibold">
                                    <i class="fab fa-whatsapp me-1"></i> Kirim Link via WhatsApp Atasan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Detail Informasi & Hasil Evaluasi -->
            <div class="row g-3">
                <!-- Kolom Kiri: Profil Alumni & Atasan -->
                <div class="col-lg-5">
                    <div class="mb-0 akila-detail-card h-100">
                        <h6 class="pb-2 mb-3 fw-bold text-dark border-bottom">
                            <i class="fa fa-id-card text-primary me-2"></i>Informasi Pekerjaan & Penilai
                        </h6>

                        <div class="mb-3">
                            <div class="mb-1 text-muted fs-xs text-uppercase fw-bold">Nama & Jabatan Alumni</div>
                            <div class="fw-semibold text-dark">{{ $tracerPengguna->nama_alumni ?: '-' }}</div>
                            <div class="text-muted small">{{ $tracerPengguna->jabatan_alumni ?: '-' }} &bull; Mulai Kerja: {{ $tracerPengguna->tanggal_mulai_kerja ? \Carbon\Carbon::parse($tracerPengguna->tanggal_mulai_kerja)->translatedFormat('d F Y') : '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="mb-1 text-muted fs-xs text-uppercase fw-bold">Perusahaan / Instansi</div>
                            <div class="fw-semibold text-dark">{{ $tracerPengguna->nama_perusahaan ?: '-' }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="mb-1 text-muted fs-xs text-uppercase fw-bold">Nama & Jabatan Atasan</div>
                            <div class="fw-semibold text-dark">{{ $tracerPengguna->nama_atasan ?: '-' }}</div>
                            <div class="text-muted small">{{ $tracerPengguna->jabatan_atasan ?: '-' }}{{ $tracerPengguna->nipy ? ' • NIPY: ' . $tracerPengguna->nipy : '' }}</div>
                        </div>

                        <div class="pt-2 row g-2 border-top">
                            <div class="col-sm-6">
                                <div class="mb-1 text-muted fs-xs text-uppercase fw-bold">Email Atasan</div>
                                <div class="small text-dark text-break">{{ $tracerPengguna->email_atasan ?: 'Tidak diisi' }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1 text-muted fs-xs text-uppercase fw-bold">WhatsApp Atasan</div>
                                <div class="small text-dark">{{ $tracerPengguna->wa_atasan ?: 'Tidak diisi' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Grafik & Skor Evaluasi -->
                <div class="col-lg-7">
                    <div class="mb-0 akila-detail-card h-100">
                        <div class="pb-2 mb-3 d-flex align-items-center justify-content-between border-bottom">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fa fa-chart-bar text-success me-2"></i>Hasil Penilaian Kompetensi (7 Indikator)
                            </h6>
                            @if ($avgScore !== null)
                                <span class="badge bg-primary rounded-pill">Rata-rata {{ number_format($avgScore, 2) }}/5</span>
                            @endif
                        </div>

                        @if ($hasEvaluationScores)
                            <div class="row g-3 align-items-center">
                                <div class="col-md-7">
                                    @foreach ($indicators as $field => $label)
                                        @php
                                            $val = (int) ($tracerPengguna->$field ?? 0);
                                            $pct = $val * 20;
                                            $barColor = $val >= 4 ? '#10b981' : ($val === 3 ? '#3b82f6' : '#f59e0b');
                                        @endphp
                                        <div class="mb-2">
                                            <div class="mb-1 d-flex justify-content-between align-items-center">
                                                <span class="small fw-semibold text-dark">{{ $label }}</span>
                                                <span class="fs-xs fw-bold" style="color: {{ $barColor }};">{{ $val }}/5</span>
                                            </div>
                                            <div class="progress rounded-pill" style="height: 7px; background: #f1f5f9;">
                                                <div class="progress-bar rounded-pill"
                                                    style="width: {{ $pct }}%; background-color: {{ $barColor }};"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-5">
                                    <div style="height: 230px;">
                                        <canvas id="evaluationChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            @php
                                $kesesuaianLabels = [
                                    'sangat_sesuai' => 'Sangat Sesuai',
                                    'sesuai' => 'Sesuai',
                                    'cukup_sesuai' => 'Cukup Sesuai',
                                    'kurang_sesuai' => 'Kurang Sesuai',
                                    'tidak_sesuai' => 'Tidak Sesuai',
                                ];
                                $kualitasLabels = [
                                    'sangat_baik' => 'Sangat Baik',
                                    'baik' => 'Baik',
                                    'cukup' => 'Cukup',
                                    'kurang' => 'Kurang',
                                    'sangat_kurang' => 'Sangat Kurang',
                                ];
                            @endphp

                            <div class="pt-3 mt-3 row g-2 border-top">
                                <div class="col-sm-6">
                                    <div class="p-2 border rounded-3 bg-light">
                                        <div class="text-muted fs-xs text-uppercase fw-bold">Kesesuaian Pendidikan</div>
                                        <div class="mt-1 fw-bold text-dark small">
                                            {{ $kesesuaianLabels[$tracerPengguna->kesesuaian_pendidikan_pekerjaan] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-2 border rounded-3 bg-light">
                                        <div class="text-muted fs-xs text-uppercase fw-bold">Penilaian Kualitas Lulusan</div>
                                        <div class="mt-1 fw-bold text-dark small">
                                            {{ $kualitasLabels[$tracerPengguna->kualitas_lulusan] ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if (!empty($tracerPengguna->saran_perbaikan))
                                <div class="p-3 mt-3 border rounded-3" style="background: #f8fafc;">
                                    <div class="mb-1 fs-xs fw-bold text-uppercase text-muted">
                                        <i class="fa fa-comment-dots text-primary me-1"></i> Masukan & Saran Atasan
                                    </div>
                                    <div class="small text-dark">{{ $tracerPengguna->saran_perbaikan }}</div>
                                </div>
                            @endif
                        @else
                            <div class="py-5 text-center">
                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                                    style="width: 56px; height: 56px; background: #f1f5f9; color: #64748b; font-size: 1.35rem;">
                                    <i class="fa fa-hourglass-half"></i>
                                </div>
                                <h6 class="mb-1 fw-bold text-dark">Belum Ada Skor Evaluasi</h6>
                                <p class="mx-auto mb-0 text-muted small" style="max-width: 380px;">
                                    Grafik dan rincian nilai kompetensi akan otomatis ditampilkan di halaman ini segera setelah supervisor menyelesaikan pengisian survei.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const copyBtn = document.getElementById('btnCopySupervisorUrl');
        const urlInput = document.getElementById('supervisorShareUrl');
        if (copyBtn && urlInput) {
            copyBtn.addEventListener('click', function () {
                navigator.clipboard.writeText(urlInput.value).then(function () {
                    const originalHtml = copyBtn.innerHTML;
                    copyBtn.innerHTML = '<i class="fa fa-check me-1"></i> Tersalin!';
                    copyBtn.classList.replace('btn-primary', 'btn-success');
                    setTimeout(function () {
                        copyBtn.innerHTML = originalHtml;
                        copyBtn.classList.replace('btn-success', 'btn-primary');
                    }, 2000);
                });
            });
        }

        const chartEl = document.getElementById('evaluationChart');
        @if (!empty($tracerPengguna) && ($tracerPengguna->status_pengisian === 'completed' || !empty($filledCount)))
        if (chartEl && typeof Chart !== 'undefined') {
            new Chart(chartEl.getContext('2d'), {
                type: 'radar',
                data: {
                    labels: ['Integritas', 'Keahlian IT', 'B. Inggris', 'Penguasaan TI', 'Komunikasi', 'Kerja Tim', 'Pengembangan'],
                    datasets: [{
                        label: 'Skor Evaluasi',
                        data: [
                            {{ (int) ($tracerPengguna->integritas ?? 0) }},
                            {{ (int) ($tracerPengguna->keahlian ?? 0) }},
                            {{ (int) ($tracerPengguna->kemampuan ?? 0) }},
                            {{ (int) ($tracerPengguna->penguasaan ?? 0) }},
                            {{ (int) ($tracerPengguna->komunikasi ?? 0) }},
                            {{ (int) ($tracerPengguna->kerja_tim ?? 0) }},
                            {{ (int) ($tracerPengguna->pengembangan ?? 0) }}
                        ],
                        backgroundColor: 'rgba(37, 99, 235, 0.16)',
                        borderColor: '#2563eb',
                        borderWidth: 2,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 5,
                            ticks: { stepSize: 1, display: false },
                            pointLabels: {
                                font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' },
                                color: '#475569'
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
        @endif
    });
</script>
@endpush
