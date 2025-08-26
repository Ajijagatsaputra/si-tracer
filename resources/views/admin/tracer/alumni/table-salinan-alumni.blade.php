@extends('layouts.admin')

@section('content')
    @php
        $role = Auth::user()->role;
    @endphp

    <meta name="user-role" content="{{ $role }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-4 mb-4 text-white bg-primary bg-gradient">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold"><i class="fa fa-clipboard-list me-2"></i> Data Salinan Tracer Alumni</h1>
                <p class="mb-0">Kelola data tracer alumni secara efisien dan profesional.</p>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-white border-0 shadow-sm card bg-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-3 fw-bold">{{ $totalAlumni }}</div>
                            <div>Total Alumni</div>
                        </div>
                        <i class="opacity-75 fa fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-white border-0 shadow-sm card bg-success">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-3 fw-bold">{{ $sudahMengisi }}</div>
                            <div>Sudah Mengisi</div>
                        </div>
                        <i class="opacity-75 fa fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-white border-0 shadow-sm card bg-warning">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-3 fw-bold">{{ $belumMengisi }}</div>
                            <div>Belum Mengisi</div>
                        </div>
                        <i class="opacity-75 fa fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-wrap gap-2 mt-4 mb-3 d-flex justify-content-between align-items-center">
            <div class="gap-2 d-flex align-items-center">
                <label class="mb-0 fw-semibold" for="filter-status">Filter Status Pekerjaan:</label>
                <select class="w-auto form-select form-select-sm" id="filter-status">
                    <option value="">Semua Status</option>
                    <option value="bekerja_full">Bekerja</option>
                    <option value="wirausaha">Wiraswasta</option>
                    <option value="lanjutstudy">Melanjutkan Pendidikan</option>
                    <option value="belum_bekerja">Belum Memungkinkan Bekerja</option>
                    <option value="tidak">Tidak Kerja</option>
                </select>
            </div>
            <div class="btn-group">
                <button class="btn btn-outline-success btn-sm" id="btnDownloadExcel"><i
                        class="fa fa-file-excel me-1"></i>Excel</button>
                <button class="btn btn-outline-danger btn-sm" id="btnDownloadPdf"><i
                        class="fa fa-file-pdf me-1"></i>PDF</button>
                <button class="btn btn-outline-primary btn-sm" id="btnDownloadPrint"><i
                        class="fa fa-print me-1"></i>Cetak</button>
            </div>
        </div>

        <div class="mb-4 border-0 shadow-sm card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center align-middle table-bordered table-hover small" id="datatable">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>#</th>
                                <th>Tanggal Mengisi</th>
                                <th>Nama Alumni</th>
                                <th>Status Pekerjaan</th>
                                <th>Aksi</th>
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

    {{-- Script --}}
    <script>
        $(document).ready(function() {
            const userRole = $('meta[name="user-role"]').attr('content');

            const table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('listtraceralumni.index') }}",
                    data: function(d) {
                        d.status = $('#filter-status').val();
                    }
                },
                dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6 text-end"B>>frtip',
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'btn btn-sm btn-success shadow-sm me-1 d-none',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        filename: 'Rekap_Tracer_Alumni',
                        title: 'Rekap Data Tracer Alumni'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-sm btn-danger shadow-sm me-1 d-none',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        filename: 'Rekap_Tracer_Alumni',
                        title: 'Rekap Data Tracer Alumni'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-secondary shadow-sm me-1 d-none',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Rekap Data Tracer Alumni'
                    }
                ],
                columns: [{
                        data: 'id',
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'created_at',
                        render: data => data ? new Date(data).toLocaleDateString('id-ID') : '-'
                    },
                    {
                        data: 'nama',
                        render: function(data, type, row) {
                            return row.alumni && row.alumni.nama_lengkap ?
                                row.alumni.nama_lengkap :
                                (data || '-');
                        }
                    },
                    {
                        data: 'status_pekerjaan',
                        render: function(data) {
                            const statusMap = {
                                'bekerja_full': '<span class="badge bg-success">Bekerja</span>',
                                'wirausaha': '<span class="badge bg-info">Wiraswasta</span>',
                                'lanjutstudy': '<span class="badge bg-primary">Melanjutkan Pendidikan</span>',
                                'belum_bekerja': '<span class="badge bg-warning">Belum Memungkinkan Bekerja</span>',
                                'tidak': '<span class="badge bg-secondary">Tidak Kerja</span>'
                            };
                            return statusMap[data] || '<span class="badge bg-light text-dark">' + (
                                data || '-') + '</span>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            let actions = `
                                <div class="dropdown">
                                    <button class="shadow-sm btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a href="/listtraceralumni/${data.id}" class="dropdown-item">
                                            <i class="fa fa-eye text-info me-2"></i> Detail</a></li>
                            `;
                            if (userRole === 'admin') {
                                actions += `
                                        <li><a href="/listtraceralumni/${data.id}/edit" class="dropdown-item">
                                            <i class="fa fa-edit text-warning me-2"></i> Edit</a></li>
                                        <li><a href="#" class="dropdown-item btn-delete" data-id="${data.id}">
                                            <i class="fa fa-trash-alt text-danger me-2"></i> Hapus</a></li>
                                `;
                            }
                            actions += `
                                    </ul>
                                </div>
                            `;
                            return actions;
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ]
            });

            $('#filter-status').on('change', function() {
                table.ajax.reload();
            });

            $('#btnDownloadExcel').click(() => table.button('.buttons-excel').trigger());
            $('#btnDownloadPdf').click(() => table.button('.buttons-pdf').trigger());
            $('#btnDownloadPrint').click(() => table.button('.buttons-print').trigger());

            // Fix dropdown positioning issues
            $(document).on('shown.bs.dropdown', '.dropdown', function() {
                var dropdown = $(this).find('.dropdown-menu');
                var windowHeight = $(window).height();
                var dropdownOffset = dropdown.offset();
                var dropdownHeight = dropdown.outerHeight();

                // Check if dropdown goes beyond viewport
                if (dropdownOffset && (dropdownOffset.top + dropdownHeight) > windowHeight) {
                    dropdown.addClass('dropup');
                }
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

            // Setup CSRF token untuk semua AJAX request
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Event delete
            $('#datatable').on('click', '.btn-delete', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data tidak bisa dikembalikan setelah dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/listtraceralumni/${id}`, // pastikan ini sesuai route
                            type: 'DELETE',
                            dataType: 'json',
                            success: function(res) {
                                // Reload DataTable
                                $('#datatable').DataTable().ajax.reload();

                                // Notifikasi sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: res.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr, status, error) {
                                // Cek respons error
                                console.error(xhr.responseText);

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Tidak dapat menghapus data.',
                                    footer: xhr.status == 419 ?
                                        'Session CSRF Expired. Refresh halaman!' :
                                        ''
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>

   {{-- STYLE --}}
<style>
    /* ================================
       Datatable Modern Styling
    ================================= */
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_filter label {
        font-weight: 600;
        margin-right: 0.5rem;
        color: #495057;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 0.75rem;
        padding: 0.5rem 0.9rem;
        font-size: 0.9rem;
        outline: none;
        transition: all 0.25s ease;
        background: #fff;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #1577c2;
        box-shadow: 0 0 0 0.25rem rgba(21, 119, 194, 0.15);
    }

    /* Table header */
    #datatable thead th {
        background: linear-gradient(135deg, #1577c2, #1e90ff);
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        text-align: center;
        border: none;
    }

    /* Table rows */
    #datatable tbody tr {
        transition: background 0.2s ease;
    }

    #datatable tbody tr:hover {
        background: #f1f7ff;
    }

    #datatable td {
        vertical-align: middle;
        font-size: 0.95rem;
        padding: 0.75rem;
    }

    /* Status badge */
    .badge {
        border-radius: 50rem !important;
        font-size: 0.8rem;
        padding: 0.4em 0.8em;
        font-weight: 500;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745, #45c86d);
        color: #fff;
    }

    .badge-warning {
        background: linear-gradient(135deg, #ffc107, #ffda6a);
        color: #000;
    }

    .badge-danger {
        background: linear-gradient(135deg, #dc3545, #f35b6b);
        color: #fff;
    }

    /* Dropdown menu */
    .dropdown-menu {
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .dropdown-menu .dropdown-item {
        padding: 0.6rem 1.1rem;
        display: flex;
        align-items: center;
        transition: background 0.2s ease;
    }

    .dropdown-menu .dropdown-item:hover {
        background: #f1f7ff;
        color: #1577c2;
    }

    .dropdown-menu .dropdown-item i {
        width: 18px;
        margin-right: 8px;
    }

    /* Buttons */
    .btn-sm {
        border-radius: 0.6rem;
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        transition: all 0.2s ease;
    }

    .btn-outline-primary {
        border-color: #1577c2;
        color: #1577c2;
    }

    .btn-outline-primary:hover {
        background: #1577c2;
        color: #fff;
        box-shadow: 0 4px 10px rgba(21, 119, 194, 0.25);
    }

    /* Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.5rem;
        padding: 0.4rem 0.8rem;
        margin: 0 2px;
        border: 1px solid #dee2e6;
        color: #1577c2 !important;
        transition: all 0.2s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #1577c2 !important;
        color: #fff !important;
        border: 1px solid #1577c2;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #1e90ff !important;
        color: #fff !important;
        border: 1px solid #1e90ff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dataTables_wrapper .dataTables_filter {
            float: none;
            text-align: left;
            margin-top: 1rem;
        }

        .flex-wrap.gap-2 {
            flex-direction: column;
            align-items: stretch !important;
        }

        .btn-group {
            width: 100%;
            justify-content: space-between;
        }

        #datatable thead {
            display: none; /* hide header di mobile */
        }

        #datatable tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 0.75rem;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
        }

        #datatable tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem;
            border: none;
        }

        #datatable tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #495057;
        }
    }
</style>

@endsection
