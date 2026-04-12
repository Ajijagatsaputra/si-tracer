@extends('layouts.admin')

@section('content')
    <div class="px-4 py-5 container-fluid">

        <!-- === STATISTICS CARDS === -->
    <div class="content content-full">
        <!-- Glassmorphic Stats Section -->
        <div class="row g-4 mb-5">
            @php
                $stats = [
                    [
                        'label' => 'Total Alumni',
                        'icon' => 'fa-users',
                        'value' => $totalAlumni,
                        'color' => 'primary',
                        'desc' => 'Terdaftar di sistem'
                    ],
                    [
                        'label' => 'Sudah Diisi',
                        'icon' => 'fa-check-double',
                        'value' => $sudahMengisi,
                        'color' => 'success',
                        'desc' => 'Evaluasi lengkap'
                    ],
                    [
                        'label' => 'Belum Diisi',
                        'icon' => 'fa-hourglass-half',
                        'value' => $belumMengisi,
                        'color' => 'warning',
                        'desc' => 'Menunggu feedback'
                    ],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="col-12 col-md-4">
                    <div class="card card-modern border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body p-4 position-relative">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-{{ $stat['color'] }}-light text-{{ $stat['color'] }} me-3">
                                    <i class="fa {{ $stat['icon'] }} fa-lg"></i>
                                </div>
                                <div class="ms-auto h2 fw-bold text-dark mb-0 stat-number">{{ $stat['value'] }}</div>
                            </div>
                            <div class="mb-1 text-uppercase fs-xs fw-bold text-muted ls-wider">{{ $stat['label'] }}</div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fs-xs text-muted">{{ $stat['desc'] }}</span>
                                @if ($stat['label'] !== 'Total Alumni')
                                    <span class="badge bg-{{ $stat['color'] }}-light text-{{ $stat['color'] }} rounded-pill px-2 py-1 fs-xs border">
                                        {{ $totalAlumni > 0 ? round(($stat['value'] / $totalAlumni) * 100, 1) : 0 }}%
                                    </span>
                                @endif
                            </div>
                            <div class="position-absolute bottom-0 start-0 end-0" style="height: 4px; background: rgba(var(--bs-{{ $stat['color'] }}-rgb), 0.1);">
                                <div class="h-100 bg-{{ $stat['color'] }}" style="width: {{ $totalAlumni > 0 ? ($stat['value'] / $totalAlumni) * 100 : 0 }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Table Section -->
        <div class="card card-modern border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary-light text-primary me-3">
                            <i class="fa fa-chart-line fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Hasil Evaluasi Kompetensi</h5>
                            <p class="text-muted fs-xs mb-0">Analisis penilaian berdasarkan 7 indikator utama kompetensi lulusan</p>
                        </div>
                    </div>
                    <div id="table-actions" class="d-flex gap-2">
                        <!-- DataTable buttons will be moved here via JS -->
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="table-hasil-survei" class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0 8px;">
                        <thead>
                            <tr class="bg-light text-muted">
                                <th class="border-0 px-4 py-3 text-uppercase fs-xs fw-bold ls-wider rounded-start" style="width: 250px;">Indikator Kompetensi</th>
                                @foreach (['Sangat Baik', 'Baik', 'Cukup', 'Kurang', 'Tidak Baik'] as $label)
                                    <th class="border-0 px-2 py-3 text-center text-uppercase fs-xs fw-bold ls-wider">{{ $label }}</th>
                                @endforeach
                                <th class="border-0 px-2 py-3 text-center text-uppercase fs-xs fw-bold ls-wider">Rata-Rata</th>
                                <th class="border-0 px-4 py-3 text-center text-uppercase fs-xs fw-bold ls-wider rounded-end">Skor Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasil as $row)
                                <tr class="shadow-sm rounded-4 mb-2 bg-white card-row-rounded">
                                    <td class="px-4 py-3 fw-bold text-dark fs-sm border-0 rounded-start">{{ $row['label'] }}</td>
                                    @php
                                        // Mapping keys because legacy uses 1-5 reversed or specific mapping
                                        // The labels in order were: Sangat Baik (5), Baik (4), Cukup (3), Kurang Baik (2), Tidak Baik (1)
                                        $scoreKeys = [5, 4, 3, 2, 1];
                                    @endphp
                                    @foreach ($scoreKeys as $key)
                                        <td class="px-2 py-3 text-center border-0">
                                            <div class="fs-xs fw-bold text-dark mb-1">{{ $row['rekap'][$key] }}</div>
                                            <div class="progress rounded-pill bg-light" style="height: 4px; width: 40px; margin: 0 auto;">
                                                <div class="progress-bar bg-primary" style="width: {{ $row['jumlah_responden'] > 0 ? ($row['rekap'][$key] / $row['jumlah_responden']) * 100 : 0 }}%"></div>
                                            </div>
                                            <div class="text-muted" style="font-size: 0.65rem;">{{ $row['jumlah_responden'] > 0 ? round(($row['rekap'][$key] / $row['jumlah_responden']) * 100, 1) : 0 }}%</div>
                                        </td>
                                    @endforeach
                                    <td class="px-2 py-3 text-center border-0">
                                        @if ($row['rata_rata'] > 0)
                                            <span class="badge bg-{{ $row['rata_rata'] >= 4.0 ? 'success' : ($row['rata_rata'] >= 3.0 ? 'primary' : 'warning') }}-light text-{{ $row['rata_rata'] >= 4.0 ? 'success' : ($row['rata_rata'] >= 3.0 ? 'primary' : 'warning') }} rounded-pill px-3 py-2 border">
                                                {{ number_format($row['rata_rata'], 2) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center border-0 rounded-end">
                                        @if ($row['nilai_total'] > 0)
                                            <div class="fw-bold text-dark">{{ $row['nilai_total'] }}%</div>
                                            <div class="progress rounded-pill bg-light mt-1" style="height: 6px;">
                                                <div class="progress-bar bg-info" style="width: {{ $row['nilai_total'] }}%"></div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Conclusion Section -->
        @if ($sudahMengisi > 0)
            <div class="card card-modern border-0 shadow-sm overflow-hidden mb-4 rounded-4" style="background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary text-white me-4 shadow-sm" style="width: 60px; height: 60px; min-width: 60px;">
                            <i class="fa fa-award fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Kesimpulan Evaluasi Supervisor</h5>
                            <p class="mb-0 text-muted fs-sm">
                                Berdasarkan evaluasi dari <span class="fw-bold text-primary">{{ $sudahMengisi }}</span> supervisor, 
                                performa alumni secara umum tergolong <span class="badge bg-success text-white px-3">{{ $kesimpulanKategori }}</span> 
                                dengan rata-rata skor kompetensi <span class="text-primary fw-bold text-dark">{{ $kesimpulanRataRata }}</span> dari skala 5.00.
                            </p>
                        </div>
                        <div class="ms-auto d-none d-lg-block">
                            <div class="text-end">
                                <div class="h2 fw-bold text-primary mb-0">{{ $kesimpulanPersentase }}%</div>
                                <div class="text-uppercase ls-wider fw-bold text-muted" style="font-size: 0.6rem;">Pencapaian Kompetensi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card card-modern border-0 shadow-sm mb-4 rounded-4 bg-warning-light border-start border-4 border-warning">
                <div class="card-body p-4 d-flex align-items-center">
                    <i class="fa fa-exclamation-triangle fa-2x text-warning me-3"></i>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Belum Ada Data Penilaian</h6>
                        <p class="mb-0 text-muted fs-sm">Sistem sedang menunggu supervisor untuk mengisi kuesioner evaluasi.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

        <!-- === LEGEND === -->
        <div class="mt-3 border-0 shadow-sm card bg-light rounded-4">
            <div class="px-3 py-2 card-body">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Skala Penilaian:</strong> 1 = Tidak Baik, 2 = Kurang Baik, 3 = Cukup, 4 = Baik, 5 = Sangat Baik
                </small>
            </div>
        </div>
    </div>

    <!-- === STYLES === -->
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
        <style>
            .card-row-rounded {
                transition: all 0.2s ease;
            }
            .card-row-rounded:hover {
                transform: scale(1.005);
                box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
            }
            .dt-buttons {
                display: flex;
                gap: 5px;
            }
            .dt-button {
                padding: 0.4rem 1rem !important;
                border-radius: 50px !important;
                font-size: 0.75rem !important;
                font-weight: 600 !important;
                border: 1px solid #dee2e6 !important;
                background: white !important;
                transition: all 0.2s !important;
            }
            .dt-button:hover {
                background: #f8f9fa !important;
                border-color: #4e73df !important;
                color: #4e73df !important;
            }
        </style>
    @endpush

    <!-- === SCRIPTS === -->
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
        <script>
            $(function() {
                // Initialize DataTables
                const table = $('#table-hasil-survei').DataTable({
                    paging: false,
                    searching: false,
                    ordering: false,
                    info: false,
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel me-1 text-success"></i> Excel',
                            className: 'btn btn-sm btn-light border shadow-sm'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf me-1 text-danger"></i> PDF',
                            className: 'btn btn-sm btn-light border shadow-sm'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print me-1 text-primary"></i> Cetak',
                            className: 'btn btn-sm btn-light border shadow-sm'
                        }
                    ]
                });

                // Move buttons to the custom container
                table.buttons().container().appendTo('#table-actions');

                // Animate numbers if counter class exists (compatible with our stat-number)
                $('.stat-number').each(function() {
                    const $this = $(this);
                    const countTo = parseInt($this.text());
                    $({ countNum: 0 }).animate({ countNum: countTo }, {
                        duration: 1500,
                        easing: 'swing',
                        step: function() { $this.text(Math.floor(this.countNum)); },
                        complete: function() { $this.text(this.countNum); }
                    });
                });
            });
        </script>
    @endpush
@endsection
