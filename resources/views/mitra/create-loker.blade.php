<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Lowongan Pekerjaan (Loker) - Universitas Harkat Negeri</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: rgba(79, 70, 229, 0.05);
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray-light: #f8fafc;
            --accent: #06b6d4;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark-light);
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .navbar-modern {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-brand-text {
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        /* Banner Header */
        .page-header {
            background: linear-gradient(135deg, var(--dark) 0%, #020617 100%);
            color: #fff;
            padding: 120px 0 50px 0;
        }

        /* Form Card */
        .form-card {
            background: #fff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .form-control,
        .form-select {
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.25s ease-in-out;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .btn-submit {
            background: var(--primary);
            color: #white;
            border: none;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-modern fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <span class="bg-primary text-white p-2 rounded-3 me-2 d-flex align-items-center justify-content-center"
                    style="width: 38px; height: 38px;">
                    <i class="fa fa-graduation-cap"></i>
                </span>
                <span class="navbar-brand-text fs-4">SIKEMATI</span>
            </a>
            <a href="/" class="btn btn-outline-secondary rounded-pill px-4 btn-sm ms-auto fw-bold"><i
                    class="fa fa-arrow-left me-1"></i> Kembali ke Landing Page</a>
        </div>
    </nav>

    <!-- Page Header Banner -->
    <header class="page-header">
        <div class="container text-center">
            <h1 class="fw-extrabold text-white mb-2 fs-2">Posting Lowongan Pekerjaan</h1>
            <p class="text-white/70 mb-0">Bagikan peluang karir aktif di perusahaan Anda kepada alumni terbaik Teknik
                Informatika</p>
        </div>
    </header>

    <!-- Form Section -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Alert Messages -->
                @if(session('success_message'))
                    <div class="alert alert-success border-0 rounded-4 shadow-sm p-4 mb-4 text-dark"
                        style="background-color: #d1e7dd;">
                        <div class="d-flex">
                            <div class="me-3 fs-3 text-success">
                                <i class="fa fa-check-circle"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Berhasil Terkirim!</h5>
                                <p class="mb-0 fs-sm">{{ session('success_message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 shadow-sm p-4 mb-4 text-dark"
                        style="background-color: #f8d7da;">
                        <div class="d-flex">
                            <div class="me-3 fs-3 text-danger">
                                <i class="fa fa-times-circle"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Terjadi Kesalahan</h5>
                                <ul class="mb-0 fs-sm ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-card card p-4 p-md-5">
                    <form action="{{ route('mitra.loker.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h4 class="fw-bold text-dark mb-4 border-bottom pb-2 text-primary"><i
                                class="fa fa-building me-2"></i> Profil Perusahaan & Posisi</h4>

                        <div class="row g-3 mb-4">
                            <!-- Nama Perusahaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Nama Perusahaan <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control"
                                    placeholder="Contoh: PT Teknologi Bangsa" required
                                    value="{{ old('company_name') }}">
                            </div>

                            <!-- Posisi Pekerjaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Posisi / Jabatan
                                    Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" name="position" class="form-control"
                                    placeholder="Contoh: Frontend Developer" required value="{{ old('position') }}">
                            </div>

                            <!-- Kategori Pekerjaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kategori Bidang <span
                                        class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="IT Developer" {{ old('category') == 'IT Developer' ? 'selected' : '' }}>IT Developer (Frontend/Backend/Fullstack)</option>
                                    <option value="Network & Security" {{ old('category') == 'Network & Security' ? 'selected' : '' }}>Network & Security Engineer</option>
                                    <option value="System & Data Analyst" {{ old('category') == 'System & Data Analyst' ? 'selected' : '' }}>System / Data Analyst</option>
                                    <option value="Design & Multimedia" {{ old('category') == 'Design & Multimedia' ? 'selected' : '' }}>UI/UX & Creative Design</option>
                                    <option value="Digital Marketing" {{ old('category') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing / SEO Specialist</option>
                                    <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                            </div>

                            <!-- Logo Perusahaan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Logo Perusahaan
                                    (Opsional)</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                <div class="form-text fs-xs">Format: JPG, PNG, JPEG. Max: 2MB.</div>
                            </div>

                            <!-- Poster Lowongan -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Poster Lowongan /
                                    Brosur (Opsional)</label>
                                <div id="poster-dropzone" class="border rounded-3 p-3 text-center bg-light"
                                    style="border-style: dashed !important; border-width: 2px !important; border-color: #cbd5e1 !important; cursor: pointer; transition: all 0.2s ease-in-out;">
                                    <i class="fa fa-cloud-upload-alt text-muted fa-2x mb-2"></i>
                                    <div class="fw-bold text-dark small">Pilih atau Tarik Gambar Poster</div>
                                    <div class="text-muted fs-xs mt-1">Maksimal 10 gambar. Format: JPG, JPEG, PNG. Max
                                        2MB per gambar.</div>
                                </div>
                                <input type="file" id="posters-input" name="posters[]" class="d-none" accept="image/*"
                                    multiple>

                                <!-- Preview Container -->
                                <div id="poster-previews" class="row g-2 mt-2" style="display: none;"></div>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-4 border-bottom pb-2 text-primary"><i
                                class="fa fa-file-invoice me-2"></i> Detail & Persyaratan Kerja</h4>

                        <div class="row g-3 mb-4">
                            <!-- Deskripsi Pekerjaan -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small text-uppercase">Deskripsi Pekerjaan
                                    (Opsional)</label>
                                <textarea name="description" rows="4" class="form-control"
                                    placeholder="Tuliskan gambaran umum, tugas, dan tanggung jawab posisi ini...">{{ old('description') }}</textarea>
                            </div>

                            <!-- Persyaratan Pekerjaan -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kualifikasi /
                                    Persyaratan (Opsional)</label>
                                <textarea name="requirements" rows="4" class="form-control"
                                    placeholder="Tuliskan kualifikasi (contoh: Pendidikan minimal, skill yang wajib dikuasai, pengalaman kerja)...">{{ old('requirements') }}</textarea>
                            </div>
                        </div>

                        <h4 class="fw-bold text-dark mb-4 border-bottom pb-2 text-primary"><i
                                class="fa fa-map-marker-alt me-2"></i> Lokasi, Gaji, & Kontak</h4>

                        <div class="row g-3 mb-4">
                            <!-- Lokasi -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Lokasi Penempatan
                                    (Opsional)</label>
                                <input type="text" name="location" class="form-control"
                                    placeholder="Contoh: Jakarta / Remote (WFH)" value="{{ old('location') }}">
                            </div>

                            <!-- Rentang Gaji -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Rentang Gaji
                                    (Opsional)</label>
                                <input type="text" name="salary_range" class="form-control"
                                    placeholder="Contoh: Rp 6.000.000 - Rp 9.000.000" value="{{ old('salary_range') }}">
                            </div>

                            <!-- Email Kontak -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Email Pendaftaran
                                    (Opsional)</label>
                                <input type="email" name="contact_email" class="form-control"
                                    placeholder="Contoh: recruit@company.com" value="{{ old('contact_email') }}">
                            </div>

                            <!-- Link Pendaftaran -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small text-uppercase">Link Pendaftaran
                                    Online (Opsional)</label>
                                <input type="url" name="contact_link" class="form-control"
                                    placeholder="Contoh: https://careers.company.com" value="{{ old('contact_link') }}">
                            </div>
                        </div>

                        <div class="text-end pt-3">
                            <button type="submit" class="btn btn-primary btn-submit text-white px-5 py-3 shadow"><i
                                    class="fa fa-paper-plane me-2"></i> Unggah Lowongan Kerja</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="small text-white/50 mb-0">&copy; 2026 Universitas Harkat Negeri. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <style>
        #poster-dropzone:hover {
            background-color: #e2e8f0 !important;
            border-color: #3b82f6 !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropzone = document.getElementById('poster-dropzone');
            const input = document.getElementById('posters-input');
            const previewContainer = document.getElementById('poster-previews');
            const dataTransfer = new DataTransfer();

            // Trigger input click when clicking dropzone
            dropzone.addEventListener('click', () => input.click());

            // Drag and drop events
            dropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropzone.style.backgroundColor = '#e2e8f0';
                dropzone.style.borderColor = '#3b82f6';
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.style.backgroundColor = '';
                dropzone.style.borderColor = '#cbd5e1';
            });

            dropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropzone.style.backgroundColor = '';
                dropzone.style.borderColor = '#cbd5e1';

                if (e.dataTransfer.files.length) {
                    handleFiles(e.dataTransfer.files);
                }
            });

            // Handle input change
            input.addEventListener('change', () => {
                if (input.files.length) {
                    handleFiles(input.files);
                }
            });

            function handleFiles(files) {
                const fileArray = Array.from(files);

                // Filter out non-images
                const imageFiles = fileArray.filter(file => file.type.startsWith('image/'));

                if (imageFiles.length === 0) {
                    alert('Hanya diperbolehkan mengunggah file gambar.');
                    return;
                }

                // Check if we exceed 10 images limit
                if (dataTransfer.files.length + imageFiles.length > 10) {
                    alert('Maksimal hanya dapat mengunggah 10 poster.');
                    const remaining = 10 - dataTransfer.files.length;
                    imageFiles.splice(remaining);
                }

                imageFiles.forEach(file => {
                    // Check size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert(`File ${file.name} melebihi batas 2MB.`);
                        return;
                    }
                    dataTransfer.items.add(file);
                });

                // Update the file input
                input.files = dataTransfer.files;

                // Render preview
                renderPreviews();
            }

            function renderPreviews() {
                previewContainer.innerHTML = '';
                const files = dataTransfer.files;

                if (files.length === 0) {
                    previewContainer.style.display = 'none';
                    return;
                }

                previewContainer.style.display = 'flex';

                Array.from(files).forEach((file, index) => {
                    const url = URL.createObjectURL(file);

                    const col = document.createElement('div');
                    col.className = 'col-4 col-sm-3 position-relative mt-2';

                    col.innerHTML = `
                        <div class="card border rounded-3 overflow-hidden shadow-xs h-100 bg-light">
                            <img src="${url}" class="card-img-top img-fluid" style="height: 100px; object-fit: contain;" alt="Poster preview">
                            <div class="card-body p-1 text-center bg-white border-top">
                                <span class="text-truncate d-block small text-muted" style="max-width: 100%; font-size: 0.7rem;">${file.name}</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-xs rounded-circle position-absolute top-0 end-0 m-1 btn-delete-preview" data-index="${index}" style="width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; border: none; outline: none;">
                            <i class="fa fa-times"></i>
                        </button>
                    `;

                    col.querySelector('img').onload = function () {
                        URL.revokeObjectURL(url);
                    };

                    previewContainer.appendChild(col);
                });

                // Add event listeners for delete buttons
                document.querySelectorAll('.btn-delete-preview').forEach(btn => {
                    btn.addEventListener('click', function (e) {
                        e.stopPropagation();
                        const indexToDelete = parseInt(this.dataset.index);

                        const newDt = new DataTransfer();
                        Array.from(dataTransfer.files).forEach((file, idx) => {
                            if (idx !== indexToDelete) {
                                newDt.items.add(file);
                            }
                        });

                        while (dataTransfer.files.length > 0) {
                            dataTransfer.items.remove(0);
                        }
                        Array.from(newDt.files).forEach(file => dataTransfer.items.add(file));

                        input.files = dataTransfer.files;
                        renderPreviews();
                    });
                });
            }
        });
    </script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>