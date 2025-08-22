@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="py-3 bg-body-light border-bottom">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="mb-0 h3 fw-bold text-primary">
                    <i class="fa fa-clipboard-list me-2"></i> Data Tracer Study Pengguna (Atasan)
                </h1>
                <p class="mb-0 text-muted fs-sm">Kelola data kuesioner penilaian atasan secara profesional dan mudah.</p>
            </div>
            <div>
                <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn btn-primary">
                    <i class="fa fa-chart-pie me-1"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="block shadow-sm block-rounded">
            <!-- Rekapan Data -->
            <div class="px-4 py-3 row g-3 align-items-center">
                <div class="col-6 col-md-3">
                    <div class="text-white card card-body gradient-card bg-gradient-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalQuestionnaires }}</div>
                                <div class="fs-sm">Total Kuesioner</div>
                            </div>
                            <i class="opacity-75 fa fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card card-body gradient-card bg-gradient-warning text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $pendingQuestionnaires }}</div>
                                <div class="fs-sm">Menunggu</div>
                            </div>
                            <i class="opacity-75 fa fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-white card card-body gradient-card bg-gradient-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $completedQuestionnaires }}</div>
                                <div class="fs-sm">Selesai</div>
                            </div>
                            <i class="opacity-75 fa fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-white card card-body gradient-card bg-gradient-danger">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $expiredQuestionnaires }}</div>
                                <div class="fs-sm">Kadaluarsa</div>
                            </div>
                            <i class="opacity-75 fa fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Rekapan Data -->

            <div
                class="px-4 py-2 block-header block-header-default bg-light d-flex align-items-center justify-content-between">
                <h3 class="mb-0 block-title fw-semibold text-primary">
                    <i class="fa fa-table me-2"></i> Tabel Data Tracer Study Pengguna
                </h3>
            </div>

            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-hover table-bordered js-dataTable-full w-100">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Nama Alumni</th>
                                <th>Nama Atasan</th>
                                <th>Jabatan Atasan</th>
                                <th>Perusahaan</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Kadaluarsa</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->nama_alumni }}</div>
                                        <div class="text-muted small">{{ $item->jabatan_alumni }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->nama_atasan }}</div>
                                        @if ($item->email_atasan)
                                            <div class="text-muted small">
                                                <i class="fa fa-envelope me-1"></i>{{ $item->email_atasan }}
                                            </div>
                                        @endif
                                        @if ($item->wa_atasan)
                                            <div class="text-muted small">
                                                <i class="fa fa-whatsapp me-1"></i>{{ $item->wa_atasan }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->jabatan_atasan }}</td>
                                    <td>{{ $item->nama_perusahaan }}</td>
                                    <td>
                                        @if ($item->status_pengisian == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($item->status_pengisian == 'sent')
                                            <span class="badge bg-info">Terkirim</span>
                                        @elseif($item->status_pengisian == 'pending')
                                            @if ($item->expires_at < now())
                                                <span class="badge bg-danger">Kadaluarsa</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($item->status_pengisian) }}</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        {{ $item->created_at ? $item->created_at->format('d-m-Y H:i') : '-' }}
                                    </td>
                                    <td>
                                        @if ($item->expires_at)
                                            <div class="{{ $item->expires_at < now() ? 'text-danger' : 'text-muted' }}">
                                                {{ \Carbon\Carbon::parse($item->expires_at)->format('d-m-Y') }}
                                            </div>
                                            @if ($item->expires_at < now())
                                                <div class="text-danger small">Kadaluarsa</div>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="gap-1 btn-group">
                                            <a href="{{ route('admin.supervisor-questionnaire.show', $item->id) }}"
                                                class="btn btn-sm btn-info rounded-pill" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-warning rounded-pill"
                                                title="Kirim Ulang Notifikasi"
                                                onclick="resendNotification({{ $item->id }})">
                                                <i class="fa fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($data->isEmpty())
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data supervisor questionnaire.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($data->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $data->appends(request()->query())->links() }}
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        jQuery(document).ready(function() {
            var tableElement = jQuery('.js-dataTable-full');
            if (tableElement.length === 0) return;

            var table = tableElement.DataTable({
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
                        targets: [0, 8]
                    },
                    {
                        className: 'text-center',
                        targets: [0, 8]
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Resend notification
            window.resendNotification = function(id) {
                Swal.fire({
                    title: 'Kirim Ulang Notifikasi?',
                    text: 'Apakah Anda yakin ingin mengirim ulang notifikasi ke supervisor?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url =
                            "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}";
                        url = url.replace(':id', id);
                        window.location.href = url;
                    }
                });
            }
        });
    </script>

    <style>
        /* ====== Gradient Backgrounds (Soft Modern) ====== */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3acfd5 0%, #3a4ed5 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%) !important;
        }

        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%) !important;
        }

        /* ====== Card Modern ====== */
        .card {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        /* ====== Button ====== */
        .btn {
            border-radius: 0.65rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-warning {
            color: #212529 !important;
        }

        .btn-warning:hover {
            background-color: #e0a800 !important;
            border-color: #d39e00 !important;
            color: #fff !important;
        }

        /* ====== Responsive ====== */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 1rem;
            }

            .btn {
                font-size: 0.875rem;
                padding: 0.4rem 0.75rem;
            }

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 0.75rem;
                padding: 0.75rem;
                background: #fff;
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 0.75rem;
                font-weight: 600;
                color: #6c757d;
                text-transform: uppercase;
            }
        }
    </style>
@endsection
