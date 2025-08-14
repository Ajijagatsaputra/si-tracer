@extends('layout')

@section('content')
@include('components.navbar')

<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between p-3 rounded shadow-sm bg-secondary">
                <div>
                    <h2 class="fw-bold text-white mb-1">
                        <i class="fas fa-chart-bar me-2"></i>Hasil Kuesioner Supervisor
                    </h2>
                    <div class="text-white-50">Evaluasi kinerja alumni berdasarkan penilaian atasan</div>
                </div>
                <a href="{{ route('home') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Informasi Alumni -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-secondary text-white rounded-top">
                    <i class="fas fa-user me-2"></i>Informasi Alumni
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 col-md-4">Nama Alumni</dt>
                        <dd class="col-7 col-md-8">{{ $tracerPengguna->nama_alumni }}</dd>
                        <dt class="col-5 col-md-4">Jabatan Alumni</dt>
                        <dd class="col-7 col-md-8">{{ $tracerPengguna->jabatan_alumni }}</dd>
                        <dt class="col-5 col-md-4">Nama Perusahaan</dt>
                        <dd class="col-7 col-md-8">{{ $tracerPengguna->nama_perusahaan }}</dd>
                        <dt class="col-5 col-md-4">Tanggal Mulai Kerja</dt>
                        <dd class="col-7 col-md-8">
                            {{ $tracerPengguna->tanggal_mulai_kerja ? \Carbon\Carbon::parse($tracerPengguna->tanggal_mulai_kerja)->format('d-m-Y') : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <!-- Informasi Atasan -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-secondary text-white rounded-top">
                    <i class="fas fa-user-tie me-2"></i>Informasi Atasan
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 col-md-4">Nama Atasan</dt>
                        <dd class="col-7 col-md-8">{{ $tracerPengguna->nama_atasan }}</dd>
                        <dt class="col-5 col-md-4">Jabatan Atasan</dt>
                        <dd class="col-7 col-md-8">{{ $tracerPengguna->jabatan_atasan }}</dd>
                        <dt class="col-5 col-md-4">Email Atasan</dt>
                        <dd class="col-7 col-md-8">
                            @if($tracerPengguna->email_atasan)
                                <i class=""></i>{{ $tracerPengguna->email_atasan }}
                            @else
                                <span class="text-muted">Tidak ada email</span>
                            @endif
                        </dd>
                        <dt class="col-5 col-md-4">WhatsApp Atasan</dt>
                        <dd class="col-7 col-md-8">
                            @if($tracerPengguna->wa_atasan)
                                <i class=""></i>{{ $tracerPengguna->wa_atasan }}
                            @else
                                <span class="text-muted">Tidak ada WhatsApp</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Kuesioner -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-secondary text-white rounded-top">
                    <i class="fas fa-check-circle me-2"></i>Status Pengisian
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 col-md-4">Status</dt>
                        <dd class="col-7 col-md-8">
                            @if($tracerPengguna->status_pengisian == 'completed')
                                <span class="text-dark fs-6">Selesai</span>
                            @else
                                <span class="badge bg-warning text-dark fs-6">{{ ucfirst($tracerPengguna->status_pengisian) }}</span>
                            @endif
                        </dd>
                        <dt class="col-5 col-md-4">Tanggal Pengisian</dt>
                        <dd class="col-7 col-md-8">
                            {{ $tracerPengguna->tanggal_isi ? \Carbon\Carbon::parse($tracerPengguna->tanggal_isi)->format('d-m-Y H:i:s') : '-' }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Hasil Evaluasi -->
    <div class="row mt-4">
        <div class="col-12">
            @if($tracerPengguna->status_pengisian == 'completed')
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white rounded-top">
                    <i class="fas fa-star me-2"></i>Hasil Evaluasi Kinerja
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Evaluasi Kinerja -->
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3">
                                    <i class="fas fa-chart-line me-2"></i>Evaluasi Kinerja Alumni
                                </h6>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        @php
                                            $aspek = [
                                                'integritas' => 'Integritas',
                                                'keahlian' => 'Keahlian',
                                                'kemampuan' => 'Kemampuan',
                                                'penguasaan' => 'Penguasaan',
                                                'komunikasi' => 'Komunikasi',
                                                'kerja_tim' => 'Kerja Tim',
                                                'pengembangan' => 'Pengembangan'
                                            ];
                                        @endphp
                                        @foreach($aspek as $key => $label)
                                        <tr>
                                            <td class="align-middle" style="width: 40%;">{{ $label }}</td>
                                            <td class="align-middle" style="width: 40%;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star {{ $i <= ($tracerPengguna->$key ?? 0) ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </td>
                                            <td class="align-middle" style="width: 20%;">
                                                <span class="badge bg-primary">{{ $tracerPengguna->$key ?? '-' }}/5</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Evaluasi Kesesuaian Pendidikan & Kualitas Lulusan -->
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h6 class="fw-semibold text-dark mb-3">
                                    <i class="fas fa-graduation-cap me-2"></i>Evaluasi Kesesuaian Pendidikan
                                </h6>
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="width: 60%;">Kesesuaian Pendidikan dengan Pekerjaan</td>
                                            <td>
                                                @if($tracerPengguna->kesesuaian_pendidikan_pekerjaan)
                                                    @php
                                                        $kesesuaianLabels = [
                                                            'sangat_sesuai' => 'Sangat Sesuai',
                                                            'sesuai' => 'Sesuai',
                                                            'cukup_sesuai' => 'Cukup Sesuai',
                                                            'kurang_sesuai' => 'Kurang Sesuai',
                                                            'tidak_sesuai' => 'Tidak Sesuai'
                                                        ];
                                                    @endphp
                                                    <span class="badge text-dark fs-6">
                                                        {{ $kesesuaianLabels[$tracerPengguna->kesesuaian_pendidikan_pekerjaan] }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kualitas Lulusan</td>
                                            <td>
                                                @if($tracerPengguna->kualitas_lulusan)
                                                    @php
                                                        $kualitasLabels = [
                                                            'sangat_baik' => 'Sangat Baik',
                                                            'baik' => 'Baik',
                                                            'cukup' => 'Cukup',
                                                            'kurang' => 'Kurang',
                                                            'sangat_kurang' => 'Sangat Kurang'
                                                        ];

                                                    @endphp
                                                    <span class="badge text-dark fs-6">
                                                        {{ $kualitasLabels[$tracerPengguna->kualitas_lulusan] }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Saran Perbaikan -->
                    @if($tracerPengguna->saran_perbaikan)
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-light shadow-sm">
                                <div class="fw-semibold mb-1">
                                    <i class="fas fa-comment me-2"></i>Saran Perbaikan
                                </div>
                                <div>{{ $tracerPengguna->saran_perbaikan }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Chart Evaluasi & Ringkasan -->
                    <div class="row align-items-stretch">
                        <div class="col-lg-8 mb-3 mb-lg-0">
                            <div class="bg-light rounded p-3 h-100 d-flex flex-column justify-content-center">
                                <h6 class="fw-semibold text-dark mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>Grafik Evaluasi Kinerja
                                </h6>
                                <div style="height: 320px;">
                                    <canvas id="evaluationChart" style="max-height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="bg-light rounded p-3 h-100">
                                <h6 class="fw-semibold mb-2">Ringkasan Skor</h6>
                                @php
                                    $scores = [
                                        'integritas' => $tracerPengguna->integritas,
                                        'keahlian' => $tracerPengguna->keahlian,
                                        'kemampuan' => $tracerPengguna->kemampuan,
                                        'penguasaan' => $tracerPengguna->penguasaan,
                                        'komunikasi' => $tracerPengguna->komunikasi,
                                        'kerja_tim' => $tracerPengguna->kerja_tim,
                                        'pengembangan' => $tracerPengguna->pengembangan
                                    ];
                                    $nonZeroScores = array_filter($scores, function($score) {
                                        return $score > 0;
                                    });
                                    $labels = [
                                        'integritas' => 'Integritas',
                                        'keahlian' => 'Keahlian',
                                        'kemampuan' => 'Kemampuan',
                                        'penguasaan' => 'Penguasaan',
                                        'komunikasi' => 'Komunikasi',
                                        'kerja_tim' => 'Kerja Tim',
                                        'pengembangan' => 'Pengembangan'
                                    ];
                                @endphp
                                <div class="mb-2">
                                    <small class="text-muted">Skor Tertinggi:</small><br>
                                    <span class="badge bg-success fs-6">
                                        @if (!empty($nonZeroScores))
                                            @php
                                                $maxScore = max($nonZeroScores);
                                                $maxKey = array_search($maxScore, $nonZeroScores);
                                            @endphp
                                            {{ $labels[$maxKey] . ' (' . $maxScore . '/5)' }}
                                        @else
                                            Belum ada data
                                        @endif
                                    </span>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Skor Terendah:</small><br>
                                    <span class="badge bg-warning text-dark fs-6">
                                        @if (!empty($nonZeroScores))
                                            @php
                                                $minScore = min($nonZeroScores);
                                                $minKey = array_search($minScore, $nonZeroScores);
                                            @endphp
                                            {{ $labels[$minKey] . ' (' . $minScore . '/5)' }}
                                        @else
                                            Belum ada data
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <small class="text-muted">Rata-rata:</small><br>
                                    <span class="badge bg-primary fs-6">
                                        @if (!empty($nonZeroScores))
                                            {{ number_format(array_sum($nonZeroScores) / count($nonZeroScores), 2) . '/5' }}
                                        @else
                                            0.00/5
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Pesan jika belum diisi -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-secondary text-white rounded-top">
                    <i class="fas fa-info-circle me-2"></i>Status Kuesioner
                </div>
                <div class="card-body text-center py-4">
                    <i class="fa fa-file-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">
                        @if($tracerPengguna->status_pengisian == 'pending')
                            Kuesioner belum diisi oleh supervisor.
                        @elseif($tracerPengguna->status_pengisian == 'expired')
                            Link kuesioner sudah kadaluarsa.
                        @else
                            Kuesioner belum tersedia untuk diisi.
                        @endif
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .card-header {
        border-bottom: none;
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .table-borderless > :not(caption) > * > * {
        border-bottom-width: 0;
    }
    .fa-star {
        font-size: 1.1em;
    }
    .badge {
        font-size: 0.95em;
        font-weight: 500;
    }
    .alert-light {
        background: #f8f9fa;
    }
    @media (max-width: 767.98px) {
        .card-header {
            font-size: 1rem;
        }
        .badge {
            font-size: 0.85em;
        }
    }
</style>

@if($tracerPengguna->status_pengisian == 'completed')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('evaluationChart').getContext('2d');
    const data = {
        labels: ['Integritas', 'Keahlian', 'Kemampuan', 'Penguasaan', 'Komunikasi', 'Kerja Tim', 'Pengembangan'],
        datasets: [{
            label: 'Skor Evaluasi',
            data: [
                {{ $tracerPengguna->integritas ?? 0 }},
                {{ $tracerPengguna->keahlian ?? 0 }},
                {{ $tracerPengguna->kemampuan ?? 0 }},
                {{ $tracerPengguna->penguasaan ?? 0 }},
                {{ $tracerPengguna->komunikasi ?? 0 }},
                {{ $tracerPengguna->kerja_tim ?? 0 }},
                {{ $tracerPengguna->pengembangan ?? 0 }}
            ],
            backgroundColor: 'rgba(54, 162, 235, 0.15)',
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
                    },
                    pointLabels: {
                        font: {
                            size: 14
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
</script>
@endif
@endsection
