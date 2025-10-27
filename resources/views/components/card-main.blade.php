<div class="container py-4">
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
    <div class="row g-4">
        {{-- Aktivitas Alumni --}}
        <div class="col-lg-6 col-md-12">
            <div class="shadow-sm card h-100">
                <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                    <span>AKTIVITAS ALUMNI TERKINI</span>
                    <span class="text-muted small">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="card-body">
                    <table class="table mb-0 table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>FITUR</th>
                                <th>AKTIVITAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Kuesioner</td>
                                <td>Mengisi Kuesioner Tracer Study</td>
                            </tr>
                            <tr>
                                <td>Data Alumni</td>
                                <td>Melihat Data Alumni yang Sudah Melakukan Tracer Study</td>
                            </tr>
                            <tr>
                                <td>Total Alumni</td>
                                <td>Melihat Total Alumni yang Sudah Melakukan Tracer Study per Tahun Lulus</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Status Pengisian Tracer Study --}}
        <div class="col-lg-6 col-md-12">
            <div class="shadow-sm card h-100">
                <div class="text-center card-header fw-bold">
                    STATUS PENGISIAN TRACER STUDY
                </div>
                <div class="text-center card-body d-flex flex-column justify-content-center align-items-center">
                    @if ($statusTracer === 'sudah')
                        <i class="mb-3 fa fa-check-circle fa-3x text-success"></i>
                        <h5 class="fw-bold text-success">Sudah Mengisi</h5>
                        <p class="mb-0 text-muted">Terima kasih telah berpartisipasi dalam tracer study.</p>
                        <div class="mt-3 dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Lihat Jawaban
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('new-tracer.show', auth()->user()->alumni->id) }}">Tracer Study</a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <i class="mb-3 fa fa-times-circle fa-3x text-danger"></i>
                        <h5 class="fw-bold text-danger">Belum Mengisi</h5>
                        <p class="mb-2 text-muted">Silakan lengkapi kuesioner tracer study Anda.</p>
                        <a href="{{ route('new-tracer.index') }}" class="btn btn-outline-success btn-sm">Isi Sekarang</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Data Rekap Alumni (Bar Chart) --}}
        <div class="col-12">
            <div class="mt-2 shadow-sm card">
                <div class="card-header fw-bold">Data Rekap Alumni</div>
                <div class="card-body">
                    <canvas id="rekapAlumniChart" style="max-height: 420px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const tahun = @json($tahun);
    const totalAlumni = @json($alumniData);
    const totalKuesioner = @json($kuisonerData);

    const ctxBar = document.getElementById('rekapAlumniChart').getContext('2d');

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: tahun,
            datasets: [
                {
                    label: 'Total Alumni',
                    data: totalAlumni,
                    backgroundColor: 'rgba(66, 133, 244, 0.8)'
                },
                {
                    label: 'Mengisi Kuesioner',
                    data: totalKuesioner,
                    backgroundColor: 'rgba(0, 200, 180, 0.8)'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
</script>
