@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-primary-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-graduation-cap text-primary"></i>
                        </span>
                        Data Alumni
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Kelola data alumni aktif, DO, dan cuti dengan sistem yang lebih cerdas dan modern.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="card card-modern overflow-hidden shadow-sm border-0">
            <div class="card-body p-4">
                <!-- Modern Table Toolbar -->
                <div class="table-toolbar mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-xl-8">
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <!-- Angkatan Filter -->
                                <div class="d-flex align-items-center bg-white p-2 px-3 rounded-pill border shadow-sm">
                                    <label for="filter-tahun" class="mb-0 me-2 fw-bold text-muted fs-xs text-uppercase">
                                        <i class="fa fa-calendar-alt text-primary me-1"></i> Angkatan
                                    </label>
                                    <select id="filter-tahun" name="tahun_angkatan" class="form-select form-select-sm border-0 bg-transparent fw-bold text-primary p-0 h-auto" style="width: auto; min-width: 80px;">
                                        <option value="">Semua</option>
                                        @php $tahunSekarang = date('Y'); @endphp
                                        @for ($i = $tahunSekarang; $i >= 2018; $i--)
                                            <option value="{{ $i }}" {{ request('tahun_angkatan') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Total Badge -->
                                <div class="bg-primary-light text-primary px-3 py-2 rounded-pill shadow-sm fs-sm fw-bold border border-primary-lighter">
                                    <i class="fa fa-graduation-cap me-1"></i> <span id="jumlah-alumni">0</span> <small class="text-uppercase ms-1 opacity-75">Alumni</small>
                                </div>

                                <div id="entries-container" class="ms-md-auto"></div>
                            </div>
                        </div>
                        
                        <!-- Search Group -->
                        <div class="col-12 col-xl-4 text-xl-end">
                            <div class="input-group input-group-modern shadow-sm border rounded-pill overflow-hidden bg-white">
                                <span class="input-group-text border-0 bg-white ps-3">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                                <input type="text" id="customSearch" class="form-control border-0 fs-sm" placeholder="Cari data alumni...">
                                <button class="btn btn-primary px-4 fw-semibold" id="searchBtn">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table id="tabel-alumni" class="table align-middle table-hover js-dataTable-full w-100 border-0">
                        <thead>
                            <tr class="bg-light text-muted text-uppercase fs-xs fw-bold border-0">
                                <th class="py-3 px-4 border-0">NIM</th>
                                <th class="py-3 border-0">Nama</th>
                                <th class="py-3 border-0">Prodi</th>
                                <th class="py-3 border-0">Kelas</th>
                                <th class="py-3 border-0">Lulus</th>
                                <th class="py-3 border-0">Status</th>
                                <th class="py-3 border-0 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalViewMahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden rounded-4">
                <div class="modal-header bg-primary py-3 px-4 border-0">
                    <h5 class="modal-title text-white mb-0 fw-bold">
                        <i class="fa-solid fa-graduation-cap me-2"></i>Detail Alumni
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4" id="modal-detail-content">
                    <!-- Content will be injected by JS -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table;

        function initDataTable(tahun) {
            if (table) { table.destroy(); $('#tabel-alumni tbody').html(''); }

            table = $('#tabel-alumni').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                pageLength: 10,
                autoWidth: false,
                dom: "<'row mt-3 mb-1'<'col-sm-12'B>>" +
                     "<'row'<'col-sm-12 table-responsive'tr>>" +
                     "<'row mt-3'<'col-sm-12 col-md-5 fs-sm text-muted'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                buttons: [
                    { extend: 'excelHtml5', className: 'btn btn-sm btn-success rounded-pill px-3 shadow-sm border-0 me-2', text: '<i class="fa fa-file-excel me-1"></i> Excel' },
                    { extend: 'pdfHtml5', className: 'btn btn-sm btn-danger rounded-pill px-3 shadow-sm border-0 me-2', text: '<i class="fa fa-file-pdf me-1"></i> PDF', orientation: 'landscape', pageSize: 'A4' },
                    { extend: 'print', className: 'btn btn-sm btn-info rounded-pill px-3 shadow-sm border-0', text: '<i class="fa fa-print me-1"></i> Cetak' }
                ],
                initComplete: function() {
                    $('#entries-container').empty();
                    let lengthMenu = $('.dataTables_length').detach();
                    $('#entries-container').append(lengthMenu);
                },
                ajax: {
                    url: '{{ route('api.alumni') }}',
                    type: 'GET',
                    data: d => ({ tahun_angkatan: $('#filter-tahun').val() }),
                    dataSrc: json => {
                        $('#jumlah-alumni').text(json.data.length);
                        return json.data;
                    }
                },
                columns: [
                    { data: 'nim', render: data => `<span class="fw-medium text-muted">${data}</span>` },
                    { data: 'nama_lengkap', render: (data, type, row) => `
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data)}&background=random" class="rounded-pill me-2 shadow-sm" style="width:32px; height:32px;">
                            <div class="fw-bold text-dark">${data}</div>
                        </div>
                    `},
                    { data: 'prodi', render: data => `<span class="badge bg-primary-light text-primary border border-primary-10 rounded-pill px-2 py-1 fs-xs">${data}</span>` },
                    { data: 'kelas', className: 'text-center' },
                    { data: 'tahun_lulus', className: 'text-center fw-bold text-muted' },
                    { data: 'status_mahasiswa', render: data => {
                        const colors = {'Lulus':'bg-success','Aktif':'bg-primary','Cuti':'bg-warning text-dark','DO':'bg-danger'};
                        return `<span class="badge ${colors[data]||'bg-secondary'} rounded-pill px-2 py-1 fs-xs border shadow-sm">${data}</span>`;
                    }},
                    {
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: data => `
                            <button class="btn btn-sm btn-white rounded-pill px-3 shadow-sm border btn-view"
                                data-bs-toggle="modal" data-bs-target="#modalViewMahasiswa"
                                data-nim="${data.nim}" data-nama="${data.nama_lengkap}"
                                data-prodi="${data.prodi}" data-alamat="${data.alamat}"
                                data-no_hp="${data.no_hp}" data-kelas="${data.kelas}"
                                data-jalur="${data.jalur}" data-tahun_masuk="${data.tahun_masuk}"
                                data-tahun_lulus="${data.tahun_lulus}" data-status="${data.status_mahasiswa}"
                                data-updated="${data.updated_at}">
                                <i class="fa fa-eye text-primary"></i>
                            </button>
                        `
                    }
                ]
            });
        }

        $(document).ready(function() {
            initDataTable($('#filter-tahun').val());
            $('#filter-tahun').on('change', function() { initDataTable($(this).val()); });

            $('#searchBtn').on('click', () => table.search($('#customSearch').val()).draw());
            $('#customSearch').on('keyup', e => { if (e.key === 'Enter') $('#searchBtn').click(); });

            $(document).on('click', '.btn-view', function() {
                const d = $(this).data();
                const colors = {'Lulus':'bg-success','Aktif':'bg-primary','Cuti':'bg-warning text-dark','DO':'bg-danger'};
                const badgeClass = colors[d.status] || 'bg-secondary';

                $('#modal-detail-content').html(`
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(d.nama)}&size=100&background=random" class="rounded-circle mb-3 shadow" style="width:100px; height:100px; border:3px solid #fff;">
                        <h4 class="fw-bold mb-1">${d.nama}</h4>
                        <span class="badge ${badgeClass} rounded-pill px-3 py-2 border shadow-sm">${d.status}</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">NIM</small><strong>${d.nim}</strong></div></div>
                        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Program Studi</small><strong>${d.prodi}</strong></div></div>
                        <div class="col-md-12"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Alamat</small><strong>${d.alamat || '-'}</strong></div></div>
                        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">No. HP</small><strong>${d.no_hp || '-'}</strong></div></div>
                        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Kelas / Jalur</small><strong>${d.kelas} / ${d.jalur}</strong></div></div>
                        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Tahun Masuk</small><strong>${d.tahun_masuk}</strong></div></div>
                        <div class="col-md-6"><div class="p-3 bg-light rounded-3"><small class="text-muted d-block">Tahun Lulus</small><strong>${d.tahun_lulus}</strong></div></div>
                    </div>
                `);
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .bg-primary-light { background-color: rgba(6, 101, 208, 0.08); }
        .border-primary-10 { border-color: rgba(6, 101, 208, 0.15) !important; }
        .bg-primary-lighter { background-color: rgba(6, 101, 208, 0.1); }
        .btn-white { background: #fff; }
        .btn-white:hover { background: #f8fafc; }
        .card-modern { border-radius: 1rem; }
    </style>
@endsection
