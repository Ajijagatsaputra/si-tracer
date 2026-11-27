@extends('layouts.admin')

@section('content')
    @php
        $role = Auth::user()->role;
    @endphp
    <meta name="user-role" content="{{ $role }}">

    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Tracer Alumni</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Tracer Alumni</h1>
                    <p class="akila-subtitle">Kelola semua data hasil pengisian kuesioner tracer study alumni yang tersedia di sistem.</p>
                </div>
                <div class="akila-header-actions">
                    <div id="export-buttons-container" class="d-inline-flex gap-1"></div>
                </div>
            </div>

            <!-- Compact Stats Strip -->
            <div class="akila-stats-strip">
                <div class="akila-stat-chip">
                    <i class="fa fa-users text-primary"></i>
                    <span>Total Alumni: <strong>{{ $totalAlumni }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-check-circle text-success"></i>
                    <span>Sudah Mengisi: <strong>{{ $sudahMengisi }}</strong> ({{ $totalAlumni > 0 ? round(($sudahMengisi / $totalAlumni) * 100, 1) : 0 }}%)</span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-clock text-warning"></i>
                    <span>Belum Mengisi: <strong>{{ $belumMengisi }}</strong></span>
                </div>
            </div>

            <!-- Length & Filter Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
                <div class="akila-stat-chip">
                    <i class="fa fa-database text-muted"></i>
                    <span>Ditampilkan: <strong id="totalRecords">0</strong> Data</span>
                </div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table class="table akila-table align-middle w-100" id="datatable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-tracer">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Alumni</th>
                            <th>Instansi / Keterangan</th>
                            <th>Status Karier</th>
                            <th>Tanggal Mengisi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 110px;">Aksi</th>
                        </tr>
                        <tr class="akila-filter-row">
                            <th></th>
                            <th class="text-center"><span class="akila-no-pill">No</span></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="2" placeholder="Cari nama alumni...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari perusahaan / kampus...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select" id="filter-status">
                                    <option value="">Semua Kategori</option>
                                    <option value="bekerja_full">Bekerja</option>
                                    <option value="wirausaha">Wiraswasta</option>
                                    <option value="lanjutstudy">Lanjut Studi</option>
                                    <option value="belum_bekerja">Belum Bekerja</option>
                                    <option value="tidak">Tidak Kerja</option>
                                </select>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="5" placeholder="Cari tanggal...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="6">
                                    <option value="">Semua Status</option>
                                    <option value="SUBMITTED">Submitted</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            const userRole = $('meta[name="user-role"]').attr('content');

            const table = $('#datatable').DataTable({
                processing: true,
                serverSide: false,
                ordering: true,
                orderCellsTop: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                ajax: {
                    url: "{{ route('listtraceralumni.index') }}",
                    data: function (d) {
                        d.status = $('#filter-status').val();
                    },
                    dataSrc: function (json) {
                        const rows = json.data || [];
                        $('#totalRecords').text(rows.length);
                        return rows;
                    }
                },
                dom: "lBrt<'row align-items-center mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-sm',
                        text: '<i class="fa fa-file-excel text-success me-1"></i> Excel',
                        exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
                        filename: 'Rekap_Tracer_Alumni',
                        title: 'Rekap Data Tracer Alumni'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-sm',
                        text: '<i class="fa fa-file-pdf text-danger me-1"></i> PDF',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
                        filename: 'Rekap_Tracer_Alumni',
                        title: 'Rekap Data Tracer Alumni'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm',
                        text: '<i class="fa fa-print text-secondary me-1"></i> Cetak',
                        exportOptions: { columns: [1, 2, 3, 4, 5, 6] },
                        title: 'Rekap Data Tracer Alumni'
                    }
                ],
                initComplete: function () {
                    $('#entries-container').empty().append($('.dataTables_length').detach());
                    $('#export-buttons-container').empty().append(table.buttons().container());
                },
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: row => `<input type="checkbox" class="form-check-input akila-checkbox row-check" value="${row.id}">`
                    },
                    {
                        data: null,
                        className: 'text-center text-muted fw-semibold',
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'nama_alumni',
                        render: function (data, type, row) {
                            const nama = data || (row.alumni && row.alumni.nama_lengkap ? row.alumni.nama_lengkap : '-');
                            const nim = row.alumni && row.alumni.nim ? 'NIM: ' + row.alumni.nim : '';
                            return `
                                <div class="akila-cell-title">${nama}</div>
                                ${nim ? `<div class="akila-cell-desc" style="font-size:0.75rem;">${nim}</div>` : ''}`;
                        }
                    },
                    {
                        data: 'detail_info',
                        render: data => `<span class="akila-cell-desc">${data && data !== '-' ? data : 'Belum ada keterangan instansi'}</span>`
                    },
                    {
                        data: 'status_pekerjaan',
                        render: function (data) {
                            const map = {
                                'bekerja_full': '<span class="akila-badge akila-badge-outline">Bekerja Full-Time</span> <span class="akila-badge akila-badge-orange">Industri</span>',
                                'wirausaha': '<span class="akila-badge akila-badge-purple">Wiraswasta</span> <span class="akila-badge akila-badge-orange">Usaha Mandiri</span>',
                                'lanjutstudy': '<span class="akila-badge akila-badge-blue">Lanjut Studi</span>',
                                'belum_bekerja': '<span class="akila-badge akila-badge-amber">Mencari Kerja</span>',
                                'tidak': '<span class="akila-badge akila-badge-slate">Tidak Bekerja</span>'
                            };
                            return `<div class="d-flex flex-wrap gap-1">${map[data] || `<span class="akila-badge akila-badge-slate">${data || '-'}</span>`}</div>`;
                        }
                    },
                    {
                        data: 'created_at',
                        render: data => {
                            const formatted = data ? new Date(data).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';
                            return `
                                <div class="akila-person">
                                    <span class="akila-person-avatar"><i class="far fa-calendar-alt"></i></span>
                                    <span>${formatted}</span>
                                </div>`;
                        }
                    },
                    {
                        data: null,
                        className: 'text-center',
                        render: () => `
                            <div class="akila-status-stack">
                                <span class="akila-badge akila-badge-green">SUBMITTED</span>
                                <span class="akila-substatus-ok">Lengkap</span>
                            </div>`
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data) {
                            return `
                                <div class="akila-actions">
                                    <a href="/listtraceralumni/${data.id}" class="akila-action-btn" title="Lihat Detail">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    ${userRole === 'admin' ? `
                                    <a href="/listtraceralumni/${data.id}/edit" class="akila-action-btn act-edit" title="Edit Data">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <button type="button" class="akila-action-btn act-delete btn-delete" data-id="${data.id}" title="Hapus Data">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    ` : ''}
                                </div>`;
                        }
                    }
                ],
                order: [[1, 'asc']],
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data tersedia',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    zeroRecords: 'Tidak ada data tracer yang cocok.',
                    emptyTable: 'Belum ada data tracer alumni tersedia.',
                    paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' }
                }
            });

            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            $(document).on('keyup change', '#datatable .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#datatable .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $('#filter-status').on('change', function () {
                table.ajax.reload();
            });

            $('#check-all-tracer').on('change', function () {
                $('#datatable .row-check').prop('checked', this.checked);
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#datatable').on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    html: '<p class="mb-0">Data kuesioner yang dihapus tidak dapat dikembalikan.</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal-modern',
                        confirmButton: 'btn-modern btn-modern-danger',
                        cancelButton: 'btn-modern btn-modern-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/listtraceralumni/${id}`,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function (res) {
                                table.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1800,
                                    showConfirmButton: false,
                                    customClass: { popup: 'swal-modern' }
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Tidak dapat menghapus data.',
                                    customClass: { popup: 'swal-modern' }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
