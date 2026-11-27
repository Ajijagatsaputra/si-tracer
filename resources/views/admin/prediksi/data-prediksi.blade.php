@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Fitur AI</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Daftar Prediksi Karier</span>
        </div>

        <!-- Main List Card -->
        <div class="mb-4 akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Daftar Prediksi Karier AI</h1>
                    <p class="akila-subtitle">Kelola semua riwayat analisis dan rekomendasi karier alumni berbasis AI yang tersedia di sistem.</p>
                </div>
                <div class="akila-header-actions">
                    <div id="export-buttons-container" class="gap-1 d-inline-flex"></div>
                    <a href="{{ route('admin.curriculum-analysis.index') }}" class="btn-akila-dark">
                        <i class="fa fa-brain"></i> Analisis Kurikulum
                    </a>
                </div>
            </div>

            <!-- Compact Stats Strip -->
            <div class="akila-stats-strip">
                <div class="akila-stat-chip">
                    <i class="fa fa-database text-primary"></i>
                    <span>Total Prediksi: <strong>{{ $totalPredictions ?? 0 }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-calendar-day text-success"></i>
                    <span>Hari Ini: <strong>{{ $todayPredictions ?? 0 }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-history text-warning"></i>
                    <span>7 Hari Terakhir: <strong>{{ $last7DaysPredictions ?? 0 }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-users text-info"></i>
                    <span>Alumni Unik: <strong>{{ $uniqueUsers ?? 0 }}</strong></span>
                </div>
            </div>

            <!-- Length Row -->
            <div class="akila-toolbar-row">
                <div id="entries-container" class="akila-length-wrap"></div>
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table class="table align-middle akila-table w-100" id="tabel-prediksi">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 38px;">
                                <input type="checkbox" class="form-check-input akila-checkbox" id="check-all-prediksi">
                            </th>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th>Nama Alumni</th>
                            <th style="min-width: 240px;">Ringkasan Hasil AI</th>
                            <th>Rekomendasi Profesi</th>
                            <th>Waktu Prediksi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width: 90px;">Aksi</th>
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
                                    <input type="text" class="col-filter" data-col="3" placeholder="Cari isi analisis...">
                                </div>
                            </th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="4">
                                    <option value="">Semua Profesi</option>
                                    @foreach(($jobTitleLabels ?? []) as $lbl)
                                        <option value="{{ $lbl }}">{{ $lbl }}</option>
                                    @endforeach
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
                                    <option value="SELESAI">Selesai</option>
                                </select>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(($histories ?? []) as $index => $item)
                            @php
                                $jobTitles = $item->extracted_job_titles ?? [];
                                $plain = trim(strip_tags($item->hasil ?? ''));
                                $excerpt = mb_strimwidth($plain, 0, 105, '...');
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input akila-checkbox row-check" value="{{ $item->id }}">
                                </td>
                                <td class="text-center text-muted fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="akila-person">
                                        <span class="akila-person-avatar"><i class="fa fa-user"></i></span>
                                        <div>
                                            <div class="akila-cell-title">{{ $item->alumni->nama_lengkap ?? ('Alumni #' . ($item->idAlumni ?? '-')) }}</div>
                                            <div class="akila-cell-desc" style="font-size: 0.74rem;">NIM: {{ $item->alumni->nim ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="akila-cell-desc">{{ $excerpt ?: '-' }}</div>
                                </td>
                                <td>
                                    <div class="flex-wrap gap-1 d-flex">
                                        @forelse(array_slice($jobTitles, 0, 2) as $i => $title)
                                            <span class="akila-badge {{ $i === 0 ? 'akila-badge-outline' : 'akila-badge-orange' }}">{{ $title }}</span>
                                        @empty
                                            <span class="akila-badge akila-badge-slate">Rekomendasi Umum</span>
                                        @endforelse
                                        @if(count($jobTitles) > 2)
                                            <span class="akila-badge akila-badge-blue">+{{ count($jobTitles) - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="akila-cell-title" style="font-size: 0.8rem;">{{ optional($item->created_at)->format('d M Y') ?? '-' }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.73rem;">{{ optional($item->created_at)->diffForHumans() }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="akila-status-stack">
                                        <span class="akila-badge akila-badge-green">SELESAI</span>
                                        <span class="akila-substatus-ok">Lengkap</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="akila-actions">
                                        <button type="button" class="akila-action-btn" title="Lihat Detail Prediksi"
                                            onclick="showDetail({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#detailModal">
                                            <i class="far fa-eye"></i>
                                        </button>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('admin.prediksi.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="akila-action-btn act-delete" title="Hapus Riwayat"
                                                onclick="deleteItem({{ $item->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Visualisasi Ringkas -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="akila-list-card h-100">
                    <h2 class="mb-1 akila-title" style="font-size: 1.05rem;">Tren Prediksi 7 Hari Terakhir</h2>
                    <p class="mb-3 akila-subtitle">Frekuensi penggunaan fitur analisis karier AI setiap hari.</p>
                    <div style="height: 260px;">
                        <canvas id="prediksi7HariChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="akila-list-card h-100">
                    <h2 class="mb-1 akila-title" style="font-size: 1.05rem;">Distribusi Profesi Populer</h2>
                    <p class="mb-3 akila-subtitle">Top kategori rekomendasi karier alumni.</p>
                    <div style="height: 260px;">
                        <canvas id="jobTitleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal Modern -->
    <style>
        #detailModal .ai-modal-content {
            border: 1px solid #e2e8f0;
            border-radius: 18px !important;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.28);
            background: #ffffff;
        }

        .ai-modal-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 22px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .ai-modal-topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .ai-modal-icon-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            border: 1px solid #bfdbfe;
        }

        .ai-modal-close-btn {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.18s ease;
            flex-shrink: 0;
        }

        .ai-modal-close-btn:hover {
            background: #fee2e2;
            border-color: #fecaca;
            color: #dc2626;
        }

        .ai-modal-sidebar {
            background: linear-gradient(165deg, #0f172a 0%, #172554 100%);
            color: #f8fafc;
            padding: 26px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .ai-modal-sidebar::after {
            content: '';
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.22) 0%, transparent 70%);
            top: -70px;
            right: -70px;
            pointer-events: none;
        }

        .ai-avatar-circle {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.1);
            border: 1.5px solid rgba(250, 204, 21, 0.55);
            color: #facc15;
            font-weight: 800;
            font-size: 1.1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 0.03em;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.18);
        }

        .ai-meta-list {
            display: grid;
            gap: 8px;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ai-meta-item {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 9px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ai-meta-item i {
            width: 26px;
            height: 26px;
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.09);
            color: #93c5fd;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .ai-meta-item-label {
            font-size: 0.66rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #94a3b8;
            line-height: 1.1;
        }

        .ai-meta-item-val {
            font-size: 0.8rem;
            font-weight: 600;
            color: #f1f5f9;
            word-break: break-word;
        }

        .ai-role-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            border-radius: 8px;
            background: rgba(16, 185, 129, 0.16);
            border: 1px solid rgba(52, 211, 153, 0.35);
            color: #6ee7b7;
            font-size: 0.76rem;
            font-weight: 700;
        }

        .ai-analysis-panel {
            background: #f8fafc;
            padding: 24px 28px;
            max-height: 68vh;
            overflow-y: auto;
        }

        .ai-section-banner {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 4px 11px;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .ai-intro-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #2563eb;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 0.86rem;
            color: #334155;
            line-height: 1.65;
            margin-bottom: 16px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
        }

        .ai-career-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 14px;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
            transition: border-color 0.2s ease;
        }

        .ai-career-card:hover {
            border-color: #cbd5e1;
        }

        .ai-career-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.96rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .ai-career-num {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            background: #0f172a;
            color: #facc15;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ai-reason-row {
            font-size: 0.84rem;
            color: #475569;
            line-height: 1.65;
            margin-bottom: 10px;
            padding-left: 2px;
        }

        .ai-skill-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 0.73rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .ai-summary-callout {
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
            border: 1px solid #a7f3d0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 0.84rem;
            color: #065f46;
            line-height: 1.65;
            margin-top: 6px;
        }

        .ai-modal-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 13px 22px;
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
        }

        #page-container.dark-mode #detailModal .ai-modal-content,
        #page-container.dark-mode .ai-modal-topbar,
        #page-container.dark-mode .ai-modal-footer,
        #page-container.dark-mode .ai-career-card,
        #page-container.dark-mode .ai-intro-box {
            background: #1e293b !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #e2e8f0 !important;
        }

        #page-container.dark-mode .ai-analysis-panel {
            background: #0f172a !important;
        }

        #page-container.dark-mode .ai-career-card-title {
            color: #f8fafc !important;
        }

        #page-container.dark-mode .ai-reason-row {
            color: #cbd5e1 !important;
        }

        #page-container.dark-mode .ai-skill-pill {
            background: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            color: #e2e8f0 !important;
        }
    </style>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="border-0 modal-content ai-modal-content">
                <div class="p-0 modal-body" id="modalContent"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/plugins/chart.js/chart.min.js') }}"></script>
    <script>
        jQuery(document).ready(function ($) {
            const table = $('#tabel-prediksi').DataTable({
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
                    zeroRecords: 'Tidak ada riwayat prediksi yang cocok.',
                    emptyTable: 'Belum ada riwayat prediksi AI tersedia.',
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

            $(document).on('keyup change', '#tabel-prediksi .col-filter', function () {
                const colIdx = $(this).data('col');
                if (table.column(colIdx).search() !== this.value) {
                    table.column(colIdx).search(this.value).draw();
                }
            });

            $(document).on('change', '#tabel-prediksi .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $('#check-all-prediksi').on('change', function () {
                $('#tabel-prediksi .row-check').prop('checked', this.checked);
            });

            if (typeof Chart !== 'undefined') {
                const ctx1 = document.getElementById('prediksi7HariChart');
                if (ctx1) {
                    new Chart(ctx1.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: @json($last7DaysLabels ?? []),
                            datasets: [{
                                data: @json($last7DaysCounts ?? []),
                                backgroundColor: '#0f172a',
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                                x: { grid: { display: false } }
                            }
                        }
                    });
                }

                const ctx2 = document.getElementById('jobTitleChart');
                if (ctx2) {
                    new Chart(ctx2.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: @json($jobTitleLabels ?? []),
                            datasets: [{
                                data: @json($jobTitleCounts ?? []),
                                backgroundColor: ['#0f172a', '#10b981', '#eab308', '#3b82f6', '#8b5cf6', '#f97316'],
                                borderWidth: 0,
                                cutout: '72%'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 10 } } }
                            }
                        }
                    });
                }
            }
        });

        let currentRawAiText = '';
        let currentPrintMeta = {};

        function escapeHtml(str) {
            return String(str || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function formatInlineMarkdown(str) {
            return escapeHtml(str)
                .replace(/\*\*(.+?)\*\*/g, '<strong class="fw-bold text-dark">$1</strong>')
                .replace(/\*(.+?)\*/g, '<em class="fst-italic text-primary fw-medium">$1</em>');
        }

        function formatAIResponse(text) {
            if (!text || !text.trim()) {
                return '<div class="py-5 text-center text-muted"><i class="mb-2 fa fa-info-circle fs-4 d-block"></i>Belum ada analisis yang tersedia.</div>';
            }

            const lines = text.replace(/\r\n/g, '\n').split('\n');
            let html = '';
            let cardOpen = false;
            let listOpen = false;
            let careerIdx = 0;

            const closeList = () => {
                if (listOpen) {
                    html += '</ul>';
                    listOpen = false;
                }
            };
            const closeCard = () => {
                closeList();
                if (cardOpen) {
                    html += '</div>';
                    cardOpen = false;
                }
            };

            for (let rawLine of lines) {
                const line = rawLine.trim();
                if (!line) continue;

                // Clean top banner like "HASIL CEPAT" or "## HASIL..."
                if (/^(#{1,3}\s*)?(HASIL CEPAT|RINGKASAN ANALISIS|REKOMENDASI KARIER|ANALISIS KARIER)$/i.test(line.replace(/\*\*/g, ''))) {
                    closeCard();
                    const label = line.replace(/^#{1,3}\s*/, '').replace(/\*\*/g, '');
                    html += `<div class="ai-section-banner"><i class="fa fa-bolt"></i> ${escapeHtml(label)}</div>`;
                    continue;
                }

                // Summary / Conclusion line ("Kesimpulan singkat: ...")
                const summaryMatch = line.match(/^(?:[-*]\s*)?(?:\*\*)?Kesimpulan(?:\s+singkat)?(?:\*\*)?\s*:\s*(.+)$/i);
                if (summaryMatch) {
                    closeCard();
                    const body = summaryMatch[1].replace(/^\*\*|\*\*$/g, '');
                    html += `
                        <div class="ai-summary-callout">
                            <div class="gap-2 mb-1 fw-bold d-flex align-items-center" style="font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.04em;">
                                <i class="fa fa-lightbulb text-success"></i> Kesimpulan Rekomendasi
                            </div>
                            <div>${formatInlineMarkdown(body)}</div>
                        </div>`;
                    continue;
                }

                // "Kenapa cocok: ..."
                const reasonMatch = line.match(/^(?:[-*]\s*)?(?:\*\*)?(Kenapa cocok|Alasan(?: kecocokan)?|Deskripsi)(?:\*\*)?\s*:\s*(.+)$/i);
                if (reasonMatch) {
                    closeList();
                    html += `
                        <div class="ai-reason-row">
                            <span class="fw-bold text-dark"><i class="fa fa-check-circle text-primary me-1"></i>${escapeHtml(reasonMatch[1])}:</span>
                            ${formatInlineMarkdown(reasonMatch[2])}
                        </div>`;
                    continue;
                }

                // "Skill unggulan: PHP, SQL, ..."
                const skillMatch = line.match(/^(?:[-*]\s*)?(?:\*\*)?(Skill(?:\s+unggulan|\s+utama)?|Keahlian(?:\s+utama)?)(?:\*\*)?\s*:\s*(.+)$/i);
                if (skillMatch) {
                    closeList();
                    const rawSkills = skillMatch[2].replace(/\.$/, '');
                    const skills = rawSkills.split(/[,;]/).map(s => s.trim()).filter(Boolean);
                    const pills = skills.map(s => `<span class="ai-skill-pill"><i class="fa fa-code text-primary" style="font-size:0.65rem;"></i>${formatInlineMarkdown(s)}</span>`).join('');
                    html += `
                        <div class="pt-2 mt-2 border-top" style="border-color: #f1f5f9 !important;">
                            <div class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.04em;">
                                <i class="fa fa-layer-group me-1"></i> ${escapeHtml(skillMatch[1])}
                            </div>
                            <div class="flex-wrap gap-1 d-flex">${pills}</div>
                        </div>`;
                    continue;
                }

                // Markdown heading or standalone bold career title (e.g. "**Software Developer**" or "1. **Software Developer**" or "### Software Developer")
                const headingMatch = line.match(/^(?:#{2,4}\s+|(?:\d+\.\s*)?\*\*)([^*#]+?)(?:\*\*)?$/);
                if (headingMatch && line.length < 75 && !line.endsWith(':') && !line.endsWith('.')) {
                    closeCard();
                    careerIdx++;
                    cardOpen = true;
                    html += `
                        <div class="ai-career-card">
                            <div class="ai-career-card-title">
                                <span class="ai-career-num">${careerIdx}</span>
                                <span>${escapeHtml(headingMatch[1].trim())}</span>
                            </div>`;
                    continue;
                }

                // Bullet item
                const bulletMatch = line.match(/^[-•]\s+(.+)$/);
                if (bulletMatch) {
                    if (!listOpen) {
                        html += '<ul class="mb-2 ps-3 small text-secondary" style="line-height: 1.65;">';
                        listOpen = true;
                    }
                    html += `<li class="mb-1">${formatInlineMarkdown(bulletMatch[1])}</li>`;
                    continue;
                }

                // Greeting / Introductory or regular paragraph
                closeList();
                if (!cardOpen && careerIdx === 0) {
                    html += `<div class="ai-intro-box">${formatInlineMarkdown(line)}</div>`;
                } else {
                    html += `<p class="mb-2 small text-secondary" style="line-height: 1.65;">${formatInlineMarkdown(line)}</p>`;
                }
            }

            closeCard();
            return html;
        }

        function copyAiReport(btn) {
            if (!currentRawAiText) return;
            navigator.clipboard.writeText(currentRawAiText).then(() => {
                const orig = btn.innerHTML;
                btn.innerHTML = '<i class="fa fa-check text-success me-1"></i> Tersalin!';
                setTimeout(() => { btn.innerHTML = orig; }, 1800);
            });
        }

        function printReport() {
            const bodyHtml = document.getElementById('aiFormattedBody')?.innerHTML || '';
            const m = currentPrintMeta;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Laporan Prediksi Karier AI - ${escapeHtml(m.nama || 'Alumni')}</title>
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap">
                        <style>
                            body { font-family: 'Plus Jakarta Sans', sans-serif; padding: 36px; color: #0f172a; }
                            .print-header { border-bottom: 2px solid #0f172a; padding-bottom: 16px; margin-bottom: 24px; }
                            .ai-career-card { border: 1px solid #cbd5e1; border-radius: 10px; padding: 14px 16px; margin-bottom: 12px; break-inside: avoid; }
                            .ai-career-card-title { font-weight: 800; font-size: 1rem; margin-bottom: 6px; display: flex; gap: 8px; align-items: center; }
                            .ai-career-num { background: #0f172a; color: #fff; padding: 2px 8px; border-radius: 6px; font-size: 0.75rem; }
                            .ai-intro-box { border-left: 4px solid #2563eb; background: #f8fafc; padding: 12px 14px; margin-bottom: 14px; border-radius: 6px; }
                            .ai-skill-pill { display: inline-block; border: 1px solid #cbd5e1; border-radius: 99px; padding: 2px 10px; font-size: 0.75rem; margin: 2px 4px 2px 0; }
                            .ai-summary-callout { border: 1px solid #10b981; background: #ecfdf5; padding: 12px 14px; border-radius: 8px; margin-top: 12px; }
                            .ai-section-banner { font-size: 0.75rem; font-weight: 800; color: #1d4ed8; margin-bottom: 8px; text-transform: uppercase; }
                        </style>
                    </head>
                    <body>
                        <div class="print-header d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-uppercase fw-bold text-primary" style="font-size: 0.72rem; letter-spacing: 0.06em;">Tracer Study TI UHN &bull; Laporan Analisis Karier AI</div>
                                <h3 class="mt-1 mb-1 fw-bold">${escapeHtml(m.nama || 'Alumni')}</h3>
                                <div class="text-muted small">NIM: ${escapeHtml(m.nim || '-')} &bull; Prodi: ${escapeHtml(m.prodi || 'Teknik Informatika')}</div>
                            </div>
                            <div class="text-end small text-muted">
                                <div>ID: <strong>#${escapeHtml(m.id || '-')}</strong></div>
                                <div>${escapeHtml(m.date || '')}</div>
                            </div>
                        </div>
                        ${bodyHtml}
                        <script>window.onload=function(){window.print();setTimeout(function(){window.close();},500);};<\/script>
                    </body>
                </html>
            `);
            printWindow.document.close();
        }

        function getInitials(name) {
            if (!name) return 'AL';
            const parts = name.trim().split(/\s+/);
            return (parts[0][0] + (parts[1] ? parts[1][0] : '')).toUpperCase();
        }

        function showDetail(id) {
            const container = document.getElementById('modalContent');
            container.innerHTML = `
                <div class="p-5 text-center">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 mb-0 text-muted small fw-medium">Memuat detail hasil analisis karier AI...</p>
                </div>`;

            fetch(`/admin/prediksi/detail/${id}`)
                .then(r => r.json())
                .then(data => {
                    const nama = data.alumni?.nama_lengkap || ('Alumni #' + (data.idAlumni || '-'));
                    const nim = data.alumni?.nim || '-';
                    const prodi = data.alumni?.prodi || 'Teknik Informatika';
                    const angkatanInfo = data.alumni?.tahun_lulus
                        ? `Lulusan ${data.alumni.tahun_lulus}`
                        : (data.alumni?.tahun_masuk ? `Angkatan ${data.alumni.tahun_masuk}` : 'Alumni Terdaftar');
                    const date = data.created_at
                        ? new Date(data.created_at).toLocaleDateString('id-ID', {
                            day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
                        })
                        : '-';

                    currentRawAiText = data.hasil || '';
                    currentPrintMeta = { id: String(data.id).padStart(4, '0'), nama, nim, prodi, date };

                    const jobTitles = Array.isArray(data.extracted_job_titles) ? data.extracted_job_titles : [];
                    const titlesHTML = jobTitles.length > 0
                        ? jobTitles.map(t => `<span class="ai-role-chip"><i class="fa fa-briefcase" style="font-size:0.68rem;"></i>${escapeHtml(t)}</span>`).join('')
                        : '<span class="text-white-50 small fst-italic">Rekomendasi karier umum</span>';

                    container.innerHTML = `
                        <!-- Top Header Bar -->
                        <div class="ai-modal-topbar">
                            <div class="ai-modal-topbar-left">
                                <span class="ai-modal-icon-badge">
                                    <i class="fa fa-brain"></i>
                                </span>
                                <div class="min-w-0">
                                    <div class="flex-wrap gap-2 d-flex align-items-center">
                                        <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;">Detail Analisis & Rekomendasi Karier AI</h6>
                                        <span class="akila-status-dot-badge st-green">
                                            <span class="dot"></span> Verified AI
                                        </span>
                                        <span class="border badge bg-light text-secondary" style="font-size: 0.68rem;">#PRD-${String(data.id).padStart(4, '0')}</span>
                                    </div>
                                    <div class="text-muted" style="font-size: 0.74rem;">Berdasarkan profil capaian nilai akademik & ketertarikan bidang karier alumni</div>
                                </div>
                            </div>
                            <button type="button" class="ai-modal-close-btn" data-bs-dismiss="modal" aria-label="Tutup">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>

                        <!-- 2-Column Body -->
                        <div class="row g-0">
                            <!-- Left Alumni & Career Summary -->
                            <div class="col-lg-4 ai-modal-sidebar">
                                <div>
                                    <div class="gap-3 mb-2 d-flex align-items-center">
                                        <div class="ai-avatar-circle">${escapeHtml(getInitials(nama))}</div>
                                        <div class="min-w-0">
                                            <div class="text-uppercase fw-bold" style="font-size: 0.66rem; letter-spacing: 0.06em; color: #93c5fd;">Profil Kandidat</div>
                                            <h5 class="mb-0 text-white fw-bold text-truncate" style="font-size: 1.02rem;" title="${escapeHtml(nama)}">${escapeHtml(nama)}</h5>
                                            <div class="text-white-50" style="font-size: 0.76rem;">NIM: ${escapeHtml(nim)}</div>
                                        </div>
                                    </div>

                                    <div class="ai-meta-list">
                                        <div class="ai-meta-item">
                                            <i class="fa fa-graduation-cap"></i>
                                            <div>
                                                <div class="ai-meta-item-label">Program Studi</div>
                                                <div class="ai-meta-item-val">${escapeHtml(prodi)} &bull; ${escapeHtml(angkatanInfo)}</div>
                                            </div>
                                        </div>
                                        <div class="ai-meta-item">
                                            <i class="fa fa-clock"></i>
                                            <div>
                                                <div class="ai-meta-item-label">Waktu Analisis</div>
                                                <div class="ai-meta-item-val">${escapeHtml(date)} WIB</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-3 mt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
                                        <div class="mb-2 d-flex align-items-center justify-content-between">
                                            <span class="text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.05em; color: #cbd5e1;">
                                                Rekomendasi Profesi
                                            </span>
                                            <span class="badge rounded-pill" style="background: rgba(255,255,255,0.12); font-size: 0.66rem;">
                                                ${jobTitles.length} Profesi
                                            </span>
                                        </div>
                                        <div class="flex-wrap gap-2 d-flex">
                                            ${titlesHTML}
                                        </div>
                                    </div>
                                </div>

                                <div class="gap-2 pt-3 mt-4 border-top d-flex align-items-center" style="border-color: rgba(255,255,255,0.1) !important; font-size: 0.72rem; color: #94a3b8;">
                                    <i class="fa fa-shield-alt text-info"></i>
                                    <span>Dianalisis otomatis oleh <strong>Jagat AI Engine</strong></span>
                                </div>
                            </div>

                            <!-- Right Formatted AI Analysis -->
                            <div class="col-lg-8 ai-analysis-panel" id="aiFormattedBody">
                                ${formatAIResponse(data.hasil)}
                            </div>
                        </div>

                        <!-- Bottom Action Footer -->
                        <div class="ai-modal-footer">
                            <button type="button" class="btn-akila-outline" onclick="copyAiReport(this)">
                                <i class="fa fa-copy"></i> Salin Teks Analisis
                            </button>
                            <div class="gap-2 d-flex align-items-center">
                                <button type="button" class="btn-akila-outline" onclick="printReport()">
                                    <i class="fa fa-print text-primary"></i> Cetak Laporan
                                </button>
                                <button type="button" class="btn-akila-dark" data-bs-dismiss="modal">
                                    Tutup
                                </button>
                            </div>
                        </div>`;
                })
                .catch(() => {
                    container.innerHTML = `
                        <div class="p-5 text-center">
                            <i class="mb-2 fa fa-exclamation-triangle text-danger fs-2"></i>
                            <p class="mb-3 text-danger fw-semibold">Gagal memuat detail hasil prediksi AI.</p>
                            <button type="button" class="btn-akila-dark" data-bs-dismiss="modal">Tutup</button>
                        </div>`;
                });
        }

        function deleteItem(id) {
            Swal.fire({
                title: 'Hapus Riwayat Prediksi?',
                text: 'Data prediksi yang dihapus tidak dapat dikembalikan.',
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
            }).then(res => {
                if (res.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
