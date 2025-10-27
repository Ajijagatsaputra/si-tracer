@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="py-3 bg-body-light border-bottom">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="mb-0 h3 fw-bold text-primary">
                    <i class="fa fa-brain me-2"></i> Data Prediksi Karier Alumni
                </h1>
                <p class="mb-0 text-muted fs-sm">Pantau hasil prediksi karier alumni berdasarkan model machine learning.</p>
            </div>
            <div>
                <a href="{{ route('admin.prediction.dashboard') }}" class="btn btn-primary">
                    <i class="fa fa-chart-line me-1"></i> Dashboard Prediksi
                </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="block shadow-sm block-rounded">

            <!-- Ringkasan Prediksi -->
            <div class="px-4 py-3 row g-3 align-items-center">
                <div class="col-6 col-md-3">
                    <div class="text-white card card-body gradient-card bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalPredictions }}</div>
                                <div class="fs-sm">Total Data</div>
                            </div>
                            <i class="opacity-75 fa fa-database fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-white card card-body gradient-card bg-gradient-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $matchPredictions }}</div>
                                <div class="fs-sm">Prediksi Sesuai</div>
                            </div>
                            <i class="opacity-75 fa fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-white card card-body gradient-card bg-gradient-danger">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $notMatchPredictions }}</div>
                                <div class="fs-sm">Tidak Sesuai</div>
                            </div>
                            <i class="opacity-75 fa fa-times-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card card-body gradient-card bg-gradient-warning text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $underReview }}</div>
                                <div class="fs-sm">Sedang Diverifikasi</div>
                            </div>
                            <i class="opacity-75 fa fa-hourglass-half fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Ringkasan Prediksi -->

            <div
                class="px-4 py-2 block-header block-header-default bg-light d-flex align-items-center justify-content-between">
                <h3 class="mb-0 block-title fw-semibold text-primary">
                    <i class="fa fa-table me-2"></i> Tabel Hasil Prediksi Karier
                </h3>
            </div>

            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-hover table-bordered js-dataTable-full w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Nama Alumni</th>
                                <th>Program Studi</th>
                                <th>Prediksi Karier</th>
                                <th>Skor Akurasi</th>
                                <th>Status</th>
                                <th>Tanggal Prediksi</th>
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($predictions as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $item->nama_alumni }}</td>
                                    <td>{{ $item->prodi }}</td>
                                    <td>{{ $item->hasil_prediksi }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ number_format($item->skor_akurasi, 2) }}%</span>
                                    </td>
                                    <td>
                                        @if ($item->status == 'match')
                                            <span class="badge bg-success">Sesuai</span>
                                        @elseif ($item->status == 'not_match')
                                            <span class="badge bg-danger">Tidak Sesuai</span>
                                        @elseif ($item->status == 'pending')
                                            <span class="badge bg-warning text-dark">Diverifikasi</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="gap-1 btn-group">
                                            <a href="{{ route('admin.prediction.show', $item->id) }}"
                                                class="btn btn-sm btn-info rounded-pill" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($predictions->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data hasil prediksi karier alumni.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($predictions->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
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
        jQuery(document).ready(function() {
            jQuery('.js-dataTable-full').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                pageLength: 10,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0, 7]
                    },
                    {
                        className: 'text-center',
                        targets: [0, 7]
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });
        });
    </script>

    <style>
        /* ====== Gradient Backgrounds (Prediksi Theme) ====== */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%) !important;
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%) !important;
        }

        .card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .btn {
            border-radius: 0.65rem;
            font-weight: 500;
        }
    </style>
@endsection
