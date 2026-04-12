<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediksi Karier Alumni</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/prediksi.css') }}">
</head>

<body>
    <div class="main-wrapper">
        <div class="header-section">
            <h1>Prediksi Karier Alumni</h1>
            <p>Sistem prediksi berbasis AI untuk menganalisis potensi karier berdasarkan Nilai Akademis dan kepribadian
            </p>
        </div>

        <div class="form-card">
            <form action="#" method="POST" onsubmit="return false;">
                @csrf

                <!-- Technical Section -->
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h5>Nilai Akademis</h5>
                        <small>Input nilai mata kuliah dengan SKS dan Grade</small>
                    </div>
                </div>

                <!-- Button to open Academic Modal only -->
                <div class="mb-4 d-flex flex-column flex-md-row align-items-start gap-2">
                    <div id="academic-status-info-box" class="flex-grow-2"></div>
                    <button type="button" class="btn-add-subject ms-0 ms-md-2" data-bs-toggle="modal"
                        data-bs-target="#academicModal">
                        <i class="fas fa-pen"></i> Nilai Akademis
                    </button>
                </div>

                <div class="mt-4 section-header">
                    <div class="section-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <h5>Aspek Kepribadian</h5>
                        <small>Profil Kepribadian & Minat Karier</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="form-label"><i class="fas fa-lightbulb"></i> Deskripsikan Kepribadian &
                            Minatmu</label>
                        <textarea name="deskripsi" id="" cols="30" class="form-control" rows="10"
                            placeholder="Ceritain singkat tentang dirimu, gaya kerja, minat, atau keahlian yang paling kamu nikmati.
