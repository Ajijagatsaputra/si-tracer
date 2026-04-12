@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white border-bottom">
        <div class="content content-full py-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="hero-content">
                    <h1 class="h2 fw-bold text-dark mb-2">
                        <i class="fa fa-clipboard-check text-primary me-2"></i>Data Tracer Study Pengguna (Atasan)
                    </h1>
                    <p class="text-muted mb-0 fs-sm">
                        Kelola data kuesioner penilaian atasan secara profesional dan efisien.
                    </p>
                </div>
                <div class="hero-actions d-flex gap-2">
                    <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                        <i class="fa fa-chart-pie me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="content content-full">
        <!-- New Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Kuesioner -->
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-primary-light text-primary me-3">
                                <i class="fa fa-clipboard-list"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Total Kuesioner</div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-primary-darker stat-number" data-count="{{ $totalQuestionnaires }}">0</h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(79, 172, 254, 0.1);">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menunggu -->
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-warning-light text-warning me-3">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Menunggu</div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-warning stat-number" data-count="{{ $pendingQuestionnaires }}">0</h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(245, 158, 11, 0.1);">
                            <div class="progress-bar bg-warning" style="width: {{ $totalQuestionnaires > 0 ? ($pendingQuestionnaires / $totalQuestionnaires * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-success-light text-success me-3">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Selesai</div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-success stat-number" data-count="{{ $completedQuestionnaires }}">0</h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(16, 185, 129, 0.1);">
                            <div class="progress-bar bg-success" style="width: {{ $totalQuestionnaires > 0 ? ($completedQuestionnaires / $totalQuestionnaires * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kadaluarsa -->
            <div class="col-md-3">
                <div class="card card-modern border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-danger-light text-danger me-3">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Kadaluarsa</div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-danger stat-number" data-count="{{ $expiredQuestionnaires }}">0</h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(239, 68, 68, 0.1);">
                            <div class="progress-bar bg-danger" style="width: {{ $totalQuestionnaires > 0 ? ($expiredQuestionnaires / $totalQuestionnaires * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Table Toolbar -->
        <div class="table-toolbar">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill border shadow-sm w-fit">
                        <label class="mb-0 me-2 fw-bold text-muted fs-xs text-uppercase">
                            <i class="fa fa-list me-1 text-primary"></i> Tampilkan
                        </label>
                        <div id="entries-container"></div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-modern shadow-sm rounded-pill overflow-hidden border">
                        <span class="input-group-text border-0 bg-white px-3">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="text" id="custom-search" class="form-control border-0 px-2 py-2" placeholder="Cari data kuesioner...">
                        <button class="btn btn-primary px-4" type="button">Cari</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-modern border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 js-dataTable-full w-100">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px;">#</th>
                                <th>Alumni</th>
                                <th>Supervisor (Atasan)</th>
                                <th>Perusahaan / Jabatan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td class="text-center">
                                        <span class="fw-bold text-muted">{{ $index + 1 }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-placeholder bg-primary-light text-primary fw-bold me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($item->nama_alumni, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $item->nama_alumni }}</div>
                                                <div class="text-muted fs-xs">{{ $item->jabatan_alumni }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->nama_atasan }}</div>
                                        <div class="text-muted fs-xs d-flex flex-column">
                                            @if ($item->email_atasan)
                                                <span><i class="fa fa-envelope me-1 opacity-50"></i>{{ $item->email_atasan }}</span>
                                            @endif
                                            @if ($item->wa_atasan)
                                                <span><i class="fab fa-whatsapp me-1 text-success opacity-75"></i>{{ $item->wa_atasan }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->nama_perusahaan }}</div>
                                        <div class="text-muted fs-xs">{{ $item->jabatan_atasan }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status_pengisian == 'completed')
                                            <span class="badge-status-modern bg-success-light text-success">
                                                <i class="fa fa-check-circle me-1"></i>Selesai
                                            </span>
                                        @elseif($item->status_pengisian == 'sent')
                                            <span class="badge-status-modern bg-info-light text-info">
                                                <i class="fa fa-paper-plane me-1"></i>Terkirim
                                            </span>
                                        @elseif($item->status_pengisian == 'pending')
                                            @if ($item->expires_at < now())
                                                <span class="badge-status-modern bg-danger-light text-danger">
                                                    <i class="fa fa-exclamation-triangle me-1"></i>Kadaluarsa
                                                </span>
                                            @else
                                                <span class="badge-status-modern bg-warning-light text-warning">
                                                    <i class="fa fa-clock me-1"></i>Menunggu
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge-status-modern bg-secondary-light text-secondary">
                                                {{ ucfirst($item->status_pengisian) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.supervisor-questionnaire.show', $item->id) }}"
                                                class="btn btn-sm btn-action bg-info-light text-info border-0" title="Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-action bg-warning-light text-warning border-0"
                                                title="Kirim Ulang Notifikasi"
                                                onclick="resendNotification({{ $item->id }})">
                                                <i class="fa fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if ($data->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $data->appends(request()->query())->links() }}
            </div>
        @endif
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
                dom: "<'row'<'col-sm-12'tr>>" +
                     "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0, 5]
                    },
                    {
                        className: 'text-center',
                        targets: [0, 4, 5]
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            // Move length menu
            $('.dataTables_length').appendTo('#entries-container').empty();
            $('<select class="form-select form-select-sm border-0 bg-transparent fw-bold text-primary p-0 h-auto" style="width: auto;">' +
              '<option value="10">10</option>' +
              '<option value="25">25</option>' +
              '<option value="50">50</option>' +
              '<option value="100">100</option>' +
              '</select>')
              .appendTo('#entries-container')
              .on('change', function() {
                  table.page.len($(this).val()).draw();
              });

            // Custom Search
            $('#custom-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Counter Animation
            $('.stat-number').each(function() {
                const $this = $(this);
                const countTo = parseInt($this.attr('data-count'));
                $({ countNum: 0 }).animate({
                    countNum: countTo
                }, {
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

            // Resend notification
            window.resendNotification = function(id) {
                Swal.fire({
                    title: 'Kirim Ulang Notifikasi?',
                    text: 'Apakah Anda yakin ingin mengirim ulang notifikasi ke supervisor?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kirim!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal-modern'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}";
                        url = url.replace(':id', id);
                        window.location.href = url;
                    }
                });
            }
        });
    </script>
@endsection
