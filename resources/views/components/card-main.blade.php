<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.3);
        --glass-shadow: rgba(0, 0, 0, 0.05);
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 var(--glass-shadow);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.1);
    }

    .status-hero {
        padding: 3rem 2rem;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 24px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .status-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.5);
        margin-bottom: 1rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .activity-item:hover {
        background: white;
        border-color: #3b82f6;
    }

    .activity-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .bg-soft-primary { background: #e0e7ff; color: #1e3a8a; }
    .bg-soft-success { background: #dcfce7; color: #15803d; }
    .bg-soft-warning { background: #fef9c3; color: #854d0e; }

    .chart-container {
        padding: 1.5rem;
    }

    .btn-premium {
        background: white;
        color: #1e3a8a;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }

    .btn-premium:hover {
        transform: scale(1.05);
        background: #f8fafc;
        color: #2563eb;
    }
</style>

<div class="container py-5">
    <!-- Messages -->
    @if (session('error') || session('success'))
        <div class="row mb-4">
            <div class="col-12">
                @if (session('error'))
                    <div class="alert alert-danger glass-card border-danger text-danger py-3 px-4">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success glass-card border-success text-success py-3 px-4">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Hero Status -->
        <div class="col-12">
            <div class="status-hero shadow-lg animate-fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="fw-bold mb-2">Halo, {{ auth()->user()->name }}!</h1>
                        <p class="opacity-75 fs-5">Selamat datang kembali di portal Tracer Study Alumni Teknik Informatika.</p>
                        
                        <div class="mt-4">
                            @if ($statusTracer === 'sudah')
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-white text-success rounded-circle p-2 me-3">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span class="fs-5 fw-medium">Status Anda: <span class="badge bg-success">Sudah Mengisi</span></span>
                                </div>
                                <a href="{{ route('new-tracer.show', auth()->user()->alumni->id) }}" class="btn btn-premium mt-2">
                                    <i class="fas fa-eye me-2"></i> Lihat Data Kuesioner
                                </a>
                            @else
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-white text-warning rounded-circle p-2 me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <span class="fs-5 fw-medium">Status Anda: <span class="badge bg-warning text-dark">Belum Mengisi</span></span>
                                </div>
                                <a href="{{ route('new-tracer.index') }}" class="btn btn-premium mt-2">
                                    <i class="fas fa-edit me-2"></i> Isi Kuesioner Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-center position-relative">
                        <i class="fas fa-user-graduate fa-10x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Grid -->
        <div class="col-lg-4">
            <div class="glass-card p-4 h-100">
                <h5 class="fw-bold mb-4">Akses Cepat</h5>
                
                <div class="activity-item">
                    <div class="activity-icon bg-soft-primary">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Kuesioner</h6>
                        <small class="text-muted">Update progres karir</small>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon bg-soft-success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Data Alumni</h6>
                        <small class="text-muted">Hubungan antar rekan</small>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon bg-soft-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Statistik</h6>
                        <small class="text-muted">Data serapan industri</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="col-lg-8">
            <div class="glass-card h-100">
                <div class="p-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Rekapitulasi Alumni</h5>
                    <span class="text-muted small">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                </div>
                <div class="chart-container">
                    <canvas id="rekapAlumniChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tahun = @json($tahun);
        const totalAlumni = @json($alumniData);
        const totalKuesioner = @json($kuisonerData);

        const ctx = document.getElementById('rekapAlumniChart').getContext('2d');
        
        // Gradient Colors
        const grad1 = ctx.createLinearGradient(0, 0, 0, 400);
        grad1.addColorStop(0, '#3b82f6');
        grad1.addColorStop(1, '#1e3a8a');

        const grad2 = ctx.createLinearGradient(0, 0, 0, 400);
        grad2.addColorStop(0, '#10b981');
        grad2.addColorStop(1, '#064e3b');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahun,
                datasets: [
                    {
                        label: 'Total Alumni',
                        data: totalAlumni,
                        backgroundColor: grad1,
                        borderRadius: 8,
                        barThickness: 20
                    },
                    {
                        label: 'Sudah Mengisi',
                        data: totalKuesioner,
                        backgroundColor: grad2,
                        borderRadius: 8,
                        barThickness: 20
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { usePointStyle: true, font: { weight: '600' } }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: false },
                        ticks: { precision: 0 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