Contoh: Saya suka ngoding backend tapi juga tertarik ke analisis data.
Saya tipe orang yang teliti dan suka tantangan baru."></textarea>
                        <small class="text-muted">
                            Tuliskan dengan gaya bebas aja, nanti sistem AI akan bantu mencocokkan dengan bidang karier
                            yang paling sesuai.
                        </small>

                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="mode-analysis" class="fw-semibold mb-2">Pilih Mode Analisis:</label><br>
                        <div id="mode-analysis" class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode" id="mode-flash"
                                    value="flash" checked>
                                <label class="form-check-label" for="mode-flash">Cepat 🔹 <span
                                        class="text-muted">(Rekomendasi singkat)</span></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mode" id="mode-pro"
                                    value="pro">
                                <label class="form-check-label" for="mode-pro">Mendalam 🔸 <span
                                        class="text-muted">(Analisis detail & penjelasan panjang)</span></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="button" class="btn-submit" id="btn-predict">
                        <i class="fas fa-chart-line"></i> Analisis & Prediksi Karier
                    </button>
                </div>
                <div id="hasilPrediksi" class="mt-4"></div>
                <!-- Loading Popup -->
                <div id="loadingModal">
                    <div class="box">
                        <div class="loader-wrap">
                            <div class="ring"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                        <div class="title">Memproses...</div>
                        <div class="desc" id="loadingText">Mohon tunggu sebentar</div>
                    </div>
                </div>

                <div class="mt-3 text-center">
                    <button type="button" onclick="history.back()" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                </div>
            </form>


            @isset($prediction)
                <div class="result-card">
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                    <h5>Hasil Prediksi Karier Anda</h5>
                    <h3>{{ $prediction }}</h3>
                </div>
            @endisset

            @if (session('error'))
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Academic Modal (moved outside transformed containers) -->
    <div class="modal fade" id="academicModal" tabindex="-1" aria-labelledby="academicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="academicModalLabel">
                        <i class="fas fa-graduation-cap"></i> Input Nilai Akademis
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 0.9rem;">
                    <div class="alert alert-info mb-4"
                        style="font-size: 1em; display: flex; align-items: flex-start; gap: 0.85em;">
                        <div>
                            <i class="fas fa-info-circle" style="font-size:1.5em; margin-top:0.18em;"></i>
                        </div>
                        <div>
                            <b>Kamu capek isi satu-satu?</b>
                            <span class="ms-1">
                                Upload <b>file PDF transkrip/DNS</b> kamu dan mimin bantu agar kamu tidak perlu
                                input manual!<br>
                                <div class="d-flex align-items-center mt-2" style="gap: 0.4em;">
                                    <label for="dnsPdfImport" class="form-label fw-semibold mb-0"
                                        style="cursor:pointer;">
                                        <i class="fas fa-file-pdf"></i> Pilih PDF
                                    </label>
                                    <input type="file" id="dnsPdfImport" class="form-control"
                                        accept="application/pdf"
                                        style="font-size:0.97em; max-width:220px; margin-left:0.7em;">
                                    <button type="button" class="btn btn-scan" style="margin-left:0.7em;"
                                        onclick="handleDnsPdfScan()">
                                        <i class="fas fa-file-search"></i> Scan PDF
                                    </button>
                                </div>

                            </span>
                        </div>
                    </div>
                    <!-- Inline OCR Loading here -->
                    <div id="inlineOcrLoading">
                        <div class="d-flex align-items-center" style="gap:12px;">
                            {{-- <div class="ring"></div> --}}
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="text" id="inlineOcrText">Menyiapkan ekstraksi PDF via Gemini...</div>
                        </div>
                    </div>
                    <!-- Inline OCR Alert here -->
                    <div id="inlineOcrAlert" class="mt-2"></div>

                    <script>
                        async function handleDnsPdfScan() {
                            const fileInput = document.getElementById('dnsPdfImport');
                            if (!fileInput.files.length) {
                                showAlert('error', 'Pilih file PDF DNS/transkrip terlebih dahulu!');
                                return;
                            }

                            const file = fileInput.files[0];
                            if (!file.name.match(/\.pdf$/i)) {
                                showAlert('error', 'Format file tidak cocok. Hanya file PDF yang didukung!');
                                fileInput.value = "";
                                return;
                            }

                            showInlineOcrLoading('Mengunggah PDF dan mengekstrak isi dokumen...');
                            document.getElementById('tableSkeleton')?.classList.remove('hidden');

                            // Upload ke backend endpoint untuk OCR PDF
                            const formData = new FormData();
                            formData.append('pdf', file);

                            try {
                                const controller = new AbortController();
                                const scanBtn = document.querySelector('.btn-scan');
                                if (scanBtn) scanBtn.disabled = true;
                                const response = await fetch('/api/ocr-gemini-extract', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                    signal: controller.signal
                                });
                                const result = await response.json();
                                if (!result.success && result.code === 429) {
                                    const alertBox = document.getElementById('inlineOcrAlert');
                                    const retry = result.retry_after ? ` Tunggu ${result.retry_after}s lalu coba lagi.` : '';
                                    if (alertBox) alertBox.innerHTML =
                                        `<div class="alert alert-warning mb-2">${result.error || 'Ekstraksi gagal.'}${retry}</div>`;
                                    hideInlineOcrLoading();
                                    return;
                                }
                                if (!result.success) {
                                    const alertBox = document.getElementById('inlineOcrAlert');
                                    if (alertBox) alertBox.innerHTML =
                                        '<div class="alert alert-warning mb-2">Ekstraksi tidak menemukan data nilai dari PDF. Pastikan file sesuai dan dapat dibaca.</div>';
                                    hideInlineOcrLoading();
                                    return;
                                }

                                let imported = 0;

                                // Map scanned data to form table
                                result.data.forEach(scannedRow => {
                                    let matkul = (scannedRow.mataKuliah || scannedRow.nama || '').trim();
                                    let sks = Number(scannedRow.sks || scannedRow.SKS);
                                    let grade = (scannedRow.grade || scannedRow.nilai || scannedRow.hm || '').toString()
                                        .toUpperCase().trim();

                                    if (
                                        matkul && sks && !isNaN(sks) &&
                                        grade.match(/^(A|A\-|A\+|B\+|B|B\-|C\+|C|C\-|D|E)$/i)
                                    ) {
                                        // Find matching row in form table
                                        const tableRows = document.querySelectorAll('#academicForm tbody tr');
                                        let found = false;

                                        tableRows.forEach(tableRow => {
                                            const tableMatkul = tableRow.querySelector('.mataKuliahNameInput').value
                                                .toLowerCase();

                                            // Check if scanned mata kuliah matches table mata kuliah (case insensitive)
                                            if (tableMatkul.includes(matkul.toLowerCase()) || matkul.toLowerCase()
                                                .includes(tableMatkul)) {
                                                const sksInput = tableRow.querySelector('.sksInput');
                                                const gradeSelect = tableRow.querySelector('.gradeSelect');

                                                sksInput.value = sks;
                                                gradeSelect.value = grade;

                                                // Highlight the row to show it was filled
                                                tableRow.style.backgroundColor = '#e8f5e8';
                                                setTimeout(() => {
                                                    tableRow.style.backgroundColor = '';
                                                }, 2000);

                                                found = true;
                                                imported++;
                                            }
                                        });

                                        // If not found in table, add to academicScores array
                                        if (!found) {
                                            const idx = academicScores.findIndex(e => (e.mataKuliah || '').toLowerCase() ===
                                                matkul.toLowerCase());
                                            if (idx !== -1) {
                                                academicScores[idx] = {
                                                    mataKuliah: matkul,
                                                    sks: sks,
                                                    grade: grade
                                                };
                                            } else {
                                                academicScores.push({
                                                    mataKuliah: matkul,
                                                    sks: sks,
                                                    grade: grade
                                                });
                                            }
                                            imported++;
                                        }
                                    }
                                });

                                updateAcademicScoresDisplay();
                                if (imported > 0) {
                                    showAlert('success', 'Berhasil melakukan OCR dan memetakan ' + imported +
                                        ' mata kuliah dari PDF ke form!');
                                } else {
                                    showAlert('warning', 'OCR tidak berhasil atau tidak ada mata kuliah yang cocok dengan form.');
                                }
                            } catch (err) {
                                // if (err && err.name === 'AbortError') {
                                //     const alertBox = document.getElementById('inlineOcrAlert');
                                //     if (alertBox) alertBox.innerHTML =
                                //         '<div class="alert alert-warning mb-2">Proses terlalu lama (timeout). Coba lagi atau gunakan file yang lebih kecil.</div>';
                                // } else {
                                //     const alertBox = document.getElementById('inlineOcrAlert');
                                //     if (alertBox) alertBox.innerHTML =
                                //         '<div class="alert alert-danger mb-2">Terjadi masalah saat melakukan ekstraksi PDF. Coba file lain atau ulangi lagi.</div>';
                                // }
                                const scanBtn = document.querySelector('.btn-scan');
                                if (scanBtn) scanBtn.disabled = false;
                                hideInlineOcrLoading();
                                document.getElementById('tableSkeleton')?.classList.add('hidden');
                            }
                        }
                    </script>
                    <form id="academicForm">
                        @php
                            $mataKuliahList = [];
                            if (isset($MataKuliah) && $MataKuliah->count() > 0) {
                                foreach ($MataKuliah as $mk) {
                                    $mataKuliahList[] = [
                                        'id' => $mk->id,
                                        'name' => $mk->mataKuliah,
                                    ];
                                }
                            } else {
                                $mataKuliahList = [
                                    ['id' => 1, 'name' => 'Computer Architecture'],
                                    ['id' => 2, 'name' => 'Programming Skill'],
                                    ['id' => 3, 'name' => 'Project Management'],
                                    ['id' => 4, 'name' => 'Communication Skill'],
                                ];
                            }
                        @endphp

                        <div>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle"
                                    style="background:#fff; font-size:0.89em;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:32%;">Nama Mata Kuliah</th>
                                            <th style="width:16%;">SKS</th>
                                            <th style="width:20%;">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mataKuliahList as $mk)
                                            <tr style="font-size:0.92em; line-height:1; height:36px;">
                                                <td style="padding-top:4px; padding-bottom:4px;">
                                                    <label class="form-label mb-0"
                                                        style="font-size:0.95em;">{{ $mk['name'] }}</label>
                                                    <input type="hidden" class="mataKuliahNameInput"
                                                        value="{{ $mk['name'] }}">
                                                </td>
                                                <td style="padding-top:4px; padding-bottom:4px;">
                                                    <input type="number" class="form-control sksInput"
                                                        value="4" min="1" max="6"
                                                        style="font-size:0.95em; padding:0.17rem 0.32rem; height:28px;"
                                                        placeholder="SKS">
                                                </td>
                                                <td style="padding-top:4px; padding-bottom:4px;">
                                                    <select class="form-control gradeSelect"
                                                        style="font-size:0.95em; padding:0.17rem 0.32rem; height:28px;">
                                                        <option value="">Pilih Grade</option>
                                                        <option value="A" selected>A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveAcademicScoresToDatabase()">
                        <i class="fas fa-save"></i> Simpan ke Database
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script>
        let academicScores = [];

        document.addEventListener('DOMContentLoaded', () => {
            const academicModalEl = document.getElementById('academicModal');
            if (!academicModalEl) return;
            academicModalEl.addEventListener('show.bs.modal', async () => {
                try {
                    const res = await fetch('/api/academic-scores', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (!data.success || !Array.isArray(data.data)) return;

                    const rows = document.querySelectorAll('#academicForm tbody tr');
                    rows.forEach(row => {
                        const sks = row.querySelector('.sksInput');
                        const grade = row.querySelector('.gradeSelect');
                        if (sks) sks.value = '';
                        if (grade) grade.value = '';
                    });

                    data.data.forEach(item => {
                        const target = Array.from(rows).find(row => {
                            const name = row.querySelector('.mataKuliahNameInput')
                                ?.value?.toLowerCase() || '';
                            const source = (item.mataKuliah || '').toLowerCase();
                            return name && (name.includes(source) || source.includes(
                                name));
                        });
                        if (target) {
                            const sks = target.querySelector('.sksInput');
                            const grade = target.querySelector('.gradeSelect');
                            if (sks) sks.value = item.sks || '';
                            if (grade) grade.value = item.grade || '';
                        }
                    });
                    // update badges setelah data dimuat
                    rows.forEach(row => {
                        const name = row.querySelector('.mataKuliahNameInput')?.value
                            ?.toLowerCase() || '';
                        const sks = row.querySelector('.sksInput')?.value?.trim();
                        const grade = row.querySelector('.gradeSelect')?.value?.trim();
                        const badge = row.querySelector('.academic-status-badge');
                        if (sks && grade && grade !== '') {
                            if (badge) {
                                badge.innerHTML =
                                    '<span class="badge bg-success">Sudah diisi</span>';
                            }
                        } else {
                            if (badge) {
                                badge.innerHTML =
                                    '<span class="badge bg-secondary">Belum diisi</span>';
                            }
                        }
                    });
                } catch (e) {
                    console.error('Gagal memuat data nilai akademik:', e);
                }
            });

            // InfoBox global status pengisian nilai akademis
            fetch('/api/academic-scores', {
                headers: {
                    'Accept': 'application/json'
                }
            }).then(async (res) => {
                if (!res.ok) return;
                const data = await res.json();
                const box = document.getElementById('academic-status-info-box');
                if (!box) return;
                if (data.success && Array.isArray(data.data) && data.data.length > 0) {
                    box.className = 'academic-info-box success';
                    box.innerHTML =
                        '<i class="fas fa-check-circle"></i><div class="msg"><span>Nilai akademis</span><b>SUDAH&nbsp;DIISI</b></div>';

                } else {
                    box.className = 'academic-info-box warn';
                    box.innerHTML =
                        '<i class="fas fa-exclamation-triangle"></i><div class="msg"><span>Nilai akademis</span><b>BELUM&nbsp;DIISI</b><span>. Anda wajib mengisi nilai mata kuliah.</span></div>';
                }
            });
        });

        // Simpan Academic
        async function saveAcademicScoresToDatabase() {
            const tableRows = document.querySelectorAll('#academicForm tbody tr');
            const academicScores = [];

            tableRows.forEach(row => {
                const mataKuliahInput = row.querySelector('.mataKuliahNameInput');
                const sksInput = row.querySelector('.sksInput');
                const gradeSelect = row.querySelector('.gradeSelect');

                if (mataKuliahInput && sksInput && gradeSelect) {
                    const mataKuliah = mataKuliahInput.value.trim();
                    const sks = parseInt(sksInput.value);
                    const grade = gradeSelect.value;

                    // Only add if all fields are filled
                    if (mataKuliah && sks && grade) {
                        academicScores.push({
                            mataKuliah: mataKuliah,
                            sks: sks,
                            grade: grade
                        });
                    }
                }
            });

            if (academicScores.length === 0) {
                showAlert('warning',
                    'Tidak ada data mata kuliah yang valid untuk disimpan! Pastikan semua field terisi.');
                return;
            }

            //   console.log(academicScores);

            try {
                showAlert('info', 'Menyimpan data mata kuliah...');

                const response = await fetch('/api/academic-scores/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        academic_scores: academicScores
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('success', result.message);
                    const academicModal = bootstrap.Modal.getInstance(document.getElementById('academicModal'));
                    academicModal.hide();
                } else {
                    showAlert('error', result.message);
                }

            } catch (error) {
                console.log('Error saving academic scores:', error);
                showAlert('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            }
        }

        // Clear academic form
        function clearAcademicForm() {
            const tableRows = document.querySelectorAll('#academicForm tbody tr');
            tableRows.forEach(row => {
                const mataKuliahInput = row.querySelector('.mataKuliahNameInput');
                const sksInput = row.querySelector('.sksInput');
                const gradeSelect = row.querySelector('.gradeSelect');

                if (mataKuliahInput) mataKuliahInput.value = '';
                if (sksInput) sksInput.value = '4';
                if (gradeSelect) gradeSelect.value = '';
            });
        }


        // Show alert
        function showAlert(type, message) {
            const alertClass = type === 'error' ? 'alert-danger' :
                type === 'success' ? 'alert-success' :
                type === 'info' ? 'alert-info' : 'alert-warning';

            const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
          <i class="fas fa-${type === 'error' ? 'exclamation-circle' :
                              type === 'success' ? 'check-circle' :
                              type === 'info' ? 'info-circle' : 'exclamation-triangle'}"></i>
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;

            // Insert at the top of form-card
            const formCard = document.querySelector('.form-card');
            const existingAlert = formCard.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }

            formCard.insertAdjacentHTML('afterbegin', alertHtml);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                const alert = formCard.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 3000);
        }
    </script>
    <script>
        document.getElementById('btn-predict').onclick = async function(e) {
            e.preventDefault();
            const hasilBox = document.getElementById('hasilPrediksi');
            hasilBox.innerHTML = '';
            showLoading('Menganalisis profil & menyusun rekomendasi karier');
            const mataKuliah = [...document.querySelectorAll('.mataKuliahNameInput')].map(x => x.value);
            const sks = [...document.querySelectorAll('.sksInput')].map(x => x.value);
            const grade = [...document.querySelectorAll('.gradeSelect')].map(x => x.value);
            const desc = document.querySelector('textarea[name=deskripsi]')?.value || '';
            const mode = document.querySelector('input[name="mode"]:checked')?.value || 'flash';
            const res = await fetch('/api/predict-gemini', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    mata_kuliah: mataKuliah,
                    sks_data: sks,
                    grade_data: grade,
                    deskripsi: desc,
                    mode: mode
                })
            });
            const data = await res.json();
            hideLoading();
            if (data.success) {
                hasilBox.innerHTML =
                    `<div class="alert alert-success" style="white-space: pre-line">${data.text}</div>`;
            } else {
                hasilBox.innerHTML =
                    `<div class="alert alert-danger">${data.error || 'Gagal mendapatkan rekomendasi. Coba lagi.'}</div>`;
            }
        }

        // Loading helpers
        function showLoading(text) {
            const m = document.getElementById('loadingModal');
            const t = document.getElementById('loadingText');
            if (t && text) t.textContent = text;
            if (m) m.style.display = 'flex';
        }

        function hideLoading() {
            const m = document.getElementById('loadingModal');
            if (m) m.style.display = 'none';
        }

        function showInlineOcrLoading(text) {
            const box = document.getElementById('inlineOcrLoading');
            const t = document.getElementById('inlineOcrText');
            if (t && text) t.textContent = text;
            if (box) box.style.display = 'block';
        }

        function hideInlineOcrLoading() {
            const box = document.getElementById('inlineOcrLoading');
            if (box) box.style.display = 'none';
        }
    </script>
</body>

</html>
