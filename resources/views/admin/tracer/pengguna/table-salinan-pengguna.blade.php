@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Salinan Tracer Pengguna</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Salinan Tracer Pengguna</h1>
                    <p class="akila-subtitle">Kelola semua data rekapan penilaian pengguna lulusan yang tersedia di sistem.</p>
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
                    <span>Sudah Mengisi: <strong>{{ $sudahMengisi }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-clock text-warning"></i>
                    <span>Belum Mengisi: <strong>{{ $belumMengisi }}</strong></span>
                </div>
            </div>

            <!-- Length Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table class="table akila-table js-dataTable-full align-middle w-100" id="tabel-salinan-pengguna">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-sp">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Atasan / Pengguna</th>
                            <th>Perusahaan & Jabatan</th>
                            <th>Program Studi</th>
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
                                    <input type="text" class="col-filter" data-col="2" placeholder="Cari nama...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari perusahaan...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="4" placeholder="Cari prodi...">
                                </div>
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
                                    <option value="Lengkap">Lengkap</option>
                                    <option value="Belum Lengkap">Belum Lengkap</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $role = Auth::user()->role; @endphp
                        @foreach ($data as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input akila-checkbox row-check" value="{{ $item->id }}">
                                </td>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="akila-person">
                                        <span class="akila-person-avatar"><i class="fa fa-user"></i></span>
                                        <span class="akila-cell-title">{{ $item->nama }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="akila-cell-title">{{ $item->nama_perusahaan ?: '-' }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.76rem;">{{ $item->jabatan ?: '-' }}</div>
                                </td>
                                <td>
                                    <span class="akila-badge akila-badge-outline">{{ $item->prodi_name ?: 'Teknik Informatika' }}</span>
                                </td>
                                <td>
                                    <span class="akila-cell-desc">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="text-center">
                                    @if ($item->created_at)
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-green">SELESAI</span>
                                            <span class="akila-substatus-ok">Lengkap</span>
                                        </div>
                                    @else
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-amber">MENUNGGU</span>
                                            <span class="akila-substatus-warn">Belum Lengkap</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="akila-actions">
                                        <a href="{{ route('listtracerpengguna.show', $item->id) }}" class="akila-action-btn" title="Detail">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        @if ($role !== 'superadmin')
                                            <a href="{{ route('listtracerpengguna.edit', $item->id) }}" class="akila-action-btn act-edit" title="Edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <button type="button" class="akila-action-btn act-delete btn-hapus"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" title="Hapus">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form id="form-hapus" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            const table = $('#tabel-salinan-pengguna').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                dom: "lBrt<'row align-items-center mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                buttons: [
                    { extend: 'excelHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-excel text-success me-1"></i> Excel', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } },
                    { extend: 'pdfHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-pdf text-danger me-1"></i> PDF', orientation: 'landscape', pageSize: 'A4', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } },
                    { extend: 'print', className: 'btn btn-sm', text: '<i class="fa fa-print text-secondary me-1"></i> Cetak', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } }
                ],
                columnDefs: [
                    { orderable: false, targets: [0, 7] }
                ],
                order: [[1, 'asc']],
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data tersedia',
                    zeroRecords: 'Tidak ada data yang cocok.',
                    emptyTable: 'Belum ada data salinan tracer pengguna.',
                    paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' }
                },
                initComplete: function () {
                    $('#entries-container').empty().append($('.dataTables_length').detach());
                    $('#export-buttons-container').empty().append(table.buttons().container());
                }
            });

            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            $(document).on('keyup change', '#tabel-salinan-pengguna .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-salinan-pengguna .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $('#check-all-sp').on('change', function () {
                $('#tabel-salinan-pengguna .row-check').prop('checked', this.checked);
            });

            $(document).on('click', '.btn-hapus', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                Swal.fire({
                    title: 'Hapus Data?',
                    html: `Yakin ingin menghapus <b>${nama}</b> dari daftar salinan tracer?`,
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
                        let url = "{{ route('listtracerpengguna.destroy', ':id') }}".replace(':id', id);
                        $('#form-hapus').attr('action', url).submit();
                    }
                });
            });
        });
    </script>
@endsection
