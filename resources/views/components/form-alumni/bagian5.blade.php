<!-- lokasi kerja -->
<div class="section-card animate-fade-in" id="lokasikerja" style="display: none;">
    <div class="section-header">
        <i class="fas fa-building"></i>
        Lokasi Pekerjaan
    </div>
    <div class="section-body">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-map-marker-alt text-primary"></i>
                    Alamat Tempat Kerja</label>
                <input type="text" name="alamat_pekerjaan" class="form-control"
                    placeholder="Jalan, Desa/Kelurahan, RT, RW, Kecamatan"
                    value="{{ old('alamat_pekerjaan', $tracer->pekerjaan->alamat_pekerjaan ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-map-marker-alt text-primary"></i>
                    Provinsi Tempat Bekerja</label>
                <select name="provinsi" id="provinsi" class="form-select">
                    <option value="" disabled {{ old('provinsi', $tracer->pekerjaan->provinsi ?? '') == '' ? 'selected' : '' }}>-- Pilih Provinsi --</option>
                    @foreach (\Laravolt\Indonesia\Models\Province::pluck('name', 'code') as $code => $name)
                        <option value="{{ $code }}" {{ old('provinsi', $tracer->pekerjaan->provinsi ?? '') == $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-map-marker-alt text-primary"></i>
                    Kabupaten / Kota</label>
                <select name="kota" id="kota" class="form-select">
                    <option value="" disabled {{ old('kota', $tracer->pekerjaan->kota ?? '') == '' ? 'selected' : '' }}>-- Pilih Kabupaten/Kota --</option>
                    @if(old('provinsi', $tracer->pekerjaan->provinsi ?? false))
                        @php
                            $cities = \Laravolt\Indonesia\Models\City::where('province_code', old('provinsi', $tracer->pekerjaan->provinsi ?? ''))->pluck('name', 'code');
                        @endphp
                        @foreach($cities as $code => $name)
                            <option value="{{ $code }}" {{ old('kota', $tracer->pekerjaan->kota ?? '') == $code ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Info pekerjaan tambahan -->
            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-globe text-primary"></i> Apa jenis perusahaan
                    instansi/institusi tempat anda bekerja sekarang?</label>
                <select name="tingkat_usaha_level" class="form-select">
                    <option value="" disabled {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == '' ? 'selected' : '' }}>-- Pilih tingkat --</option>
                    <option value="instansi" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'instansi' ? 'selected' : '' }}>1. Instansi pemerintah</option>
                    <option value="Organisasi" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'Organisasi' ? 'selected' : '' }}>2. Organisasi nonProfit/LSM</option>
                    <option value="perusahaan" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'perusahaan' ? 'selected' : '' }}>3. Perusahaan/Instansi Swasta</option>
                    <option value="Wirausaha" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'Wirausaha' ? 'selected' : '' }}>4. Wirausaha/Perusahaan Sendiri</option>
                    <option value="Bumn" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'Bumn' ? 'selected' : '' }}>5. BUMN/BUMD</option>
                    <option value="Instansi" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'Instansi' ? 'selected' : '' }}>6. Instansi Organisasi Multilateral</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-building text-primary"></i> Apa Nama
                    Perusahaan/Kantor tempat anda bekerja?</label>
                <input type="text" name="nama_perusahaan" class="form-control" placeholder="PT. Contoh Perusahaan"
                    value="{{ old('nama_perusahaan', $tracer->pekerjaan->nama_perusahaan ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class="fas fa-id-badge text-primary"></i>
                    Jabatan</label>
                <input type="text" name="jabatan" class="form-control" placeholder="Jabatan di perusahaan/kantor"
                    value="{{ old('jabatan', $tracer->pekerjaan->jabatan ?? '') }}">
            </div>

            <!-- Informasi Atasan -->
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi Atasan:</strong> Mohon isi data atasan/pimpinan Anda untuk keperluan evaluasi kinerja. Data ini akan digunakan untuk mengirim kuesioner evaluasi kepada atasan Anda.
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fas fa-user-tie text-primary"></i>
                        Nama Atasan/Pimpinan
                    </label>
                    <input type="text" name="nama_atasan" class="form-control"
                        placeholder="Masukkan nama atasan/pimpinan"
                        value="{{ old('nama_atasan', $tracer->pengguna->nama_atasan ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fas fa-briefcase text-primary"></i>
                        Jabatan Atasan
                    </label>
                    <input type="text" name="jabatan_atasan" class="form-control"
                        placeholder="Manager, Supervisor, dll"
                        value="{{ old('jabatan_atasan', $tracer->pengguna->jabatan_atasan ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fab fa-whatsapp text-success"></i>
                        Nomor WhatsApp Atasan
                    </label>
                    <input type="text" name="wa_atasan" class="form-control"
                        placeholder="+62812xxxxxxxx" pattern="^\+62[0-9]{9,12}$"
                        value="{{ old('wa_atasan', $tracer->pengguna->wa_atasan ?? '') }}">
                    <small class="form-text text-muted">Opsional, untuk notifikasi WhatsApp</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="fas fa-envelope text-primary"></i>
                        Email Atasan
                    </label>
                    <input type="email" name="email_atasan" class="form-control"
                        placeholder="atasan@perusahaan.com"
                        value="{{ old('email_atasan', $tracer->pengguna->email_atasan ?? '') }}">
                    <small class="form-text text-muted">Opsional, untuk notifikasi email</small>
                </div>
            </div>
        </div>
    </div>
</div>
