@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Bursa Kerja</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Lamaran Alumni</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Lamaran Masuk Alumni</h1>
                    <p class="akila-subtitle">Kelola dan tinjau semua berkas lamaran pekerjaan yang dikirim oleh alumni di sistem.</p>
                </div>
                <div class="akila-header-actions">
                    <div id="export-buttons-container" class="d-inline-flex gap-1"></div>
                    <a href="{{ route('admin.loker.index') }}" class="btn-akila-dark">
                        <i class="fa fa-briefcase"></i> Kelola Lowongan
                    </a>
                </div>
            </div>

            <!-- Compact Stats Strip -->
            <div class="akila-stats-strip">
                <div class="akila-stat-chip">
                    <i class="fa fa-layer-group text-primary"></i>
                    <span>Total: <strong>{{ $stats['total'] }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-paper-plane text-warning"></i>
                    <span>Dilamar: <strong>{{ $stats['applied'] }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-eye text-info"></i>
                    <span>Ditinjau: <strong>{{ $stats['reviewed'] }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-check-circle text-success"></i>
                    <span>Diterima: <strong>{{ $stats['accepted'] }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-times-circle text-danger"></i>
                    <span>Ditolak: <strong>{{ $stats['rejected'] }}</strong></span>
                </div>
            </div>

            <!-- Length Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table class="table akila-table align-middle w-100" id="tabel-lamaran">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-apps">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Pelamar (Alumni)</th>
                            <th>Posisi & Perusahaan</th>
                            <th>Ekspektasi & Berkas</th>
                            <th>Tanggal Melamar</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 115px;">Aksi</th>
                        </tr>
                        <tr class="akila-filter-row">
                            <th></th>
                            <th class="text-center"><span class="akila-no-pill">No</span></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="2" placeholder="Cari alumni / NIM...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari posisi / PT...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="4" placeholder="Cari gaji / berkas...">
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
                                    <option value="DILAMAR">Dilamar</option>
                                    <option value="DITINJAU">Ditinjau</option>
                                    <option value="DITERIMA">Diterima</option>
                                    <option value="DITOLAK">Ditolak</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $index => $app)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input akila-checkbox row-check" value="{{ $app->id }}">
                                </td>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="akila-person">
                                        <span class="akila-person-avatar"><i class="fa fa-user"></i></span>
                                        <div>
                                            <div class="akila-cell-title">{{ $app->alumni->nama_lengkap ?? '-' }}</div>
                                            <div class="akila-cell-desc" style="font-size: 0.75rem;">
                                                NIM: {{ $app->alumni->nim ?? '-' }}
                                                @if($app->phone)
                                                    &bull; <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $app->phone) }}" target="_blank" class="text-success text-decoration-none">{{ $app->phone }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="akila-cell-title">{{ $app->jobVacancy->position ?? '-' }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.76rem;">{{ $app->jobVacancy->company_name ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @if($app->cv_path)
                                            <span class="akila-badge akila-badge-outline">CV Terlampir</span>
                                        @endif
                                        @if($app->expected_salary)
                                            <span class="akila-badge akila-badge-orange">{{ $app->expected_salary }}</span>
                                        @endif
                                        @if($app->cover_letter)
                                            <span class="akila-badge akila-badge-blue">Cover Letter</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="akila-cell-title" style="font-size: 0.8rem;">{{ optional($app->applied_at)->translatedFormat('d M Y') ?? '-' }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.73rem;">{{ optional($app->applied_at)->translatedFormat('H:i') }} WIB</div>
                                </td>
                                <td class="text-center">
                                    @if($app->status === 'accepted')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-green">DITERIMA</span>
                                            <span class="akila-substatus-ok">Lengkap</span>
                                        </div>
                                    @elseif($app->status === 'reviewed')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-blue">DITINJAU</span>
                                            <span class="akila-substatus-muted">Proses Seleksi</span>
                                        </div>
                                    @elseif($app->status === 'rejected')
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-red">DITOLAK</span>
                                            <span class="akila-substatus-warn">Tidak Lolos</span>
                                        </div>
                                    @else
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-amber">DILAMAR</span>
                                            <span class="akila-substatus-muted">Baru Masuk</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="akila-actions">
                                        @if($app->cover_letter)
                                            <button type="button" class="akila-action-btn btn-view-letter"
                                                data-letter="{{ $app->cover_letter }}"
                                                data-name="{{ $app->alumni->nama_lengkap ?? '-' }}" title="Lihat Cover Letter">
                                                <i class="far fa-envelope"></i>
                                            </button>
                                        @endif
                                        @if($app->cv_path)
                                            <a href="{{ $app->cv_path }}" target="_blank" class="akila-action-btn" title="Lihat / Unduh CV">
                                                <i class="far fa-file-pdf"></i>
                                            </a>
                                        @endif
                                        <button type="button" class="akila-action-btn act-edit btn-update-status"
                                            data-id="{{ $app->id }}" data-status="{{ $app->status }}"
                                            data-name="{{ $app->alumni->nama_lengkap ?? '-' }}"
                                            data-position="{{ $app->jobVacancy->position ?? '-' }}"
                                            data-notes="{{ $app->admin_notes }}" title="Ubah Status Lamaran">
                                            <i class="far fa-edit"></i>
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

    <!-- Cover Letter Modal -->
    <div class="modal fade" id="modalCoverLetter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fa fa-envelope me-2"></i> Pesan dari <span id="letter-name">Alumni</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p id="letter-content" class="mb-0" style="white-space: pre-line; line-height: 1.6;"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="modalUpdateStatus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fw-bold text-white"><i class="fa fa-edit me-2"></i> Ubah Status Lamaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="update-app-id">
                    <p class="fw-bold mb-3 text-dark" id="update-info"></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status Baru</label>
                        <select id="update-status" class="form-select">
                            <option value="reviewed">Sedang Ditinjau</option>
                            <option value="accepted">Diterima</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Catatan Admin (Opsional)</label>
                        <textarea id="update-notes" class="form-control" rows="3" maxlength="500"
                            placeholder="Tuliskan catatan untuk alumni..."></textarea>
                    </div>
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn-akila-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn-akila-dark" id="btn-save-status">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function ($) {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            const table = $('#tabel-lamaran').DataTable({
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
                    { extend: 'pdfHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-pdf text-danger me-1"></i> PDF', orientation: 'landscape', exportOptions: { columns: [1, 2, 3, 4, 5, 6] } },
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
                    zeroRecords: 'Tidak ada lamaran yang cocok dengan pencarian.',
                    emptyTable: 'Belum ada lamaran masuk dari alumni.',
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

            $(document).on('keyup change', '#tabel-lamaran .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-lamaran .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $('#check-all-apps').on('change', function () {
                $('#tabel-lamaran .row-check').prop('checked', this.checked);
            });

            $(document).on('click', '.btn-view-letter', function () {
                $('#letter-name').text($(this).data('name'));
                $('#letter-content').text($(this).data('letter'));
                new bootstrap.Modal(document.getElementById('modalCoverLetter')).show();
            });

            $(document).on('click', '.btn-update-status', function () {
                const id = $(this).data('id');
                const status = $(this).data('status');
                const name = $(this).data('name');
                const position = $(this).data('position');
                const notes = $(this).data('notes');

                $('#update-app-id').val(id);
                $('#update-status').val(status === 'applied' ? 'reviewed' : status);
                $('#update-notes').val(notes || '');
                $('#update-info').text(name + ' — ' + position);

                new bootstrap.Modal(document.getElementById('modalUpdateStatus')).show();
            });

            $('#btn-save-status').on('click', function () {
                const btn = $(this);
                const id = $('#update-app-id').val();
                const status = $('#update-status').val();
                const notes = $('#update-notes').val();

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Menyimpan...');
                const url = "{{ route('admin.loker.application.update-status', ':id') }}".replace(':id', id);

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: { status: status, admin_notes: notes },
                    success: function (res) {
                        bootstrap.Modal.getInstance(document.getElementById('modalUpdateStatus')).hide();
                        Swal.fire('Berhasil', res.message, 'success').then(() => location.reload());
                    },
                    error: function (err) {
                        btn.prop('disabled', false).html('<i class="fa fa-save"></i> Simpan Perubahan');
                        const msg = err.responseJSON?.message || 'Gagal memperbarui status.';
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });
    </script>
@endsection
