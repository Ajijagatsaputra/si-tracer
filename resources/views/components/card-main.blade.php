@php
    $totalAlumni = array_sum($alumniData);
    $totalKuesioner = array_sum($kuisonerData);
    $completionRate = $totalAlumni > 0 ? round(($totalKuesioner / $totalAlumni) * 100, 1) : 0;
    $alumniName = auth()->user()->alumni->nama_lengkap ?? auth()->user()->username;
    $alumniId = optional(auth()->user()->alumni)->id;
@endphp

<style>
    /* Premium Dashboard System */
    .dashboard-container {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .hero-premium {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.4);
    }

    .hero-premium::before {
        content: '';
        position: absolute;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
        top: -80px;
        right: -40px;
        pointer-events: none;
    }

    .hero-premium::after {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        bottom: -40px;
        left: -40px;
        pointer-events: none;
    }

    .glass-card-premium {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 30px rgba(0, 0, 0, 0.06);
        border-color: rgba(59, 130, 246, 0.3);
    }

    /* Pulse effects */
    .pulse-badge-warning {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
        font-weight: 600;
        animation: pulse-orange 2s infinite;
    }

    .pulse-badge-success {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-weight: 600;
        animation: pulse-green 2s infinite;
    }

    @keyframes pulse-orange {
        0% {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(245, 158, 11, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(245, 158, 11, 0);
        }
    }

    @keyframes pulse-green {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .btn-premium-glass {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        color: white !important;
        border: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-premium-glass:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.35);
        transform: translateY(-2px);
    }

    /* Menu Items */
    .menu-item-card {
        display: flex;
        align-items: center;
        padding: 1.15rem;
        border-radius: 16px;
        background: rgba(248, 250, 252, 0.85);
        border: 1px solid #f1f5f9;
        text-decoration: none !important;
        color: inherit !important;
        transition: all 0.2s ease-in-out;
    }

    .menu-item-card:hover {
        background: white;
        transform: translateX(4px);
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .menu-item-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.25rem;
        font-size: 1.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .menu-item-card:hover .menu-item-icon {
        transform: scale(1.1) rotate(3deg);
    }

    .icon-primary {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .icon-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .icon-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .icon-info {
        background: rgba(6, 182, 212, 0.1);
        color: #06b6d4;
    }

    /* Stats Widget */
    .stat-mini-card {
        padding: 1.15rem;
        border-radius: 18px;
        background: white;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.01);
    }

    .stat-mini-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 1rem;
    }

    .text-indigo {
        color: #4f46e5;
    }

    .bg-indigo-light {
        background-color: rgba(79, 70, 229, 0.08);
    }
</style>

<div class="container py-4 dashboard-container">
    <!-- Messages -->
    @if (session('error') || session('success'))
        <div class="row mb-4">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger glass-card-premium border-danger text-danger py-3 px-4">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success glass-card-premium border-success text-success py-3 px-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Hero Status Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-premium p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        @if(auth()->user()->alumni)
                            <span
                                class="badge bg-white-10 text-white rounded-pill px-3 py-2 mb-3 border border-white-15 fs-xs">
                                <i class="fa fa-graduation-cap me-1"></i> NIM: {{ auth()->user()->alumni->nim }} • Angkatan
                                {{ auth()->user()->alumni->tahun_masuk }}
                            </span>
                        @endif
                        <h1 class="fw-bold mb-2 text-white">Halo, {{ $alumniName }}!</h1>
                        <p class="opacity-80 fs-5 text-white mb-4">Selamat datang kembali di portal Tracer Study Alumni
                            Teknik Informatika Universitas Harkat Negeri.</p>

                        <div class="mt-2">
                            @if ($statusTracer === 'sudah')
                                <div class="d-flex align-items-center mb-3">
                                    <span class="fs-6 fw-medium text-white me-2">Status Anda:</span>
                                    <span class="badge pulse-badge-success px-3 py-2 rounded-pill fs-xs">
                                        <i class="fas fa-check-circle me-1"></i> Sudah Mengisi Kuesioner
                                    </span>
                                </div>
                                @if ($alumniId)
                                    <a href="{{ route('new-tracer.show', $alumniId) }}"
                                        class="btn btn-premium-glass rounded-pill px-4 py-2 mt-2">
                                        <i class="fas fa-eye me-2"></i> Lihat Data Kuesioner
                                    </a>
                                @endif
                            @else
                                <div class="d-flex align-items-center mb-3">
                                    <span class="fs-6 fw-medium text-white me-2">Status Anda:</span>
                                    <span class="badge pulse-badge-warning px-3 py-2 rounded-pill fs-xs">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Belum Mengisi Kuesioner
                                    </span>
                                </div>
                                <a href="{{ route('new-tracer.index') }}"
                                    class="btn btn-premium-glass rounded-pill px-4 py-2 mt-2">
                                    <i class="fas fa-edit me-2"></i> Isi Kuesioner Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-center position-relative">
                        <i class="fas fa-user-graduate fa-10x text-white opacity-10 animate-float"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon bg-indigo-light text-indigo">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 fs-4">{{ $totalAlumni }}</h3>
                    <p class="text-muted small mb-0">Total Alumni Terdata</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon bg-success-light text-success">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 fs-4">{{ $totalKuesioner }}</h3>
                    <p class="text-muted small mb-0">Kuesioner Pengisian Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-mini-card">
                <div class="stat-mini-icon bg-warning-light text-warning">
                    <i class="fas fa-percentage"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 fs-4">{{ $completionRate }}%</h3>
                    <p class="text-muted small mb-0">Tingkat Partisipasi Alumni</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid Content -->
    <div class="row g-4">
        <!-- Akses Cepat Sidebar -->
        <div class="col-lg-4">
            <div class="glass-card-premium p-4 h-100 bg-white">
                <h5 class="fw-bold mb-4 text-dark">
                    <i class="fas fa-compass text-primary me-2"></i> Akses Cepat
                </h5>

                <a href="{{ route('new-tracer.index') }}" class="menu-item-card mb-3">
                    <div class="menu-item-icon icon-success">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Isi Kuesioner</h6>
                        <small class="text-muted">Partisipasi Tracer Study Alumni</small>
                    </div>
                </a>

                <a href="{{ route('profile.cv') }}" class="menu-item-card mb-3">
                    <div class="menu-item-icon icon-primary">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Resume & CV ATS</h6>
                        <small class="text-muted">Cetak CV ATS Didukung AI</small>
                    </div>
                </a>

                <a href="{{ route('alumni.loker.index') }}" class="menu-item-card mb-3">
                    <div class="menu-item-icon icon-info">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Riwayat Lamaran Saya</h6>
                        <small class="text-muted">Pantau status lamaran kerja Anda</small>
                    </div>
                </a>

                <a href="{{ route('profile') }}" class="menu-item-card">
                    <div class="menu-item-icon icon-warning">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Kelola Profil</h6>
                        <small class="text-muted">Edit data diri & biodata alumni</small>
                    </div>
                </a>
            </div>
        </div>

        <!-- Rekapitulasi Chart -->
        <div class="col-lg-8">
            <div class="glass-card-premium h-100 bg-white p-4">
                <div class="chart-header d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="fas fa-chart-bar text-primary me-2"></i> Rekapitulasi Pengisian
                    </h5>
                    <span class="badge bg-light text-muted border px-3 py-2 rounded-pill fs-xs">
                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="chart-container" style="position: relative; height:320px; width:100%">
                    <canvas id="rekapAlumniChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tahun = @json($tahun);
        const totalAlumni = @json($alumniData);
        const totalKuesioner = @json($kuisonerData);

        const ctx = document.getElementById('rekapAlumniChart').getContext('2d');

        // Gradient Colors for Chart
        const grad1 = ctx.createLinearGradient(0, 0, 0, 400);
        grad1.addColorStop(0, '#3b82f6');
        grad1.addColorStop(1, '#1d4ed8');

        const grad2 = ctx.createLinearGradient(0, 0, 0, 400);
        grad2.addColorStop(0, '#10b981');
        grad2.addColorStop(1, '#047857');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahun,
                datasets: [
                    {
                        label: 'Total Alumni',
                        data: totalAlumni,
                        backgroundColor: grad1,
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    {
                        label: 'Sudah Mengisi',
                        data: totalKuesioner,
                        backgroundColor: grad2,
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: {
                                weight: '600',
                                family: 'Inter'
                            }
                        }
                    },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 13, weight: '700', family: 'Inter' },
                        bodyFont: { size: 12, family: 'Inter' },
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(241, 245, 249, 1)',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            color: '#64748b',
                            font: { family: 'Inter', size: 11 }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { family: 'Inter', size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>