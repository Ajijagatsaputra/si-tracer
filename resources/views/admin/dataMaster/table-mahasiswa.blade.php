@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Mahasiswa</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Mahasiswa</h1>
                    <p class="akila-subtitle">Kelola semua data mahasiswa aktif, cuti, lulus, dan DO yang terintegrasi SIAKAD.</p>
                </div>
                <div class="akila-header-actions">
                    <div class="gap-2 d-inline-flex align-items-center">
                        <label for="filter-tahun" class="mb-0 text-muted" style="font-size: 0.8rem; font-weight: 600;">Angkatan:</label>
                        <select id="filter-tahun" class="akila-length-select" style="min-width: 110px;"></select>
                    </div>
                    <div id="export-buttons-container" class="gap-1 d-inline-flex"></div>
                </div>
            </div>

            <!-- Alert Banner Responsif saat API OASE Offline -->
            <div id="oase-offline-banner" class="akila-alert-banner is-hidden" role="alert">
                <div class="akila-alert-body">
                    <div class="akila-alert-icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <div class="akila-alert-content">
                        <div class="akila-alert-title">Koneksi Server SIAKAD / OASE Tertunda</div>
                        <p class="akila-alert-desc" id="oase-offline-msg">
                            Koneksi ke server API OASE (api.oase.poltektegal.ac.id) timeout / sedang gangguan. Silakan coba muat ulang beberapa saat lagi.
                        </p>
                    </div>
                </div>
                <div class="akila-alert-actions">
                    <button type="button" id="btn-retry-oase" class="btn-akila-retry">
                        <i class="fa fa-sync-alt" id="icon-retry-oase"></i>
                        <span id="text-retry-oase">Coba Lagi</span>
                    </button>
                    <button type="button" id="btn-close-oase-alert" class="btn-akila-alert-close" title="Sembunyikan peringatan" aria-label="Tutup">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Length & Summary Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
                <div class="akila-stat-chip">
                    <i class="fa fa-users text-muted"></i>
                    <span>Total Terdata: <strong id="jumlah-mahasiswa">0</strong> Mahasiswa</span>
                </div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table id="tabel-mahasiswa" class="table align-middle akila-table js-dataTable-full w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-mhs">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Mahasiswa</th>
                            <th>NIM</th>
                            <th>Program Studi & Kelas</th>
                            <th>Jalur & Semester</th>
                            <th>Angkatan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 80px;">Aksi</th>
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
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari NIM...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="4" placeholder="Cari prodi / kelas...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="5" placeholder="Cari jalur...">
                                </div>
                            </th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="6" placeholder="Tahun...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="7">
                                    <option value="">Semua Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="DO">DO</option>
                                    <option value="Keluar">Keluar</option>
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

    <!-- Modal Detail -->
    <div class="modal fade" id="modalViewMahasiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="overflow-hidden border-0 shadow-lg modal-content rounded-4">
                <button type="button"
                    class="top-0 p-2 m-3 shadow-sm btn-close btn-close-white position-absolute end-0 z-3 bg-dark/20 backdrop-blur rounded-circle"
                    data-bs-dismiss="modal" aria-label="Tutup"
                    style="width: 32px; height: 32px; font-size: 0.75rem; border: none;"></button>
                <div class="p-0 modal-body">
                    <div class="row g-0">
                        <div class="p-4 py-5 text-white col-lg-5 position-relative d-flex flex-column align-items-center justify-content-center"
                            style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); min-height: 360px;">
                            <div class="px-3 text-center z-1 w-100">
                                <img id="view-avatar" class="mb-3 shadow-sm rounded-circle" alt="Avatar Mahasiswa"
                                    style="width:96px; height:96px; object-fit:cover; border: 3px solid #fff;">
                                <div class="mb-2"><span id="view-status-badge" class="akila-badge akila-badge-green">Aktif</span></div>
                                <h3 class="mb-1 text-white fw-bold fs-5" id="view-nama"></h3>
                                <p class="mb-3 text-white-50 fs-xs" id="view-prodi"></p>
                                <div class="gap-2 d-flex justify-content-center" id="view-wa-btn"></div>
                            </div>
                        </div>
                        <div class="p-4 bg-white col-lg-7">
                            <h5 class="mb-1 fw-bold text-dark">Detail Informasi Akademik</h5>
                            <p class="pb-2 mb-3 text-muted fs-xs border-bottom">Informasi status perkuliahan mahasiswa SIAKAD</p>
                            <div class="row g-3 fs-sm">
                                <div class="col-6"><span class="text-muted d-block fs-xs">NIM</span><strong id="view-nim" class="text-dark"></strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Kelas</span><strong id="view-kelas" class="text-dark"></strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Jalur Masuk</span><strong id="view-jalur" class="text-dark"></strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Tahun Masuk</span><strong id="view-tahun" class="text-dark"></strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">Semester Aktif</span><strong id="view-semester" class="text-dark"></strong></div>
                                <div class="col-6"><span class="text-muted d-block fs-xs">WhatsApp</span><strong id="view-telp" class="text-dark"></strong></div>
                            </div>
                            <div class="pt-3 mt-4 border-top text-end">
                                <button type="button" class="btn-akila-outline" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table;

        function renderStatusCell(status) {
            const s = status || '-';
            const badgeMap = {
                'Aktif': 'akila-badge-green',
                'Lulus': 'akila-badge-blue',
                'Cuti': 'akila-badge-amber',
                'DO': 'akila-badge-red',
                'Keluar': 'akila-badge-slate'
            };
            const subMap = {
                'Aktif': '<span class="akila-substatus-ok">Terdaftar</span>',
                'Lulus': '<span class="akila-substatus-ok">Selesai Studi</span>',
                'Cuti': '<span class="akila-substatus-muted">Non-Aktif Sementara</span>',
                'DO': '<span class="akila-substatus-warn">Putus Studi</span>',
                'Keluar': '<span class="akila-substatus-muted">Mengundurkan Diri</span>'
            };
            return `
                <div class="akila-status-stack">
                    <span class="akila-badge ${badgeMap[s] || 'akila-badge-slate'}">${s.toUpperCase()}</span>
                    ${subMap[s] || ''}
                </div>`;
        }

        let forceOaseRefresh = false;

        function setRetryLoadingState(isLoading) {
            const btn = $('#btn-retry-oase');
            const icon = $('#icon-retry-oase');
            const text = $('#text-retry-oase');
            btn.prop('disabled', isLoading);
            if (isLoading) {
                icon.addClass('fa-spin');
                text.text('Menghubungkan...');
            } else {
                icon.removeClass('fa-spin');
                text.text('Coba Lagi');
            }
        }

        function initDataTable() {
            $.fn.dataTable.ext.errMode = 'none';

            $('#tabel-mahasiswa').off('error.dt').on('error.dt', function (e, settings, techNote, message) {
                console.error('DataTables Error:', message);
                setRetryLoadingState(false);
            });

            table = $('#tabel-mahasiswa').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                processing: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                order: [[1, 'asc']],
                dom: "lBrt<'row align-items-center mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-md-end'p>>",
                language: {
                    processing: '<span class="text-dark fw-medium" style="font-size:0.82rem;"><i class="fa fa-circle-notch fa-spin text-warning me-2"></i>Menghubungi server API OASE...</span>',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data tersedia',
                    infoFiltered: '(difilter dari _MAX_ total data)',
                    zeroRecords: 'Tidak ada data mahasiswa yang cocok.',
                    emptyTable: 'Belum ada data mahasiswa yang dapat ditampilkan saat ini.',
                    paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' }
                },
                buttons: [
                    { extend: 'excelHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-excel text-success me-1"></i> Excel', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7] } },
                    { extend: 'pdfHtml5', className: 'btn btn-sm', text: '<i class="fa fa-file-pdf text-danger me-1"></i> PDF', orientation: 'landscape', pageSize: 'A4', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7] } },
                    { extend: 'print', className: 'btn btn-sm', text: '<i class="fa fa-print text-secondary me-1"></i> Cetak', exportOptions: { columns: [1, 2, 3, 4, 5, 6, 7] } }
                ],
                initComplete: function () {
                    $('#entries-container').empty().append($('.dataTables_length').detach());
                    $('#export-buttons-container').empty().append(table.buttons().container());
                },
                ajax: {
                    url: '{{ route('api.mahasiswa') }}',
                    type: 'GET',
                    data: function () {
                        const payload = {
                            tahun_angkatan: $('#filter-tahun').val(),
                            refresh: forceOaseRefresh ? 1 : 0
                        };
                        forceOaseRefresh = false;
                        return payload;
                    },
                    dataSrc: json => {
                        setRetryLoadingState(false);
                        const banner = $('#oase-offline-banner');
                        if (json && json.offline) {
                            $('#oase-offline-msg').text(json.message || 'Server API OASE sedang tidak merespons (timeout).');
                            banner.removeClass('is-hidden');
                        } else {
                            banner.addClass('is-hidden');
                        }
                        const rows = json && json.status && Array.isArray(json.data) ? json.data : [];
                        $('#jumlah-mahasiswa').text(rows.length);
                        return rows;
                    },
                    error: function () {
                        setRetryLoadingState(false);
                        $('#jumlah-mahasiswa').text('0');
                        $('#oase-offline-banner').removeClass('is-hidden');
                    }
                },
                columns: [
                    {
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: row => `<input type="checkbox" class="form-check-input akila-checkbox row-check" value="${row.nim || ''}">`
                    },
                    {
                        data: null,
                        defaultContent: '-',
                        className: 'text-center text-muted fw-semibold',
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'nama_lengkap',
                        defaultContent: '-',
                        render: (data, type, row) => {
                            const name = data || '-';
                            const avatar = row.avatar_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=e2e8f0&color=334155&bold=true`;
                            return `
                                <div class="gap-2 d-flex align-items-center">
                                    <img src="${avatar}" alt="" class="akila-person-avatar" style="width:30px;height:30px;">
                                    <div class="akila-cell-title">${name}</div>
                                </div>`;
                        }
                    },
                    {
                        data: 'nim',
                        defaultContent: '-',
                        render: data => `<span class="fw-semibold text-dark">${data || '-'}</span>`
                    },
                    {
                        data: null,
                        defaultContent: '-',
                        render: row => `
                            <div class="flex-wrap gap-1 d-flex">
                                <span class="akila-badge akila-badge-outline">${row.prodi?.nama || row.prodi || 'N/A'}</span>
                                ${row.kelas ? `<span class="akila-badge akila-badge-orange">Kelas ${row.kelas}</span>` : ''}
                            </div>`
                    },
                    {
                        data: null,
                        defaultContent: '-',
                        render: row => `
                            <div class="flex-wrap gap-1 d-flex">
                                <span class="akila-badge akila-badge-purple">${row.jalur || '-'}</span>
                                ${row.semester ? `<span class="akila-badge akila-badge-slate">Sem ${row.semester}</span>` : ''}
                            </div>`
                    },
                    {
                        data: 'tahun_masuk',
                        defaultContent: '-',
                        render: data => `<span class="akila-person"><span class="akila-person-avatar"><i class="fa fa-calendar"></i></span>${data || '-'}</span>`
                    },
                    {
                        data: 'status_mahasiswa',
                        defaultContent: '-',
                        className: 'text-center',
                        render: data => renderStatusCell(data)
                    },
                    {
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: item => `
                            <div class="akila-actions">
                                <button type="button" class="akila-action-btn btn-view" title="Lihat Detail"
                                    data-nim="${item.nim || ''}" data-nama="${item.nama_lengkap || ''}" data-prodi="${item.prodi?.nama || item.prodi || ''}"
                                    data-semester="${item.semester || ''}" data-kelas="${item.kelas || ''}" data-jalur="${item.jalur || ''}"
                                    data-tahun="${item.tahun_masuk || ''}" data-status="${item.status_mahasiswa || ''}"
                                    data-telp="${item.no_whatsapp || ''}" data-avatar="${item.avatar_url || ''}">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>`
                    }
                ]
            });
        }

        $(function () {
            const now = new Date().getFullYear();
            for (let y = now; y >= 2015; y--) {
                $('#filter-tahun').append(`<option value="${y}" ${y === 2021 ? 'selected' : ''}>${y}</option>`);
            }

            // Pasang kontrol length sebelum AJAX pertama selesai agar tidak pernah lompat
            $('#tabel-mahasiswa').on('init.dt', function () {
                if ($('#entries-container').is(':empty') && $('.dataTables_length').length) {
                    $('#entries-container').append($('.dataTables_length').detach());
                }
            });

            initDataTable();

            $('#filter-tahun').on('change', function () {
                if (table) {
                    table.ajax.reload();
                }
            });

            $('#btn-retry-oase').on('click', function () {
                forceOaseRefresh = true;
                setRetryLoadingState(true);
                if (table) {
                    table.ajax.reload();
                }
            });

            $('#btn-close-oase-alert').on('click', function () {
                $('#oase-offline-banner').addClass('is-hidden');
            });

            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            $(document).on('keyup change', '#tabel-mahasiswa .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table && table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-mahasiswa .col-filter-select', function () {
                const colIdx = $(this).data('col');
                if (table) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $('#check-all-mhs').on('change', function () {
                $('#tabel-mahasiswa .row-check').prop('checked', this.checked);
            });

            $(document).on('click', '.btn-view', function () {
                const data = $(this).data();
                $('#view-avatar').attr('src', data.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(data.nama)}&background=eab308&color=0f172a&bold=true`);
                $('#view-nama').text(data.nama);
                $('#view-prodi').text(data.prodi);
                $('#view-nim').text(data.nim);
                $('#view-kelas').text(data.kelas);
                $('#view-jalur').text(data.jalur);
                $('#view-tahun').text(data.tahun);
                $('#view-semester').text(data.semester);
                $('#view-status-badge').text(data.status || '-');

                if (data.telp) {
                    $('#view-telp').html(`<a href="https://wa.me/${data.telp}" class="text-success text-decoration-none fw-bold" target="_blank">${data.telp}</a>`);
                    $('#view-wa-btn').html(`<a href="https://wa.me/${data.telp}" target="_blank" class="px-3 btn btn-sm btn-success rounded-2 fw-semibold"><i class="fab fa-whatsapp me-1"></i> WhatsApp</a>`);
                } else {
                    $('#view-telp').text('-');
                    $('#view-wa-btn').empty();
                }
                new bootstrap.Modal(document.getElementById('modalViewMahasiswa')).show();
            });
        });
    </script>
@endsection
