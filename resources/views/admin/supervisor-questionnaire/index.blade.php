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
                <div class="col-md-3">
                    <div class="text-white border-0 shadow-sm card card-body bg-gradient-primary gradient-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $totalQuestionnaires }}</div>
                                <div class="fs-sm">Total Kuesioner</div>
                            </div>
                            <div><i class="opacity-50 fa fa-clipboard-list fa-2x"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border-0 shadow-sm card card-body bg-gradient-warning text-dark gradient-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $pendingQuestionnaires }}</div>
                                <div class="fs-sm">Menunggu</div>
                            </div>
                            <div><i class="opacity-50 fa fa-clock fa-2x"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-white border-0 shadow-sm card card-body bg-gradient-success gradient-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $completedQuestionnaires }}</div>
                                <div class="fs-sm">Selesai</div>
                            </div>
                            <div><i class="opacity-50 fa fa-check-circle fa-2x"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-white border-0 shadow-sm card card-body bg-gradient-danger gradient-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-2 fw-bold">{{ $expiredQuestionnaires }}</div>
                                <div class="fs-sm">Kadaluarsa</div>
                            </div>
                            <div><i class="opacity-50 fa fa-exclamation-triangle fa-2x"></i></div>
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
                    <!-- Table dengan 9 kolom: #, Nama Alumni, Nama Atasan, Jabatan Atasan, Perusahaan, Status, Tanggal Dibuat, Kadaluarsa, Aksi -->
                    <table class="table mb-0 align-middle table-bordered table-striped table-hover js-dataTable-full w-100">
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
                                        <div class="text-muted small">
                                            @if ($item->email_atasan)
                                                <i class="fa fa-envelope me-1"></i>{{ $item->email_atasan }}
                                            @endif
                                        </div>
                                        <div class="text-muted small">
                                            @if ($item->wa_atasan)
                                                <i class="fa fa-whatsapp me-1"></i>{{ $item->wa_atasan }}
                                            @endif
                                        </div>
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
                                        <div class="gap-1 btn-group" role="group">
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
            // Validasi bahwa table ada dan memiliki struktur yang benar
            var tableElement = jQuery('.js-dataTable-full');
            if (tableElement.length === 0) {
                console.error('Table dengan class js-dataTable-full tidak ditemukan');
                return;
            }

            // Hitung jumlah kolom di header
            var headerColumns = tableElement.find('thead th').length;
            console.log('Jumlah kolom di header:', headerColumns);

            // Hitung jumlah kolom di body (baris pertama)
            var firstRowColumns = tableElement.find('tbody tr:first td').length;
            console.log('Jumlah kolom di body (baris pertama):', firstRowColumns);

            // Validasi konsistensi kolom
            if (headerColumns !== firstRowColumns) {
                console.error('Ketidakcocokan jumlah kolom: Header =', headerColumns, ', Body =', firstRowColumns);
                return;
            }

            // DataTable dengan konfigurasi yang lebih spesifik
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
                    }, // Kolom # dan Aksi tidak bisa di-sort
                    {
                        className: 'text-center',
                        targets: [0, 8]
                    } // Kolom # dan Aksi center-aligned
                ],
                order: [
                    [1, 'asc']
                ], // Sort berdasarkan nama alumni
                drawCallback: function(settings) {
                    // Debug info
                    console.log('DataTables initialized successfully');
                    console.log('Columns:', settings.aoColumns.length);
                    console.log('Data rows:', settings.aiDisplay.length);
                }
            });

            // Error handling
            table.on('error.dt', function(e, settings, techNote, message) {
                console.error('DataTables error:', message);
            });

            // Success callback
            table.on('init.dt', function() {
                console.log('DataTables berhasil diinisialisasi');
            });
        });

        // Function untuk resend notification
        function resendNotification(id) {
            Swal.fire({
                title: 'Kirim Ulang Notifikasi?',
                text: 'Apakah Anda yakin ingin mengirim ulang notifikasi ke supervisor?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}";
                    url = url.replace(':id', id);
                    window.location.href = url;
                }
            });
        }
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

        .btn-warning {
            color: #fff !important;
        }
    </style>
@endsection
