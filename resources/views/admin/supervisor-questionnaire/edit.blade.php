@extends('layouts.admin')

@section('content')
    <!-- Hero -->
    <div class="bg-body-light border-bottom py-3">
        <div class="content d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold mb-0 text-primary">
                    <i class="fa fa-pencil-alt me-2"></i> Edit Supervisor Questionnaire
                </h1>
                <p class="text-muted fs-sm mb-0">Edit data kuesioner supervisor.</p>
            </div>
            <div>
                <a href="{{ route('admin.supervisor-questionnaire.show', $questionnaire->id) }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
                <a href="{{ route('admin.supervisor-questionnaire.dashboard') }}" class="btn btn-primary ms-2">
                    <i class="fa fa-chart-pie me-1"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded shadow-sm">
            <div class="block-header block-header-default bg-light">
                <h3 class="block-title fw-semibold text-primary mb-0">
                    <i class="fa fa-edit me-2"></i> Form Edit
                </h3>
            </div>
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="block-content block-content-full">
                <form action="{{ route('admin.supervisor-questionnaire.update', $questionnaire->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Informasi Alumni -->
                        <div class="col-12">
                            <h5 class="text-primary mb-3">
                                <i class="fa fa-user me-2"></i> Informasi Alumni
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_alumni" class="form-label">Nama Alumni <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_alumni') is-invalid @enderror"
                                   id="nama_alumni" name="nama_alumni"
                                   value="{{ old('nama_alumni', $questionnaire->nama_alumni) }}" required>
                            @error('nama_alumni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="jabatan_alumni" class="form-label">Jabatan Alumni <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan_alumni') is-invalid @enderror"
                                   id="jabatan_alumni" name="jabatan_alumni"
                                   value="{{ old('jabatan_alumni', $questionnaire->jabatan_alumni) }}" required>
                            @error('jabatan_alumni')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_mulai_kerja" class="form-label">Tanggal Mulai Kerja</label>
                            <input type="date" class="form-control @error('tanggal_mulai_kerja') is-invalid @enderror"
                                   id="tanggal_mulai_kerja" name="tanggal_mulai_kerja"
                                   value="{{ old('tanggal_mulai_kerja', $questionnaire->tanggal_mulai_kerja ? $questionnaire->tanggal_mulai_kerja->format('Y-m-d') : '') }}">
                            @error('tanggal_mulai_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informasi Atasan -->
                        <div class="col-12">
                            <h5 class="text-primary mb-3 mt-4">
                                <i class="fa fa-user-tie me-2"></i> Informasi Atasan
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_atasan" class="form-label">Nama Atasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_atasan') is-invalid @enderror"
                                   id="nama_atasan" name="nama_atasan"
                                   value="{{ old('nama_atasan', $questionnaire->nama_atasan) }}" required>
                            @error('nama_atasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="jabatan_atasan" class="form-label">Jabatan Atasan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('jabatan_atasan') is-invalid @enderror"
                                   id="jabatan_atasan" name="jabatan_atasan"
                                   value="{{ old('jabatan_atasan', $questionnaire->jabatan_atasan) }}" required>
                            @error('jabatan_atasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email_atasan" class="form-label">Email Atasan</label>
                            <input type="email" class="form-control @error('email_atasan') is-invalid @enderror"
                                   id="email_atasan" name="email_atasan"
                                   value="{{ old('email_atasan', $questionnaire->email_atasan) }}">
                            @error('email_atasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="wa_atasan" class="form-label">WhatsApp Atasan</label>
                            <input type="text" class="form-control @error('wa_atasan') is-invalid @enderror"
                                   id="wa_atasan" name="wa_atasan"
                                   value="{{ old('wa_atasan', $questionnaire->wa_atasan) }}"
                                   placeholder="+6281234567890">
                            @error('wa_atasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informasi Perusahaan -->
                        <div class="col-12">
                            <h5 class="text-primary mb-3 mt-4">
                                <i class="fa fa-building me-2"></i> Informasi Perusahaan
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror"
                                   id="nama_perusahaan" name="nama_perusahaan"
                                   value="{{ old('nama_perusahaan', $questionnaire->nama_perusahaan) }}" required>
                            @error('nama_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status dan Pengaturan -->
                        <div class="col-12">
                            <h5 class="text-primary mb-3 mt-4">
                                <i class="fa fa-cogs me-2"></i> Status dan Pengaturan
                            </h5>
                        </div>

                        <div class="col-md-6">
                            <label for="status_pengisian" class="form-label">Status Pengisian <span class="text-danger">*</span></label>
                            <select class="form-select @error('status_pengisian') is-invalid @enderror"
                                    id="status_pengisian" name="status_pengisian" required>
                                <option value="pending" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'pending' ? 'selected' : '' }}>
                                    Menunggu
                                </option>
                                <option value="completed" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'completed' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="expired" {{ old('status_pengisian', $questionnaire->status_pengisian) == 'expired' ? 'selected' : '' }}>
                                    Kadaluarsa
                                </option>
                            </select>
                            @error('status_pengisian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="expires_at" class="form-label">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                   id="expires_at" name="expires_at"
                                   value="{{ old('expires_at', $questionnaire->expires_at ? (is_object($questionnaire->expires_at) ? $questionnaire->expires_at->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($questionnaire->expires_at)->format('Y-m-d\TH:i')) : '') }}" required>
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.supervisor-questionnaire.show', $questionnaire->id) }}"
                                   class="btn btn-secondary">
                                    <i class="fa fa-times me-1"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Auto-format WhatsApp number
        document.getElementById('wa_atasan').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            } else if (!value.startsWith('62')) {
                value = '62' + value;
            }

            e.target.value = value;
        });

        // Set default expiry date if empty
        document.addEventListener('DOMContentLoaded', function() {
            const expiresAtField = document.getElementById('expires_at');
            if (!expiresAtField.value) {
                const now = new Date();
                now.setDate(now.getDate() + 7); // 7 days from now
                expiresAtField.value = now.toISOString().slice(0, 16);
            }
        });
    </script>
@endsection
