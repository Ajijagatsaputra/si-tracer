@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-white">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        <span class="bg-primary-lighter p-2 rounded-3 me-2">
                            <i class="fa fa-plus-circle text-primary"></i>
                        </span>
                        Tambah Lowongan Kerja
                    </h1>
                    <p class="fs-sm fw-medium text-muted mb-0">
                        Unggah lowongan pekerjaan baru. Loker dari admin langsung aktif tanpa perlu moderasi.
                    </p>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('admin.loker.index') }}">Kelola Loker</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Loker</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-times-circle me-1"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="block block-rounded shadow-sm">
            <div class="block-content block-content-full p-4">
                <form action="{{ route('admin.loker.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        <i class="fa fa-building me-1"></i> Profil Perusahaan & Posisi
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Nama Perusahaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control"
                                placeholder="Contoh: PT Teknologi Bangsa" required value="{{ old('company_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Posisi / Jabatan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="position" class="form-control" placeholder="Contoh: Frontend Developer"
                                required value="{{ old('position') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Kategori Bidang <span
                                    class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="IT Developer" {{ old('category') == 'IT Developer' ? 'selected' : '' }}>IT
                                    Developer (Frontend/Backend/Fullstack)</option>
                                <option value="Network & Security" {{ old('category') == 'Network & Security' ? 'selected' : '' }}>Network & Security Engineer</option>
                                <option value="System & Data Analyst" {{ old('category') == 'System & Data Analyst' ? 'selected' : '' }}>System / Data Analyst</option>
                                <option value="Design & Multimedia" {{ old('category') == 'Design & Multimedia' ? 'selected' : '' }}>UI/UX & Creative Design</option>
                                <option value="Digital Marketing" {{ old('category') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing / SEO Specialist</option>
                                <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Logo Perusahaan (Opsional)</label>
                            <input type="file" name="logo" class="form-control" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, JPEG. Max: 2MB.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Poster Lowongan / Brosur (Opsional)</label>
                            <div id="poster-dropzone" class="border rounded-3 p-3 text-center bg-light"
                                style="border-style: dashed !important; border-width: 2px !important; border-color: #cbd5e1 !important; cursor: pointer; transition: all 0.2s ease-in-out;">
                                <i class="fa fa-cloud-upload-alt text-muted fa-2x mb-2"></i>
                                <div class="fw-bold text-dark small">Pilih atau Tarik Gambar Poster</div>
                                <div class="text-muted fs-xs mt-1">Maksimal 10 gambar. Format: JPG, JPEG, PNG. Max 2MB per
                                    gambar.</div>
                            </div>
                            <input type="file" id="posters-input" name="posters[]" class="d-none" accept="image/*" multiple>

                            <!-- Preview Container -->
                            <div id="poster-previews" class="row g-2 mt-2" style="display: none;"></div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        <i class="fa fa-file-invoice me-1"></i> Detail & Persyaratan Kerja
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Deskripsi Pekerjaan (Opsional)</label>
                            <textarea name="description" rows="4" class="form-control"
                                placeholder="Tuliskan gambaran umum, tugas, dan tanggung jawab posisi ini...">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-muted small">Kualifikasi / Persyaratan (Opsional)</label>
                            <textarea name="requirements" rows="4" class="form-control"
                                placeholder="Tuliskan kualifikasi (contoh: Pendidikan minimal, skill yang wajib dikuasai)...">{{ old('requirements') }}</textarea>
                        </div>
                    </div>

                    <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">
                        <i class="fa fa-map-marker-alt me-1"></i> Lokasi, Gaji, & Kontak
                    </h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Lokasi Penempatan (Opsional)</label>
                            <input type="text" name="location" class="form-control"
                                placeholder="Contoh: Jakarta / Remote (WFH)" value="{{ old('location') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Rentang Gaji (Opsional)</label>
                            <input type="text" name="salary_range" class="form-control"
                                placeholder="Contoh: Rp 6.000.000 - Rp 9.000.000" value="{{ old('salary_range') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Email Pendaftaran (Opsional)</label>
                            <input type="email" name="contact_email" class="form-control"
                                placeholder="Contoh: recruit@company.com" value="{{ old('contact_email') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-muted small">Link Pendaftaran Online (Opsional)</label>
                            <input type="url" name="contact_link" class="form-control"
                                placeholder="Contoh: https://careers.company.com" value="{{ old('contact_link') }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('admin.loker.index') }}" class="btn btn-alt-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa fa-paper-plane me-1"></i> Publish Lowongan
                        </button>
                    </div>
                </form>
            </div>
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
@endsection