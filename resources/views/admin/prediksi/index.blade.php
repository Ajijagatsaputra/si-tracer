@extends('layouts.admin')

@section('content')
    <!-- Premium Glassmorphic Hero -->
    <div class="card card-modern border-0 shadow-lg mb-4 overflow-hidden mx-4 mt-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 position-relative" style="z-index: 2;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-white-20 text-white me-3" style="width: 50px; height: 50px;">
                            <i class="fa fa-robot fa-lg"></i>
                        </div>
                        <h1 class="h2 fw-bold text-white mb-0">Hasil Prediksi Karier</h1>
                    </div>
                    <p class="lead text-white-50 mb-0">Analisis kesesuaian antara latar belakang pendidikan dengan karir profesional alumni.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 position-relative" style="z-index: 2;">
                    <a href="{{ route('admin.prediction.dashboard') }}" class="btn btn-lg btn-white rounded-pill px-4 shadow-sm hover-scale">
                        <i class="fa fa-chart-line me-2 text-primary"></i> Dashboard AI
                    </a>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="position-absolute top-0 end-0 p-5 mt-n5 me-n5 opacity-10">
                <i class="fa fa-brain fa-10x text-white"></i>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="content content-full">
        <!-- Modern Stats Grid -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-primary-light text-primary">
                                <i class="fa fa-database fa-lg"></i>
                            </div>
                            <span class="badge bg-primary-light text-primary rounded-pill px-2 py-0 fs-xs border border-primary-10">Total</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $totalPredictions }}</h3>
                        <p class="text-muted small mb-0">Total Data Prediksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-success-light text-success">
                                <i class="fa fa-check-circle fa-lg"></i>
                            </div>
                            <span class="badge bg-success-light text-success rounded-pill px-2 py-0 fs-xs border border-success-10">Match</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $matchPredictions }}</h3>
                        <p class="text-muted small mb-0">Prediksi Karier Sesuai</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-danger-light text-danger">
                                <i class="fa fa-times-circle fa-lg"></i>
                            </div>
                            <span class="badge bg-danger-light text-danger rounded-pill px-2 py-0 fs-xs border border-danger-10">Mismatch</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $notMatchPredictions }}</h3>
                        <p class="text-muted small mb-0">Karir Tidak Sesuai Prodi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100 stat-hover-effect overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="icon-circle bg-warning-light text-warning">
                                <i class="fa fa-hourglass-half fa-lg"></i>
                            </div>
                            <span class="badge bg-warning-light text-warning rounded-pill px-2 py-0 fs-xs border border-warning-10">Verif</span>
                        </div>
                        <h3 class="display-6 fw-bold text-dark mb-1 stat-counter">{{ $underReview }}</h3>
                        <p class="text-muted small mb-0">Dalam Proses Verifikasi</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Riwayat Prediksi Table Section -->
        <div class="card card-modern border-0 shadow-sm">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-circle bg-primary-light text-primary me-3" style="width: 40px; height: 40px;">
                        <i class="fa fa-table"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0">Tabel Hasil Prediksi Karier</h5>
                </div>
                <span class="badge bg-light text-primary rounded-pill px-3 py-2 border">Total: {{ $predictions->total() }} Data</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table align-middle table-hover js-dataTable-full w-100 border-0">
                        <thead>
                            <tr class="text-uppercase fs-xs fw-bold text-muted bg-light border-0">
                                <th class="text-center border-0 py-3" style="width: 60px;">#</th>
                                <th class="border-0 py-3">Nama Alumni</th>
                                <th class="border-0 py-3">Program Studi</th>
                                <th class="border-0 py-3">Prediksi Karier</th>
                                <th class="border-0 py-3">Akurasi</th>
                                <th class="border-0 py-3">Status</th>
                                <th class="border-0 py-3">Waktu</th>
                                <th class="text-center border-0 py-3" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-0">
                            @foreach ($predictions as $index => $item)
                                <tr class="hover-translate-y transition-all">
                                    <td class="text-center fw-medium text-muted border-0">{{ $index + 1 }}</td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle-sm bg-primary-light text-primary fw-bold me-2">
                                                {{ substr($item->nama_alumni, 0, 1) }}
                                            </div>
                                            <div class="fw-bold text-dark">{{ $item->nama_alumni }}</div>
                                        </div>
                                    </td>
                                    <td class="small border-0">{{ $item->prodi }}</td>
                                    <td class="border-0"><span class="fw-medium text-primary">{{ $item->hasil_prediksi }}</span></td>
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 me-2" style="min-width: 60px;">
                                                <div class="progress rounded-pill" style="height: 6px;">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $item->skor_akurasi }}%"></div>
                                                </div>
                                            </div>
                                            <span class="small fw-bold">{{ number_format($item->skor_akurasi, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td class="border-0">
                                        @if ($item->status == 'match')
                                            <span class="badge bg-success-light text-success rounded-pill px-2 py-1 border border-success-10 fs-xs">
                                                <i class="fa fa-check me-1"></i> Sesuai
                                            </span>
                                        @elseif ($item->status == 'not_match')
                                            <span class="badge bg-danger-light text-danger rounded-pill px-2 py-1 border border-danger-10 fs-xs">
                                                <i class="fa fa-times me-1"></i> Tidak Sesuai
                                            </span>
                                        @elseif ($item->status == 'pending')
                                            <span class="badge bg-warning-light text-warning rounded-pill px-2 py-1 border border-warning-10 fs-xs">
                                                <i class="fa fa-clock me-1"></i> Diverifikasi
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark rounded-pill px-2 py-1 border fs-xs">{{ ucfirst($item->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted border-0">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center border-0">
                                        <a href="{{ route('admin.prediction.show', $item->id) }}"
                                           class="btn btn-sm btn-white rounded-pill px-3 shadow-sm border" title="Lihat Detail">
                                            <i class="fa fa-eye text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($predictions->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted fst-italic">Belum ada data hasil prediksi karier alumni.</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($predictions->hasPages())
                    <div class="mt-4 pt-3 border-top">
                        {{ $predictions->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters
            if (typeof jQuery !== 'undefined') {
                $('.stat-counter').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text());
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
                });
            }

            jQuery('.js-dataTable-full').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                columnDefs: [
                    { orderable: false, targets: [0, 7] },
                    { className: 'text-center', targets: [0, 7] }
                ],
                order: [[1, 'asc']]
            });
        });
    </script>

    <style>
        .icon-circle.bg-white-20 { background: rgba(255,255,255,0.2); }
        .avatar-circle-sm { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
        .stat-hover-effect { transition: all 0.3s ease; }
        .stat-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .transition-all { transition: all 0.3s ease; }
        .hover-translate-y:hover { transform: translateY(-3px); }
        .hover-scale { transition: all 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
    </style>
@endsection
