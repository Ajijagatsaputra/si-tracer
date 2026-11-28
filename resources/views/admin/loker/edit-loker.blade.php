@extends('layouts.admin')

@section('content')
    <style>
        .loker-edit-page { max-width: 1440px; margin-inline: auto; }
        .loker-edit-form-card { max-width: 1080px; margin: 0 auto 2rem; }
        .loker-edit-card-header { flex-wrap: wrap; gap: 1rem; }
        .loker-edit-form-card .akila-form-section { padding: clamp(1rem, 2.4vw, 1.5rem); }
        .loker-edit-form-card .form-control, .loker-edit-form-card .form-select { min-width: 0; min-height: 46px; border-color: #dce3ed; border-radius: 10px; box-shadow: none; }
        .loker-edit-form-card textarea.form-control { min-height: auto; }
        .loker-edit-form-card .form-control:focus, .loker-edit-form-card .form-select:focus { border-color: #5478a8; box-shadow: 0 0 0 3px rgba(84, 120, 168, .13); }
        .loker-edit-form-card .form-label { margin-bottom: .5rem; color: #475569 !important; }
        .loker-edit-form-card #poster-dropzone { min-height: 135px; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 14px !important; background: #f8fafc !important; }
        .loker-edit-form-card .form-control[type=file] { padding: .45rem; }
        .loker-edit-form-card .form-control[type=file]::file-selector-button { margin: -.45rem .75rem -.45rem -.45rem; padding: .7rem .85rem; border: 0; border-right: 1px solid #dce3ed; background: #f1f5f9; color: #334155; }
        .loker-edit-form-card .btn-primary, .loker-edit-form-card .btn-alt-secondary, .loker-edit-form-card .btn-akila-outline { min-height: 44px; padding: .7rem 1.1rem; border-radius: 11px; font-weight: 700; transition: transform .18s ease, box-shadow .18s ease, background-color .18s ease; }
        .loker-edit-form-card .akila-form-footer { display: flex; justify-content: flex-end; align-items: center; gap: .75rem; margin-top: 1.25rem; padding: 1rem clamp(1rem, 2.4vw, 1.5rem); border-top: 1px solid #e8edf4; }
        .loker-edit-form-card .akila-form-footer .btn-primary { border: 0; background: linear-gradient(135deg, #5478e8, #4167d5); box-shadow: 0 6px 16px rgba(65, 103, 213, .24); }
        .loker-edit-form-card .akila-form-footer .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 9px 20px rgba(65, 103, 213, .3); }
        .loker-edit-form-card .akila-form-footer .btn-akila-outline:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(15, 23, 42, .08); }
        @media (max-width: 767.98px) {
            .loker-edit-page { padding-inline: .75rem; }
            .loker-edit-form-card { margin-bottom: 1.25rem; }
            .loker-edit-card-header { align-items: flex-start; }
            .loker-edit-form-card .akila-form-section { margin-inline: 0; }
            .loker-edit-form-card .akila-form-footer { justify-content: stretch; }
            .loker-edit-form-card .akila-form-footer > * { flex: 1 1 0; text-align: center; }
        }
        @media (max-width: 480px) {
            .loker-edit-page { padding-inline: .5rem; }
            .loker-edit-form-card .akila-section-header { align-items: flex-start; }
            .loker-edit-form-card .akila-section-hint { width: 100%; margin-left: 2.8rem; }
            .loker-edit-form-card .akila-form-footer { flex-direction: column-reverse; align-items: stretch; }
            .loker-edit-form-card .akila-form-footer > * { width: 100%; text-align: center; }
            .loker-edit-form-card #poster-dropzone { padding: 1rem !important; }
        }
    </style>
    <div class="akila-page-wrap loker-edit-page">
        <div class="akila-breadcrumb">
            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-home me-1"></i>Home</a>
            <span class="sep">›</span>
            <a href="{{ route('admin.loker.index') }}">Bursa Kerja</a>
            <span class="sep">›</span>
            <a href="{{ route('admin.loker.index') }}">Kelola Loker</a>
            <span class="sep">›</span>
            <span class="active">Edit Lowongan</span>
        </div>

        <div class="akila-list-card loker-edit-form-card">
            <div class="akila-card-header loker-edit-card-header">
                <div>
                    <h1 class="akila-title"><i class="far fa-edit text-primary me-2"></i>Edit Lowongan Kerja</h1>
                    <p class="akila-subtitle">Perbarui informasi <strong>{{ $job->position }}</strong> · Perubahan akan langsung aktif.</p>
                </div>
                <div class="akila-header-actions">
                    <a href="{{ route('admin.loker.index') }}" class="btn-akila-outline"><i class="fa fa-arrow-left"></i> Kembali ke Daftar</a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 alert alert-success alert-dismissible fade show" role="alert"><i class="fa fa-check-circle me-1"></i> {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if($errors->any())
                <div class="mb-4 akila-alert-banner" style="background:#fef2f2;border-color:#fecaca;color:#991b1b">
                    <div class="akila-alert-body"><div class="akila-alert-icon" style="background:#fee2e2;color:#dc2626"><i class="fa fa-exclamation-circle"></i></div>
                        <div class="akila-alert-content"><div class="akila-alert-title" style="color:#7f1d1d">Terdapat Kesalahan Input</div><ul class="mb-0 ps-3 small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                    </div>
                </div>
            @endif
            <form action="{{ route('admin.loker.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="akila-form-section">
                        <div class="akila-section-header">
                            <div class="akila-section-title-wrap"><span class="akila-step-badge">1</span><h2 class="akila-section-title">Profil Perusahaan & Posisi</h2></div>
                            <span class="akila-section-hint">Identitas perusahaan, posisi, dan materi promosi</span>
                        </div>
                        <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Nama Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control"
                                placeholder="Contoh: PT Teknologi Bangsa" required
                                value="{{ old('company_name', $job->company_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Posisi / Jabatan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="position" class="form-control" placeholder="Contoh: Frontend Developer"
                                required value="{{ old('position', $job->position) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Kategori Bidang <span
                                    class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="" disabled>Pilih Kategori</option>
                                <option value="IT Developer" {{ old('category', $job->category) == 'IT Developer' ? 'selected' : '' }}>IT Developer (Frontend/Backend/Fullstack)</option>
                                <option value="Network & Security" {{ old('category', $job->category) == 'Network & Security' ? 'selected' : '' }}>Network & Security Engineer</option>
                                <option value="System & Data Analyst" {{ old('category', $job->category) == 'System & Data Analyst' ? 'selected' : '' }}>System / Data Analyst</option>
                                <option value="Design & Multimedia" {{ old('category', $job->category) == 'Design & Multimedia' ? 'selected' : '' }}>UI/UX & Creative Design</option>
                                <option value="Digital Marketing" {{ old('category', $job->category) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing / SEO Specialist</option>
                                <option value="Others" {{ old('category', $job->category) == 'Others' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Logo Perusahaan (Opsional)</label>
                            <div class="gap-3 d-flex align-items-center">
                                @if($job->logo_path)
                                    <div class="position-relative">
                                        <img src="{{ $job->logo_path }}" alt="Logo Saat Ini" class="p-1 border rounded bg-light"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control" accept="image/*">
                                    <div class="form-text">Format: JPG, PNG, JPEG. Max: 2MB. Kosongkan jika tidak ingin
                                        mengubah logo.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Posters Section -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Poster Lowongan / Brosur (Opsional)</label>

                            <!-- Existing Posters -->
                            @if(is_array($job->poster_paths) && count($job->poster_paths) > 0)
                                <div class="mb-3">
                                    <div class="mb-2 fw-bold text-dark small"><i class="fa fa-images me-1"></i> Poster Saat Ini
                                        (Centang untuk mempertahankan atau klik hapus):</div>
                                    <div class="row g-2" id="existing-posters-container">
                                        @foreach($job->poster_paths as $idx => $path)
                                            <div class="col-4 col-sm-3 position-relative existing-poster-card"
                                                id="existing-poster-{{ $idx }}">
                                                <input type="hidden" name="keep_posters[]" value="{{ $path }}">
                                                <div class="overflow-hidden border shadow-xs card rounded-3 h-100 bg-light">
                                                    <img src="{{ $path }}" class="card-img-top img-fluid"
                                                        style="height: 100px; object-fit: contain;" alt="Poster">
                                                    <div class="p-1 text-center bg-white card-body border-top">
                                                        <span class="text-truncate d-block small text-muted"
                                                            style="max-width: 100%; font-size: 0.7rem;">Poster {{ $idx + 1 }}</span>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="top-0 m-1 btn btn-danger btn-xs rounded-circle position-absolute end-0 btn-delete-existing"
                                                    data-target="existing-poster-{{ $idx }}"
                                                    style="width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; border: none; outline: none;">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Drag & Drop Zone for New Posters -->
                            <div id="poster-dropzone" class="p-3 text-center border rounded-3 bg-light"
                                style="border-style: dashed !important; border-width: 2px !important; border-color: #cbd5e1 !important; cursor: pointer; transition: all 0.2s ease-in-out;">
                                <i class="mb-2 fa fa-cloud-upload-alt text-muted fa-2x"></i>
                                <div class="fw-bold text-dark small">Pilih atau Tarik Gambar Poster Baru</div>
                                <div class="mt-1 text-muted fs-xs">Maksimal 10 gambar (gabungan lama + baru). Format: JPG,
                                    JPEG, PNG. Max 2MB per gambar.</div>
                            </div>
                            <input type="file" id="posters-input" name="posters[]" class="d-none" accept="image/*" multiple>

                            <!-- Preview Container for New Posters -->
                            <div id="poster-previews" class="mt-2 row g-2" style="display: none;"></div>
                        </div>
                        </div>
                    </div>

                    <div class="akila-form-section">
                        <div class="akila-section-header">
                            <div class="akila-section-title-wrap"><span class="akila-step-badge">2</span><h2 class="akila-section-title">Detail & Persyaratan Kerja</h2></div>
                            <span class="akila-section-hint">Uraian pekerjaan dan kriteria kandidat</span>
                        </div>
                        <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Deskripsi Pekerjaan (Opsional)</label>
                            <textarea name="description" rows="4" class="form-control"
                                placeholder="Tuliskan gambaran umum, tugas, dan tanggung jawab posisi ini...">{{ old('description', $job->description) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Kualifikasi / Persyaratan (Opsional)</label>
                            <textarea name="requirements" rows="4" class="form-control"
                                placeholder="Tuliskan kualifikasi (contoh: Pendidikan minimal, skill yang wajib dikuasai)...">{{ old('requirements', $job->requirements) }}</textarea>
                        </div>
                        </div>
                    </div>

                    <div class="akila-form-section">
                        <div class="akila-section-header">
                            <div class="akila-section-title-wrap"><span class="akila-step-badge">3</span><h2 class="akila-section-title">Lokasi, Gaji, & Kontak</h2></div>
                            <span class="akila-section-hint">Informasi penempatan dan cara melamar</span>
                        </div>
                        <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Lokasi Penempatan (Opsional)</label>
                            <input type="text" name="location" class="form-control"
                                placeholder="Contoh: Jakarta / Remote (WFH)" value="{{ old('location', $job->location) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Rentang Gaji (Opsional)</label>
                            <input type="text" name="salary_range" class="form-control"
                                placeholder="Contoh: Rp 6.000.000 - Rp 9.000.000"
                                value="{{ old('salary_range', $job->salary_range) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Email Pendaftaran (Opsional)</label>
                            <input type="email" name="contact_email" class="form-control"
                                placeholder="Contoh: recruit@company.com"
                                value="{{ old('contact_email', $job->contact_email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Link Pendaftaran Online (Opsional)</label>
                            <input type="url" name="contact_link" class="form-control"
                                placeholder="Contoh: https://careers.company.com"
                                value="{{ old('contact_link', $job->contact_link) }}">
                        </div>
                        </div>
                    </div>
                    <div class="akila-form-footer">
                        <a href="{{ route('admin.loker.index') }}" class="btn-akila-outline"><i class="fa fa-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>
        </div>
    </div>
@endsection

@section('scripts')
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

            // Handle existing posters deletion
            document.querySelectorAll('.btn-delete-existing').forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetId = this.dataset.target;
                    const el = document.getElementById(targetId);
                    if (el) {
                        el.remove();
                    }
                });
            });

            function getExistingPostersCount() {
                return document.querySelectorAll('.existing-poster-card').length;
            }

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

                const existingCount = getExistingPostersCount();
                // Check if we exceed 10 images limit
                if (existingCount + dataTransfer.files.length + imageFiles.length > 10) {
                    alert('Maksimal total poster (lama + baru) adalah 10 gambar.');
                    const remaining = 10 - existingCount - dataTransfer.files.length;
                    if (remaining <= 0) {
                        return;
                    }
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
                                        <div class="overflow-hidden border shadow-xs card rounded-3 h-100 bg-light">
                                            <img src="${url}" class="card-img-top img-fluid" style="height: 100px; object-fit: contain;" alt="Poster preview">
                                            <div class="p-1 text-center bg-white card-body border-top">
                                                <span class="text-truncate d-block small text-muted" style="max-width: 100%; font-size: 0.7rem;">${file.name}</span>
                                            </div>
                                        </div>
                                        <button type="button" class="top-0 m-1 btn btn-danger btn-xs rounded-circle position-absolute end-0 btn-delete-preview" data-index="${index}" style="width: 20px; height: 20px; padding: 0; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; border: none; outline: none;">
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
@endsection
