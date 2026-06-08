@extends('layouts.admin')

@section('content')
    @php
        $role = Auth::user()->role;
    @endphp

    <meta name="user-role" content="{{ $role }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Modern Hero Section -->
    <div class="bg-white border-bottom shadow-sm mb-4">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-3">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-primary-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-clipboard-list text-primary"></i>
                        </span>
                        Data Salinan Tracer Alumni
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Kelola data tracer alumni secara efisien dan profesional dengan sistem yang lebih cerdas.
                    </p>
                </div>
                <div class="mt-3 mt-sm-0">
                    <span class="badge bg-primary-light text-primary px-3 py-2 rounded-pill shadow-sm">
                        <i class="fas fa-chart-line me-1"></i> Live Data
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <!-- Quick Stats Modern -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card card-modern overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-primary-light text-primary me-3">
                                <i class="fa fa-users"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Total Alumni
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-primary-darker stat-number" data-count="{{ $totalAlumni }}">0
                            </h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(79, 172, 254, 0.1);">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                        <p class="fs-xs text-muted mb-0 mt-2">
                            <i class="fas fa-info-circle me-1"></i> Seluruh data alumni terdaftar
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-modern overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-success-light text-success me-3">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Sudah Mengisi
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-success stat-number" data-count="{{ $sudahMengisi }}">0</h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(16, 185, 129, 0.1);">
                            <div class="progress-bar bg-success"
                                style="width: {{ $totalAlumni > 0 ? ($sudahMengisi / $totalAlumni * 100) : 0 }}%"></div>
                        </div>
                        <p class="fs-xs text-muted mb-0 mt-2">
                            <i class="fas fa-check me-1 text-success"></i>
                            {{ $totalAlumni > 0 ? round($sudahMengisi / $totalAlumni * 100, 1) : 0 }}% completion rate
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-modern overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="stat-icon-modern bg-warning-light text-warning me-3">
                                <i class="fa fa-clock"></i>
                            </div>
                            <div class="stat-label-modern fw-bold text-muted text-uppercase fs-xs ls-wider">Belum Mengisi
                            </div>
                        </div>
                        <div class="d-flex align-items-baseline">
                            <h2 class="h1 fw-bold mb-0 text-warning stat-number" data-count="{{ $belumMengisi }}">0</h2>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(245, 158, 11, 0.1);">
                            <div class="progress-bar bg-warning"
                                style="width: {{ $totalAlumni > 0 ? ($belumMengisi / $totalAlumni * 100) : 0 }}%"></div>
                        </div>
                        <p class="fs-xs text-muted mb-0 mt-2">
                            <i class="fas fa-exclamation-triangle me-1 text-warning"></i> Menunggu pengisian data
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Table Toolbar -->
        <div class="table-toolbar">
            <div class="row g-3 align-items-center">
                <!-- Filter & Entries Group -->
                <div class="col-12 col-xl-8">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <!-- Status Filter -->
                        <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill border shadow-sm">
                            <label for="filter-status" class="mb-0 me-2 fw-bold text-muted fs-xs text-uppercase">
                                <i class="fa fa-filter text-primary me-1"></i> Status
                            </label>
                            <select id="filter-status"
                                class="form-select form-select-sm border-0 bg-transparent fw-bold text-primary p-0 h-auto"
                                style="width: auto; min-width: 120px;">
                                <option value="">Semua Status</option>
                                <option value="bekerja_full">Bekerja</option>
                                <option value="wirausaha">Wiraswasta</option>
                                <option value="lanjutstudy">Lanjut Study</option>
                                <option value="belum_bekerja">Belum Bekerja</option>
                                <option value="tidak">Tidak Kerja</option>
                            </select>
                        </div>

                        <!-- Total Records Badge -->
                        <div
                            class="bg-primary-light text-primary px-3 py-2 rounded-pill shadow-sm fs-sm fw-bold border border-primary-lighter">
                            <i class="fas fa-database me-1"></i> <span id="totalRecords">0</span> <small
                                class="text-uppercase ms-1 opacity-75">Records</small>
                        </div>

                        <!-- Entries Selection (placeholder for DT length) -->
                        <div id="entries-container" class="ms-sm-auto"></div>
                    </div>
                </div>

                <!-- Search Group -->
                <div class="col-12 col-xl-4 text-xl-end">
                    <div class="input-group input-group-modern shadow-sm border rounded-pill overflow-hidden">
                        <span class="input-group-text border-0 bg-white ps-3">
                            <i class="fa fa-search text-muted"></i>
                        </span>
                        <input type="text" id="customSearch" class="form-control border-0 fs-sm"
                            placeholder="Cari data tracer...">
                        <button class="btn btn-primary px-4 fw-semibold" id="searchBtn">Cari</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Table Card Modern -->
        <div class="card card-modern overflow-hidden">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover w-100" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Mengisi</th>
                                <th>Nama Alumni</th>
                                <th>Status Pekerjaan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- DataTables & Export --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" />
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    {{-- Script --}}
    <script>
        $(document).ready(function () {
            // Initialize AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });

            // Initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Counter Animation
            $('.stat-number').each(function () {
                const $this = $(this);
                const countTo = parseInt($this.attr('data-count'));

                $({
                    countNum: 0
                }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function () {
                        $this.text(this.countNum);
                    }
                });
            });

            const userRole = $('meta[name="user-role"]').attr('content');

            const table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('listtraceralumni.index') }}",
                    data: function (d) {
                        d.status = $('#filter-status').val();
                    }
                },
                dom: "<'row mt-3 mb-1'<'col-sm-12'B>>" +
                    "<'row'<'col-sm-12 table-responsive'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-5 fs-sm text-muted'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-file-excel me-1"></i> Excel',
                        exportOptions: { columns: ':not(:last-child)' },
                        filename: 'Rekap_Tracer_Alumni',
                        title: 'Rekap Data Tracer Alumni'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        text: '<i class="fa fa-file-pdf me-1"></i> PDF',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: { columns: ':not(:last-child)' },
                        filename: 'Rekap_Tracer_Alumni',
                        title: 'Rekap Data Tracer Alumni'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-info',
                        text: '<i class="fa fa-print me-1"></i> Cetak',
                        exportOptions: { columns: ':not(:last-child)' },
                        title: 'Rekap Data Tracer Alumni'
                    }
                ],
                initComplete: function () {
                    // Move the length menu to our custom container
                    $('#entries-container').empty();
                    let lengthMenu = $('.dataTables_length').detach();
                    $('#entries-container').append(lengthMenu);

                    // Custom search logic
                    $('#customSearch').on('keyup', function () {
                        table.search(this.value).draw();
                    });
                    $('#searchBtn').on('click', function () {
                        table.search($('#customSearch').val()).draw();
                    });
                },
                columns: [
                    {
                        data: 'id',
                        className: 'fw-bold text-muted',
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'created_at',
                        render: data => data ? `<span class="badge bg-light text-dark border"><i class="far fa-calendar-alt me-1 text-primary"></i>${new Date(data).toLocaleDateString('id-ID')}</span>` : '-'
                    },
                    {
                        data: 'nama',
                        render: function (data, type, row) {
                            const nama = row.alumni && row.alumni.nama_lengkap ? row.alumni.nama_lengkap : (data || '-');
                            const avatar = row.alumni && row.alumni.avatar_url ? row.alumni.avatar_url : `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=random`;
                            return `<div class="d-flex align-items-center py-1">
                                                    <img src="${avatar}" class="shadow-sm border border-2 border-white" style="width:36px;height:36px;border-radius:12px;margin-right:12px;object-fit:cover;">
                                                    <div class="fw-bold text-dark">${nama}</div>
                                                </div>`;
                        }
                    },
                    {
                        data: 'status_pekerjaan',
                        render: function (data) {
                            const statusMap = {
                                'bekerja_full': '<span class="badge-status-modern bg-success-light text-success"><i class="fas fa-briefcase me-1"></i>Bekerja</span>',
                                'wirausaha': '<span class="badge-status-modern bg-info-light text-info"><i class="fas fa-store me-1"></i>Wiraswasta</span>',
                                'lanjutstudy': '<span class="badge-status-modern bg-primary-light text-primary"><i class="fas fa-graduation-cap me-1"></i>Lanjut Study</span>',
                                'belum_bekerja': '<span class="badge-status-modern bg-warning-light text-warning"><i class="fas fa-clock me-1"></i>Belum Bekerja</span>',
                                'tidak': '<span class="badge-status-modern bg-secondary-light text-secondary"><i class="fas fa-times me-1"></i>Tidak Kerja</span>'
                            };
                            return statusMap[data] || `<span class="badge-status-modern bg-light text-muted">${data || '-'}</span>`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data) {
                            return `<div class="btn-group">
                                                    <a href="/listtraceralumni/${data.id}" class="btn btn-action btn-alt-info" title="Detail">
                                                        <i class="fa fa-eye text-primary"></i>
                                                    </a>
                                                    ${userRole === 'admin' ? `
                                                    <a href="/listtraceralumni/${data.id}/edit" class="btn btn-action btn-alt-warning mx-1" title="Edit">
                                                        <i class="fa fa-pencil-alt text-warning"></i>
                                                    </a>
                                                    <button class="btn btn-action btn-alt-danger btn-delete" data-id="${data.id}" title="Hapus">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </button>
                                                    ` : ''}
                                                </div>`;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                orderCellsTop: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    search: '<i class="fas fa-search me-2"></i>',
                    searchPlaceholder: 'Cari data...',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    zeroRecords: '<div class="no-data"><i class="mb-3 fas fa-inbox fa-3x"></i><p>Tidak ada data yang ditemukan</p></div>',
                    emptyTable: '<div class="no-data"><i class="mb-3 fas fa-database fa-3x"></i><p>Belum ada data tersedia</p></div>'
                },
                drawCallback: function (settings) {
                    $('#totalRecords').text(settings._iRecordsTotal);
                }
            });

            $('#filter-status').on('change', function () {
                $(this).addClass('filter-active');
                table.ajax.reload();

                setTimeout(() => {
                    $(this).removeClass('filter-active');
                }, 300);
            });

            $('#btnDownloadExcel').click(function () {
                $(this).addClass('btn-loading');
                table.button('.buttons-excel').trigger();
                setTimeout(() => $(this).removeClass('btn-loading'), 1000);
            });

            $('#btnDownloadPdf').click(function () {
                $(this).addClass('btn-loading');
                table.button('.buttons-pdf').trigger();
                setTimeout(() => $(this).removeClass('btn-loading'), 1000);
            });

            $('#btnDownloadPrint').click(function () {
                $(this).addClass('btn-loading');
                table.button('.buttons-print').trigger();
                setTimeout(() => $(this).removeClass('btn-loading'), 1000);
            });

            // Setup CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Event delete with enhanced SweetAlert
            $('#datatable').on('click', '.btn-delete', function () {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    html: '<p class="mb-0">Data yang dihapus tidak dapat dikembalikan!</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fa fa-trash me-2"></i>Ya, Hapus!',
                    cancelButtonText: '<i class="fa fa-times me-2"></i>Batal',
                    customClass: {
                        popup: 'swal-modern',
                        confirmButton: 'btn-modern btn-modern-danger',
                        cancelButton: 'btn-modern btn-modern-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            html: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: `/listtraceralumni/${id}`,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function (res) {
                                table.ajax.reload();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    html: '<p class="mb-0">' + res.message + '</p>',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    customClass: {
                                        popup: 'swal-modern'
                                    }
                                });
                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    html: '<p class="mb-0">Tidak dapat menghapus data.</p>',
                                    footer: xhr.status == 419 ? '<i class="fas fa-exclamation-triangle me-2"></i>Session CSRF Expired. Refresh halaman!' : '',
                                    customClass: {
                                        popup: 'swal-modern'
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    <style>
        /* Modern Table styling */
        .table-responsive {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        #datatable {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }

        #datatable thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 14px 16px !important;
            border-bottom: 2px solid #e2e8f0 !important;
            border-top: none !important;
            white-space: nowrap;
        }

        #datatable tbody tr {
            transition: all 0.2s ease-in-out;
        }

        #datatable tbody tr:hover {
            background-color: rgba(241, 245, 249, 0.4) !important;
        }

        #datatable tbody td {
            padding: 14px 16px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #334155;
            font-size: 0.875rem;
        }

        /* Modern Pagination styling */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid #e2e8f0 !important;
            background: #fff !important;
            color: #475569 !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            margin: 0 3px !important;
            font-weight: 600 !important;
            font-size: 0.85rem !important;
            transition: all 0.2s !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f1f5f9 !important;
            color: #0f172a !important;
            border-color: #cbd5e1 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #4f46e5 !important;
            /* Indigo for Alumni */
            color: #fff !important;
            border-color: #4f46e5 !important;
        }

        /* View Button modern circle style */
        .btn-action {
            transition: all 0.2s ease-in-out !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #fff !important;
            width: 34px !important;
            height: 34px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important;
            padding: 0 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
        }

        .btn-action:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        }

        .btn-alt-info:hover {
            background-color: #e0f2fe !important;
            border-color: #bae6fd !important;
        }

        .btn-alt-warning:hover {
            background-color: #fffbeb !important;
            border-color: #fde68a !important;
        }

        .btn-alt-danger:hover {
            background-color: #fff1f2 !important;
            border-color: #fecdd3 !important;
        }

        /* Modern Status Badges */
        .badge-status-modern {
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            padding: 4px 10px !important;
            border-radius: 9999px !important;
            font-size: 0.725rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.02em !important;
            border: 1px solid transparent !important;
        }

        .bg-success-light {
            background-color: #ecfdf5 !important;
            color: #059669 !important;
            border-color: #a7f3d0 !important;
        }

        .bg-info-light {
            background-color: #e0f2fe !important;
            color: #0284c7 !important;
            border-color: #bae6fd !important;
        }

        .bg-primary-light {
            background-color: #e0e7ff !important;
            color: #4f46e5 !important;
            border-color: #c7d2fe !important;
        }

        .bg-warning-light {
            background-color: #fffbeb !important;
            color: #d97706 !important;
            border-color: #fde68a !important;
        }

        .bg-secondary-light {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border-color: #cbd5e1 !important;
        }
    </style>
@endsection