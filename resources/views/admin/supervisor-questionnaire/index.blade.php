@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Survei Pengguna</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Survei Pengguna (Atasan)</h1>
                    <p class="akila-subtitle">Kelola semua data kuesioner penilaian atasan/pengguna lulusan yang tersedia di sistem.</p>
                </div>
                <div class="akila-header-actions">
                    <div id="export-buttons-container" class="gap-1 d-inline-flex"></div>
                    <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn-akila-dark">
                        <i class="fa fa-chart-pie"></i> Ringkasan Statistik
                    </a>
                </div>
            </div>

            <!-- Compact Stats Strip -->
            <div class="akila-stats-strip">
                <div class="akila-stat-chip">
                    <i class="fa fa-clipboard-list text-primary"></i>
                    <span>Total: <strong>{{ $totalQuestionnaires }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-check-circle text-success"></i>
                    <span>Selesai: <strong>{{ $completedQuestionnaires }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-clock text-warning"></i>
                    <span>Menunggu: <strong>{{ $pendingQuestionnaires }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-exclamation-circle text-danger"></i>
                    <span>Kadaluarsa: <strong>{{ $expiredQuestionnaires }}</strong></span>
                </div>
            </div>

            <!-- Length Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table class="table align-middle akila-table js-dataTable-full w-100" id="tabel-supervisor">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-sup">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Alumni</th>
                            <th>Perusahaan & Posisi</th>
                            <th>Tipe Evaluasi</th>
                            <th>Nama Supervisor</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 110px;">Aksi</th>
                        </tr>
                        <tr class="akila-filter-row">
                            <th></th>
                            <th class="text-center"><span class="akila-no-pill">No</span></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="2" placeholder="Cari alumni...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari perusahaan...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="4">
                                    <option value="">Semua Kontak</option>
                                    <option value="Email">Email</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                </select>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="5" placeholder="Cari supervisor...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="6">
                                    <option value="">Semua Status</option>
                                    <option value="SELESAI">Selesai</option>
                                    <option value="TERKIRIM">Terkirim</option>
                                    <option value="MENUNGGU">Menunggu</option>
                                    <option value="KADALUARSA">Kadaluarsa</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input akila-checkbox row-check" value="{{ $item->id }}">
                                </td>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="akila-cell-title">{{ $item->nama_alumni }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.76rem;">{{ $item->jabatan_alumni ?: 'Alumni Terdata' }}</div>
                                </td>
                                <td>
                                    <div class="akila-cell-title">{{ $item->nama_perusahaan ?: '-' }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.76rem;">Jabatan Atasan: {{ $item->jabatan_atasan ?: '-' }}</div>
                                </td>
                                <td>
                                    <div class="flex-wrap gap-1 d-flex">
                                        <span class="akila-badge akila-badge-outline">Survei Industri</span>
                                        @if ($item->email_atasan)
                                            <span class="akila-badge akila-badge-blue">Email</span>
                                        @endif
                                        @if ($item->wa_atasan)
                                            <span class="akila-badge akila-badge-orange">WhatsApp</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="akila-person">
                                        <span class="akila-person-avatar"><i class="fa fa-user"></i></span>
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size: 0.83rem;">{{ $item->nama_atasan ?: '-' }}</div>
                                            <div class="text-muted" style="font-size: 0.73rem;">{{ $item->email_atasan ?: ($item->wa_atasan ?: '') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                        $rowHasScores = !empty($item->integritas) && !empty($item->keahlian) && !empty($item->kemampuan);
                                        $rowExpired = !$rowHasScores && $item->status_pengisian !== 'completed' && $item->expires_at && $item->expires_at < now();
                                    @endphp
                                    @if ($item->status_pengisian == 'completed' || $rowHasScores)
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-green">SELESAI</span>
                                            <span class="akila-substatus-ok">Lengkap (7/7)</span>
                                        </div>
                                    @elseif($rowExpired || $item->status_pengisian == 'expired')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-red">KADALUARSA</span>
                                            <span class="akila-substatus-warn">Belum Diisi (0/7)</span>
                                        </div>
                                    @elseif($item->status_pengisian == 'sent')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-blue">TERKIRIM</span>
                                            <span class="akila-substatus-muted">Menunggu Atasan (0/7)</span>
                                        </div>
                                    @else
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-amber">MENUNGGU</span>
                                            <span class="akila-substatus-warn">Belum Diisi (0/7)</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="akila-actions">
                                        <a href="{{ route('admin.supervisor-questionnaire.show', $item->id) }}"
                                            class="akila-action-btn" title="Lihat Detail">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.supervisor-questionnaire.edit', $item->id) }}"
                                            class="akila-action-btn act-edit" title="Edit Data">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <button type="button" class="akila-action-btn act-approve"
                                            title="Kirim Ulang Notifikasi" onclick="resendNotification({{ $item->id }})">
                                            <i class="far fa-paper-plane"></i>
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
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            const tableEl = $('#tabel-supervisor');
            if (!tableEl.length) return;

            const table = tableEl.DataTable({
                paging: true,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
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
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    zeroRecords: 'Tidak ada kuesioner atasan yang cocok.',
                    emptyTable: 'Belum ada data survei pengguna lulusan.',
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

            $(document).on('keyup change', '#tabel-supervisor .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-supervisor .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $('#check-all-sup').on('change', function () {
                $('#tabel-supervisor .row-check').prop('checked', this.checked);
            });

            window.resendNotification = function (id) {
                Swal.fire({
                    title: 'Kirim Ulang Notifikasi?',
                    text: 'Apakah Anda yakin ingin mengirim ulang link survei ke atasan ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal-modern',
                        confirmButton: 'btn-modern btn-modern-primary',
                        cancelButton: 'btn-modern btn-modern-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('admin.supervisor-questionnaire.resend-notification', ':id') }}";
                        window.location.href = url.replace(':id', id);
                    }
                });
            };
        });
    </script>
@endsection
