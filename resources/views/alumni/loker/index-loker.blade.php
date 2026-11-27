@extends('layout')

@section('title', 'Riwayat Lamaran Kerja - Tracer Study TI UHN')

@section('content')
    <main id="main-container" class="main">
        <div class="container py-4">
            <!-- Breadcrumb -->
            <div class="akila-breadcrumb">
                <a href="{{ route('dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
                <span class="sep">&rsaquo;</span>
                <span class="active">Riwayat Lamaran Kerja</span>
            </div>

            <!-- Main Card -->
            <div class="akila-list-card">
                <div class="akila-card-header">
                    <div>
                        <h1 class="akila-title">Daftar Riwayat Lamaran Kerja</h1>
                        <p class="akila-subtitle">Pantau semua status lamaran pekerjaan yang telah Anda kirimkan melalui sistem bursa kerja.</p>
                    </div>
                    <div class="akila-header-actions">
                        <a href="{{ route('home') }}#loker" class="btn-akila-dark">
                            <i class="fa fa-plus"></i> Cari Lowongan Baru
                        </a>
                    </div>
                </div>

                <!-- Compact Stats Strip -->
                <div class="akila-stats-strip">
                    <div class="akila-stat-chip">
                        <i class="fa fa-layer-group text-secondary"></i>
                        <span>Semua: <strong>{{ $stats['total'] }}</strong></span>
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
                    <table class="table akila-table align-middle w-100" id="tabel-riwayat-alumni">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 56px;">No.</th>
                                <th>Posisi & Perusahaan</th>
                                <th>Catatan / Keterangan</th>
                                <th>Tipe & Lokasi</th>
                                <th class="text-center">Logo</th>
                                <th>Tanggal Melamar</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 80px;">Berkas</th>
                            </tr>
                            <tr class="akila-filter-row">
                                <th class="text-center"><span class="akila-no-pill">No</span></th>
                                <th>
                                    <div class="akila-filter-input">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="col-filter" data-col="1" placeholder="Cari posisi / PT...">
                                    </div>
                                </th>
                                <th>
                                    <div class="akila-filter-input">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="col-filter" data-col="2" placeholder="Cari catatan...">
                                    </div>
                                </th>
                                <th>
                                    <div class="akila-filter-input">
                                        <i class="fa fa-search"></i>
                                        <input type="text" class="col-filter" data-col="3" placeholder="Cari lokasi...">
                                    </div>
                                </th>
                                <th></th>
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
                            @foreach($applications as $idx => $app)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">{{ $idx + 1 }}</td>
                                    <td>
                                        <div class="akila-cell-title">{{ $app->jobVacancy->position ?? '-' }}</div>
                                        <div class="akila-cell-desc" style="font-size: 0.76rem;">{{ $app->jobVacancy->company_name ?? '-' }}</div>
                                    </td>
                                    <td>
                                        @if($app->admin_notes)
                                            <div class="akila-cell-desc">{{ $app->admin_notes }}</div>
                                        @else
                                            <span class="akila-cell-desc">Menunggu pembaruan catatan HR/Admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @if($app->jobVacancy?->category)
                                                <span class="akila-badge akila-badge-outline">{{ $app->jobVacancy->category }}</span>
                                            @endif
                                            @if($app->jobVacancy?->location)
                                                <span class="akila-badge akila-badge-orange">{{ $app->jobVacancy->location }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($app->jobVacancy?->logo_path)
                                            <img src="{{ $app->jobVacancy->logo_path }}" alt="Logo" class="akila-thumb">
                                        @else
                                            <span class="d-inline-flex align-items-center justify-content-center akila-thumb fw-bold text-muted" style="font-size: 0.72rem;">
                                                {{ strtoupper(substr($app->jobVacancy->company_name ?? 'PT', 0, 2)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="akila-cell-title" style="font-size: 0.8rem;">{{ optional($app->applied_at)->translatedFormat('d M Y') }}</div>
                                        <div class="akila-cell-desc" style="font-size: 0.73rem;">{{ optional($app->applied_at)->translatedFormat('H:i') }} WIB</div>
                                    </td>
                                    <td class="text-center">
                                        @if($app->status === 'accepted')
                                            <div class="akila-status-stack">
                                                <span class="akila-badge akila-badge-green">DITERIMA</span>
                                                <span class="akila-substatus-ok">Lolos Seleksi</span>
                                            </div>
                                        @elseif($app->status === 'reviewed')
                                            <div class="akila-status-stack">
                                                <span class="akila-badge akila-badge-blue">DITINJAU</span>
                                                <span class="akila-substatus-muted">Sedang Direview</span>
                                            </div>
                                        @elseif($app->status === 'rejected')
                                            <div class="akila-status-stack">
                                                <span class="akila-badge akila-badge-red">DITOLAK</span>
                                                <span class="akila-substatus-warn">Belum Sesuai</span>
                                            </div>
                                        @else
                                            <div class="akila-status-stack">
                                                <span class="akila-badge akila-badge-amber">DILAMAR</span>
                                                <span class="akila-substatus-ok">Terkirim</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="akila-actions">
                                            @if($app->cv_path)
                                                <a href="{{ $app->cv_path }}" target="_blank" class="akila-action-btn" title="Lihat CV Terkirim">
                                                    <i class="far fa-file-pdf"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function ($) {
            const table = $('#tabel-riwayat-alumni').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                dom: "lrt<'row align-items-center mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                columnDefs: [
                    { orderable: false, targets: [4, 7] }
                ],
                order: [[0, 'asc']],
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data tersedia',
                    zeroRecords: 'Tidak ada riwayat lamaran yang cocok.',
                    emptyTable: 'Anda belum mengirim lamaran pekerjaan.',
                    paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' }
                },
                initComplete: function () {
                    $('#entries-container').empty().append($('.dataTables_length').detach());
                }
            });

            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            $(document).on('keyup change', '#tabel-riwayat-alumni .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-riwayat-alumni .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });
        });
    </script>
@endpush
