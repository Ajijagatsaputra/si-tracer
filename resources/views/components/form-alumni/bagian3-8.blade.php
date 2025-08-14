<!-- BAGIAN 3: WAKTU MENDAPAT PEKERJAAN -->
{{-- <div class="section-card animate-fade-in" id="waktuAlumniMendapatkanPekerjaan" style="display: none;">
    <div class="section-header">
        <i class="fas fa-clock"></i>
        Waktu Mendapat Pekerjaan
    </div>
    <div class="section-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Kapan Anda mendapatkan pekerjaan?</label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mendapatkan_pekerjaan" id="kurang6bulan" value="<=6bulan"
                                   {{ old('mendapatkan_pekerjaan', $tracer->pekerjaan->mendapatkan_pekerjaan ?? '') == '<=6bulan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="kurang6bulan">
                                Sebelum lulus (< 6 bulan)
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mendapatkan_pekerjaan" id="lebih6bulan" value=">6bulan"
                                   {{ old('mendapatkan_pekerjaan', $tracer->pekerjaan->mendapatkan_pekerjaan ?? '') == '>6bulan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lebih6bulan">
                                Setelah lulus (> 6 bulan)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bulan Kerja (conditional) -->
            <div class="col-md-6" id="bulanKerjaKurang6" style="display: none;">
                <label for="bulan_kerja_kurang6" class="form-label">Berapa bulan sebelum lulus?</label>
                <input type="number" name="bulan_kerja_kurang6" id="bulan_kerja_kurang6" class="form-control"
                       value="{{ old('bulan_kerja_kurang6', $tracer->pekerjaan->bulan_kerja ?? '') }}" placeholder="Masukkan jumlah bulan">
            </div>

            <div class="col-md-6" id="bulanKerjaLebih6" style="display: none;">
                <label for="bulan_kerja_lebih6" class="form-label">Berapa bulan setelah lulus?</label>
                <input type="number" name="bulan_kerja_lebih6" id="bulan_kerja_lebih6" class="form-control"
                       value="{{ old('bulan_kerja_lebih6', $tracer->pekerjaan->bulan_kerja ?? '') }}" placeholder="Masukkan jumlah bulan">
            </div>

            <!-- Pendapatan (conditional) -->
            <div class="col-md-6" id="pendapatanKurang6" style="display: none;">
                <label for="pendapatan_kurang6" class="form-label">Pendapatan sebelum lulus (Rp)</label>
                <input type="number" name="pendapatan_kurang6" id="pendapatan_kurang6" class="form-control"
                       value="{{ old('pendapatan_kurang6', $tracer->pekerjaan->pendapatan ?? '') }}" placeholder="Contoh: 5000000">
            </div>

            <div class="col-md-6" id="pendapatanLebih6" style="display: none;">
                <label for="pendapatan_lebih6" class="form-label">Pendapatan setelah lulus (Rp)</label>
                <input type="number" name="pendapatan_lebih6" id="pendapatan_lebih6" class="form-control"
                       value="{{ old('pendapatan_lebih6', $tracer->pekerjaan->pendapatan ?? '') }}" placeholder="Contoh: 5000000">
            </div>
        </div>
    </div>
</div> --}}

{{-- <!-- BAGIAN 4: LOKASI KERJA -->
<div class="section-card animate-fade-in" id="lokasikerja" style="display: none;">
    <div class="section-header">
        <i class="fas fa-map-marker-alt"></i>
        Lokasi & Detail Pekerjaan
    </div>
    <div class="section-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control"
                       value="{{ old('nama_perusahaan', $tracer->pekerjaan->nama_perusahaan ?? '') }}" placeholder="Contoh: PT. Teknologi Indonesia">
            </div>

            <div class="col-md-6">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control"
                       value="{{ old('jabatan', $tracer->pekerjaan->jabatan ?? '') }}" placeholder="Contoh: Software Developer">
            </div>

            <div class="col-12">
                <label for="alamat_pekerjaan" class="form-label">Alamat Pekerjaan</label>
                <textarea name="alamat_pekerjaan" id="alamat_pekerjaan" class="form-control" rows="2"
                          placeholder="Alamat lengkap tempat kerja">{{ old('alamat_pekerjaan', $tracer->pekerjaan->alamat_pekerjaan ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" name="provinsi" id="provinsi" class="form-control"
                       value="{{ old('provinsi', $tracer->pekerjaan->provinsi ?? '') }}" placeholder="Contoh: DKI Jakarta">
            </div>

            <div class="col-md-6">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" name="kota" id="kota" class="form-control"
                       value="{{ old('kota', $tracer->pekerjaan->kota ?? '') }}" placeholder="Contoh: Jakarta Selatan">
            </div>

            <div class="col-md-6">
                <label for="tingkat_usaha_level" class="form-label">Tingkat Tempat Kerja</label>
                <select name="tingkat_usaha_level" id="tingkat_usaha_level" class="form-select">
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="lokal" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                    <option value="nasional" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="multinasional" {{ old('tingkat_usaha_level', $tracer->pekerjaan->tingkat_usaha_level ?? '') == 'multinasional' ? 'selected' : '' }}>Multinasional/Internasional</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- BAGIAN 5: KESESUAIAN PEKERJAAN -->
<div class="section-card animate-fade-in" id="kesesuaianPekerjaan" style="display: none;">
    <div class="section-header">
        <i class="fas fa-check-circle"></i>
        Kesesuaian Pekerjaan
    </div>
    <div class="section-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="hubungan_studi_pekerjaan" class="form-label">Hubungan Studi dengan Pekerjaan</label>
                <select name="hubungan_studi_pekerjaan" id="hubungan_studi_pekerjaan" class="form-select">
                    <option value="">-- Pilih Hubungan --</option>
                    <option value="sangat_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'sangat_erat' ? 'selected' : '' }}>Sangat Erat</option>
                    <option value="erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'erat' ? 'selected' : '' }}>Erat</option>
                    <option value="cukup_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'cukup_erat' ? 'selected' : '' }}>Cukup Erat</option>
                    <option value="kurang_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'kurang_erat' ? 'selected' : '' }}>Kurang Erat</option>
                    <option value="tidak_erat" {{ old('hubungan_studi_pekerjaan', $tracer->pekerjaan->hubungan_studi_pekerjaan ?? '') == 'tidak_erat' ? 'selected' : '' }}>Tidak Erat</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="pendidikan_sesuai_pekerjaan" class="form-label">Tingkat pendidikan yang paling tepat untuk pekerjaan saat ini</label>
                <select name="pendidikan_sesuai_pekerjaan" id="pendidikan_sesuai_pekerjaan" class="form-select">
                    <option value="">-- Pilih Tingkat Pendidikan --</option>
                    <option value="lebih_tinggi" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'lebih_tinggi' ? 'selected' : '' }}>Setingkat Lebih Tinggi</option>
                    <option value="sama" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'sama' ? 'selected' : '' }}>Tingkat yang Sama</option>
                    <option value="lebih_rendah" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'lebih_rendah' ? 'selected' : '' }}>Setingkat Lebih Rendah</option>
                    <option value="tidak_perlu_pt" {{ old('pendidikan_sesuai_pekerjaan', $tracer->pekerjaan->pendidikan_sesuai_pekerjaan ?? '') == 'tidak_perlu_pt' ? 'selected' : '' }}>Tidak Perlu Pendidikan Tinggi</option>
                </select>
            </div>
        </div>
    </div>
</div> --}}

<!-- BAGIAN 6: DETAIL WIRAUSAHA -->
<div class="section-card animate-fade-in" id="wiraswasta" style="display: none;">
    <div class="section-header">
        <i class="fas fa-store"></i>
        Detail Wirausaha
    </div>
    <div class="section-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nama_usaha" class="form-label">
                    <i class="fas fa-building text-primary"></i>
                    Nama Usaha
                </label>
                <input type="text" name="nama_usaha" id="nama_usaha" class="form-control"
                       value="{{ old('nama_usaha', $tracer->wirausaha->nama_usaha ?? '') }}"
                       placeholder="Masukkan nama usaha Anda">
            </div>

            <div class="col-md-6">
                <label for="posisi_usaha" class="form-label">
                    <i class="fas fa-user-tie text-primary"></i>
                    Posisi dalam Usaha
                </label>
                <select name="posisi_usaha" id="posisi_usaha" class="form-select">
                    <option value="" disabled {{ old('posisi_usaha', $tracer->wirausaha->posisi_usaha ?? '') == '' ? 'selected' : '' }}>-- Pilih --</option>
                    <option value="founder" {{ old('posisi_usaha', $tracer->wirausaha->posisi_usaha ?? '') == 'founder' ? 'selected' : '' }}>1. Founder</option>
                    <option value="co-founder" {{ old('posisi_usaha', $tracer->wirausaha->posisi_usaha ?? '') == 'co-founder' ? 'selected' : '' }}>2. Co-Founder</option>
                    <option value="staff" {{ old('posisi_usaha', $tracer->wirausaha->posisi_usaha ?? '') == 'staff' ? 'selected' : '' }}>3. Staff</option>
                    <option value="freelance" {{ old('posisi_usaha', $tracer->wirausaha->posisi_usaha ?? '') == 'freelance' ? 'selected' : '' }}>4. Freelance</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="tingkat_usaha_level_wirausaha" class="form-label">
                    <i class="fas fa-globe text-primary"></i>
                    Tingkat Usaha
                </label>
                <select name="tingkat_usaha_level" id="tingkat_usaha_level_wirausaha" class="form-select">
                    <option value="">-- Pilih Tingkat --</option>
                    <option value="lokal" {{ old('tingkat_usaha_level', $tracer->wirausaha->tingkat_usaha_level ?? '') == 'lokal' ? 'selected' : '' }}>Lokal/Wilayah</option>
                    <option value="nasional" {{ old('tingkat_usaha_level', $tracer->wirausaha->tingkat_usaha_level ?? '') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="internasional" {{ old('tingkat_usaha_level', $tracer->wirausaha->tingkat_usaha_level ?? '') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="pendapatan_usaha" class="form-label">
                    <i class="fas fa-money-bill-wave text-primary"></i>
                    Pendapatan per Bulan (Rp)
                </label>
                <input type="number" name="pendapatan_usaha" id="pendapatan_usaha" class="form-control"
                       value="{{ old('pendapatan_usaha', $tracer->wirausaha->pendapatan_usaha ?? '') }}"
                       placeholder="Masukkan pendapatan per bulan">
            </div>

            <div class="col-12">
                <label for="alamat_usaha" class="form-label">
                    <i class="fas fa-map-marker-alt text-primary"></i>
                    Alamat Usaha
                </label>
                <textarea name="alamat_usaha" id="alamat_usaha" class="form-control" rows="3"
                          placeholder="Masukkan alamat lengkap lokasi usaha">{{ old('alamat_usaha', $tracer->wirausaha->alamat_usaha ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

<!-- BAGIAN 7: DETAIL PENDIDIKAN LANJUT -->
<div class="section-card animate-fade-in" id="detailLanjutStudy" style="display: none;">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fas fa-graduation-cap me-2"></i>Bagian 7: Detail Pendidikan Lanjut
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="universitas" class="form-label">Nama Universitas/Institusi</label>
                    <input type="text" name="universitas" id="universitas" class="form-control"
                           value="{{ old('universitas', $tracer->pendidikan->universitas ?? '') }}" placeholder="Contoh: Universitas Indonesia">
                </div>

                <div class="col-md-6">
                    <label for="program_studi" class="form-label">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" class="form-control"
                           value="{{ old('program_studi', $tracer->pendidikan->program_studi ?? '') }}" placeholder="Contoh: Magister Teknik Informatika">
                </div>

                <div class="col-md-6">
                    <label for="sumber_biaya" class="form-label">Sumber Biaya</label>
                    <select name="sumber_biaya" id="sumber_biaya" class="form-select">
                        <option value="">-- Pilih Sumber Biaya --</option>
                        <option value="biaya_sendiri" {{ old('sumber_biaya', $tracer->pendidikan->sumber_biaya ?? '') == 'biaya_sendiri' ? 'selected' : '' }}>Biaya Sendiri/Keluarga</option>
                        <option value="beasiswa_pemerintah" {{ old('sumber_biaya', $tracer->pendidikan->sumber_biaya ?? '') == 'beasiswa_pemerintah' ? 'selected' : '' }}>Beasiswa Pemerintah</option>
                        <option value="beasiswa_swasta" {{ old('sumber_biaya', $tracer->pendidikan->sumber_biaya ?? '') == 'beasiswa_swasta' ? 'selected' : '' }}>Beasiswa Swasta</option>
                        <option value="beasiswa_institusi" {{ old('sumber_biaya', $tracer->pendidikan->sumber_biaya ?? '') == 'beasiswa_institusi' ? 'selected' : '' }}>Beasiswa Institusi</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control"
                           value="{{ old('tanggal_masuk', isset($tracer->pendidikan) && $tracer->pendidikan->tanggal_masuk ? \Carbon\Carbon::parse($tracer->pendidikan->tanggal_masuk)->format('Y-m-d') : '') }}">
                </div>

                <div class="col-12">
                    <label for="lokasi_universitas" class="form-label">Lokasi Universitas</label>
                    <textarea name="lokasi_universitas" id="lokasi_universitas" class="form-control" rows="2"
                              placeholder="Alamat lengkap universitas">{{ old('lokasi_universitas', $tracer->pendidikan->lokasi_universitas ?? '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
