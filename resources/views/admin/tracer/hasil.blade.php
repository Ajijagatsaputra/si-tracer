@extends('layouts.admin')

@section('content')
    <div class="akila-page-wrap">
        <!-- Breadcrumb -->
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i> Home</a>
            <span class="sep">&rsaquo;</span>
            <span>Kelola Tracer</span>
            <span class="sep">&rsaquo;</span>
            <span class="active">Hasil Evaluasi Kompetensi</span>
        </div>

        <!-- Main Card -->
        <div class="akila-list-card">
            <div class="akila-card-header">
                <div>
                    <h1 class="akila-title">Hasil Evaluasi Kompetensi Lulusan</h1>
                    <p class="akila-subtitle">Rekapitulasi penilaian 7 indikator utama kompetensi alumni oleh pengguna lulusan di industri.</p>
                </div>
                <div class="akila-header-actions">
                    <div id="table-actions" class="d-inline-flex gap-1"></div>
                </div>
            </div>

            <!-- Compact Stats Strip -->
            <div class="akila-stats-strip">
                <div class="akila-stat-chip">
                    <i class="fa fa-users text-primary"></i>
                    <span>Total Alumni: <strong>{{ $totalAlumni }}</strong></span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-check-double text-success"></i>
                    <span>Sudah Diisi: <strong>{{ $sudahMengisi }}</strong> ({{ $totalAlumni > 0 ? round(($sudahMengisi / $totalAlumni) * 100, 1) : 0 }}%)</span>
                </div>
                <div class="akila-stat-chip">
                    <i class="fa fa-hourglass-half text-warning"></i>
                    <span>Belum Diisi: <strong>{{ $belumMengisi }}</strong></span>
                </div>
                @if ($sudahMengisi > 0)
                    <div class="akila-stat-chip">
                        <i class="fa fa-award text-success"></i>
                        <span>Rata-rata Skor: <strong>{{ $kesimpulanRataRata }} / 5.00</strong> ({{ $kesimpulanKategori }} &bull; {{ $kesimpulanPersentase }}%)</span>
                    </div>
                @endif
            </div>

            <!-- Table -->
            <div class="akila-table-wrapper">
                <table id="table-hasil-survei" class="table akila-table align-middle w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 56px;">No.</th>
                            <th style="min-width: 220px;">Indikator Kompetensi</th>
                            <th class="text-center">Sangat Baik (5)</th>
                            <th class="text-center">Baik (4)</th>
                            <th class="text-center">Cukup (3)</th>
                            <th class="text-center">Kurang (2)</th>
                            <th class="text-center">Tidak Baik (1)</th>
                            <th class="text-center">Rata-rata</th>
                            <th class="text-center">Status Capaian</th>
                        </tr>
                        <tr class="akila-filter-row">
                            <th class="text-center"><span class="akila-no-pill">No</span></th>
                            <th>
                                <div class="akila-filter-input">
                                    <i class="fa fa-search"></i>
                                    <input type="text" class="col-filter" data-col="1" placeholder="Cari indikator...">
                                </div>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <select class="akila-filter-select col-filter-select" data-col="8">
                                    <option value="">Semua Capaian</option>
                                    <option value="SANGAT BAIK">Sangat Baik</option>
                                    <option value="BAIK">Baik</option>
                                    <option value="CUKUP">Cukup</option>
                                    <option value="PERLU EVALUASI">Perlu Evaluasi</option>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hasil as $idx => $row)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $idx + 1 }}</td>
                                <td>
                                    <div class="akila-cell-title">{{ $row['label'] }}</div>
                                    <div class="akila-cell-desc" style="font-size: 0.74rem;">Responden: {{ $row['jumlah_responden'] }} atasan</div>
                                </td>
                                @foreach ([5, 4, 3, 2, 1] as $key)
                                    <td class="text-center">
                                        <span class="fw-semibold text-dark">{{ $row['rekap'][$key] }}</span>
                                        <span class="text-muted d-block" style="font-size: 0.72rem;">
                                            {{ $row['jumlah_responden'] > 0 ? round(($row['rekap'][$key] / $row['jumlah_responden']) * 100, 1) : 0 }}%
                                        </span>
                                    </td>
                                @endforeach
                                <td class="text-center">
                                    @if ($row['rata_rata'] > 0)
                                        <span class="akila-badge akila-badge-outline">{{ number_format($row['rata_rata'], 2) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($row['rata_rata'] >= 4.2)
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-green">SANGAT BAIK</span>
                                            <span class="akila-substatus-ok">{{ $row['nilai_total'] }}% Tercapai</span>
                                        </div>
                                    @elseif ($row['rata_rata'] >= 3.4)
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-blue">BAIK</span>
                                            <span class="akila-substatus-ok">{{ $row['nilai_total'] }}% Tercapai</span>
                                        </div>
                                    @elseif ($row['rata_rata'] >= 2.5)
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-amber">CUKUP</span>
                                            <span class="akila-substatus-muted">{{ $row['nilai_total'] }}% Tercapai</span>
                                        </div>
                                    @elseif ($row['rata_rata'] > 0)
                                        <div class="akila-status-stack">
                                            <span class="akila-badge akila-badge-red">PERLU EVALUASI</span>
                                            <span class="akila-substatus-warn">{{ $row['nilai_total'] }}% Tercapai</span>
                                        </div>
                                    @else
                                        <span class="akila-badge akila-badge-slate">BELUM ADA DATA</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3 pt-2 d-flex flex-wrap justify-content-between align-items-center text-muted" style="font-size: 0.78rem;">
                <span><i class="fa fa-info-circle me-1"></i> <strong>Skala Penilaian:</strong> 1 = Tidak Baik, 2 = Kurang, 3 = Cukup, 4 = Baik, 5 = Sangat Baik</span>
                @if ($sudahMengisi > 0)
                    <span>Kesimpulan Umum: <strong class="text-success">{{ $kesimpulanKategori }} ({{ $kesimpulanPersentase }}%)</strong></span>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(function ($) {
            const table = $('#table-hasil-survei').DataTable({
                paging: false,
                searching: true,
                ordering: true,
                orderCellsTop: true,
                info: false,
                autoWidth: false,
                dom: 'Brt',
                buttons: [
                    { extend: 'excelHtml5', text: '<i class="fa fa-file-excel me-1 text-success"></i> Excel', className: 'btn btn-sm' },
                    { extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf me-1 text-danger"></i> PDF', className: 'btn btn-sm', orientation: 'landscape' },
                    { extend: 'print', text: '<i class="fa fa-print me-1 text-secondary"></i> Cetak', className: 'btn btn-sm' }
                ]
            });

            table.buttons().container().appendTo('#table-actions');

            $('.akila-filter-row th').on('click mousedown', function (e) {
                e.stopPropagation();
            });

            $(document).on('keyup change', '#table-hasil-survei .col-filter', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });

            $(document).on('change', '#table-hasil-survei .col-filter-select', function () {
                const colIdx = $(this).data('col');
                table.column(colIdx).search(this.value).draw();
            });
        });
    </script>
@endsection
