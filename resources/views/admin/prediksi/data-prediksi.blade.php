@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="py-3 bg-body-light border-bottom">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="mb-0 h3 fw-bold text-primary">
                    <i class="fa fa-robot me-2"></i> Data Prediksi AI
                </h1>
                <p class="mb-0 text-muted fs-sm">Rekap aktivitas dan riwayat hasil prediksi (HistoryPrediksi).</p>
            </div>
            <div>
                {{-- <a href="{{ route('admin.prediksi.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a> --}}
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Statistik Utama -->
        <div class="mb-4 row g-3">
            <div class="col-md-3">
                <div class="text-white border-0 shadow-sm card card-body bg-gradient-primary gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $totalPredictions ?? 0 }}</div>
                            <div class="fs-sm">Total Prediksi</div>
                        </div>
                        <div><i class="opacity-50 fa fa-database fa-2x"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-white border-0 shadow-sm card card-body bg-gradient-success gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $todayPredictions ?? 0 }}</div>
                            <div class="fs-sm">Prediksi Hari Ini</div>
                        </div>
                        <div><i class="opacity-50 fa fa-calendar-day fa-2x"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="border-0 shadow-sm card card-body bg-gradient-warning text-dark gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $last7DaysPredictions ?? 0 }}</div>
                            <div class="fs-sm">7 Hari Terakhir</div>
                        </div>
                        <div><i class="opacity-50 fa fa-chart-line fa-2x"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-white border-0 shadow-sm card card-body bg-gradient-danger gradient-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-2 fw-bold">{{ $uniqueUsers ?? 0 }}</div>
                            <div class="fs-sm">Pengguna Unik</div>
                        </div>
                        <div><i class="opacity-50 fa fa-users fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Chart Prediksi 7 Hari -->
            <div class="col-lg-8">
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-chart-line me-2"></i> Prediksi per Hari (7 Hari)
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="prediksi7HariChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Distribusi Job Title -->
            <div class="col-lg-4">
                <div class="block shadow-sm block-rounded">
                    <div class="block-header block-header-default bg-light">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-briefcase me-2"></i> Hasil Rekomendasi Job Title
                        </h3>
                    </div>
                    <div class="block-content block-content-full">
                        <canvas id="jobTitleChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="mt-2 row g-4">
            <div class="col-12">
                <div class="block shadow-sm block-rounded">
                    <div
                        class="block-header block-header-default bg-light d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 block-title fw-semibold text-primary">
                            <i class="fa fa-list me-2"></i> Riwayat Prediksi Terbaru
                        </h3>
                        <span class="text-muted small">Menampilkan {{ isset($histories) ? $histories->count() : 0 }}
                            data</span>
                    </div>
                    <div class="block-content block-content-full">
                        @if (isset($histories) && $histories->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-middle table-borderless table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 22%">Alumni</th>
                                            <th style="width: 15%">Tanggal</th>
                                            <th>Ringkasan Hasil</th>
                                            <th class="text-center" style="width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($histories as $item)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">
                                                        {{ $item->alumni->nama_lengkap ?? 'Alumni #' . ($item->idAlumni ?? '-') }}
                                                    </div>
                                                    <div class="text-muted small">ID: {{ $item->idAlumni ?? '-' }}</div>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-primary">{{ optional($item->created_at)->format('d M Y H:i') }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $jobTitles = $item->extracted_job_titles ?? [];
                                                    @endphp
                                                    @if (count($jobTitles) > 0)
                                                        <div class="mb-2">
                                                            @foreach ($jobTitles as $title)
                                                                <span
                                                                    class="mb-1 badge bg-primary me-1">{{ $title }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    @php
                                                        $plain = trim(strip_tags($item->hasil ?? ''));
                                                        $excerpt = mb_strimwidth($plain, 0, 150, '...');
                                                    @endphp
                                                    <div class="text-muted small">{{ $excerpt }}</div>
                                                </td>

                                                <!-- Tambahan kolom aksi -->
                                                <td class="text-center">
                                                    <a href="{{ route('admin.prediksi.show', $item->id) }}"
                                                        class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip"
                                                        title="Lihat Detail">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $item->id }}" data-bs-toggle="tooltip"
                                                        title="Hapus Permanen">
                                                        <i class="fa fa-trash-alt"></i>
                                                    </button>

                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('admin.prediksi.destroy', $item->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <i class="mb-3 fa fa-info-circle fa-2x text-muted"></i>
                                <p class="mb-0 text-muted">Belum ada riwayat prediksi.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            if (confirm('Yakin ingin menghapus riwayat prediksi ini? Tindakan ini tidak bisa dibatalkan.')) {
                document.getElementById(`delete-form-${itemId}`).submit();
            }
        });
    });
            // Data dari controller (fallback jika tidak ada)
            const labels7 = @json($last7DaysLabels ?? []);
            const data7 = @json($last7DaysCounts ?? []);

            const jobLabels = @json($jobTitleLabels ?? []);
            const jobCounts = @json($jobTitleCounts ?? []);

            // Chart 1: Prediksi 7 Hari
            const c1 = document.getElementById('prediksi7HariChart');
            if (c1) {
                new Chart(c1.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels7,
                        datasets: [{
                            label: 'Jumlah Prediksi',
                            data: data7,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
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
                        }
                    }
                });
            }

            // Chart 2: Distribusi Job Title
            const c2 = document.getElementById('jobTitleChart');
            if (c2) {
                // Generate lebih banyak warna untuk top 10
                const colors = [
                    '#28a745', '#17a2b8', '#ffc107', '#fd7e14', '#dc3545',
                    '#6f42c1', '#20c997', '#e83e8c', '#6610f2', '#6c757d'
                ];
                new Chart(c2.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: jobLabels,
                        datasets: [{
                            label: 'Jumlah Rekomendasi',
                            data: jobCounts,
                            backgroundColor: colors.slice(0, jobLabels.length)
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(92deg, #31c7ef 40%, #38d9c3 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(92deg, #32d484 30%, #75e095 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(92deg, #ffed85 30%, #ffc371 100%) !important;
        }

        .bg-gradient-danger {
            background: linear-gradient(92deg, #ff6b6b 30%, #ee5a52 100%) !important;
        }

        .card {
            min-height: 85px;
            border-radius: 1.3rem;
        }
    </style>
@endsection
