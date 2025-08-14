<!-- Bagian 13: Berapa Banyak Pekerjaan Yang Anda Lamar -->
<div class="section-card animate-fade-in" id="sectionCariKerja" style="display: none;">
    <div class="section-header">
        <i class="fas fa-file-alt"></i>
        Bagaimana Anda Mencari Pekerjaan
    </div>
    <div class="section-body">
        <div class="alert"
            style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)); border-left: 4px solid #f59e0b; color: #d97706;">
            <i class="fas fa-info-circle me-2"></i>
            Informasi mengenai lamaran pekerjaan yang Anda kirimkan
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <label for="aktif_cari_kerja" class="form-label fw-semibold">
                    <i class="fas fa-search-dollar text-warning"></i>
                    Bagaimana cara Anda mencari pekerjaan?
                </label>
                <select name="aktif_cari_kerja" id="aktif_cari_kerja" class="form-select">
                    <option value="" disabled {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '' ? 'selected' : '' }}>-- Pilih Jawaban --</option>
                    <option value="1" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '1' ? 'selected' : '' }}>1. Melalui iklan di koran/majalah, brosur</option>
                    <option value="2" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '2' ? 'selected' : '' }}>2. Melamar ke perusahaan tanpa mengetahui lowongan yang ada</option>
                    <option value="3" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '3' ? 'selected' : '' }}>3. Pergi ke bursa/pameran kerja</option>
                    <option value="4" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '4' ? 'selected' : '' }}>4. Mencari lewat internet / iklan online / milis</option>
                    <option value="5" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '5' ? 'selected' : '' }}>5. Dihubungi oleh perusahaan</option>
                    <option value="6" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '6' ? 'selected' : '' }}>6. Menghubungi Kemenakertrans</option>
                    <option value="7" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '7' ? 'selected' : '' }}>7. Menghubungi agen tenaga kerja komersial / swasta</option>
                    <option value="8" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '8' ? 'selected' : '' }}>8. Memeroleh informasi dari pusat / kantor pengembangan karir fakultas/universitas</option>
                    <option value="9" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '9' ? 'selected' : '' }}>9. Menghubungi kantor kemahasiswaan / hubungan alumni</option>
                    <option value="10" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '10' ? 'selected' : '' }}>10. Membangun jejaring (network) sejak masa kuliah</option>
                    <option value="11" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '11' ? 'selected' : '' }}>11. Melalui relasi (misalnya, dosen, orang tua, teman, saudara, dll.)</option>
                    <option value="12" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '12' ? 'selected' : '' }}>12. Membangun bisnis sendiri</option>
                    <option value="13" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '13' ? 'selected' : '' }}>13. Melalui penempatan kerja atau magang</option>
                    <option value="14" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '14' ? 'selected' : '' }}>14. Bekerja di tempat yang sama dengan tempat kerja semasa kuliah</option>
                    <option value="15" {{ old('aktif_cari_kerja', $tracer->pencarianKerja->aktif_cari_kerja ?? '') == '15' ? 'selected' : '' }}>15. Lainnya</option>
                </select>
                <div class="form-text">Jelaskan metode pencarian pekerjaan yang Anda gunakan</div>
            </div>

            <div class="col-md-6">
                <label for="jumlah_perusahaan_lamar" class="form-label">
                    <i class="fas fa-building text-warning"></i>
                    Jumlah perusahaan yang Anda lamar
                </label>
                <input type="number" name="jumlah_perusahaan_lamar" id="jumlah_perusahaan_lamar" class="form-control"
                    value="{{ old('jumlah_perusahaan_lamar', $tracer->pencarianKerja->jumlah_perusahaan_lamar ?? '') }}" placeholder="Diisi angka">
            </div>

            <div class="col-md-6">
                <label for="jumlah_perusahaan_respon" class="form-label">
                    <i class="fas fa-reply text-warning"></i>
                    Jumlah perusahaan yang merespon
                </label>
                <input type="number" name="jumlah_perusahaan_respon" id="jumlah_perusahaan_respon" class="form-control"
                    value="{{ old('jumlah_perusahaan_respon', $tracer->pencarianKerja->jumlah_perusahaan_respon ?? '') }}" placeholder="Diisi angka">
            </div>

            <div class="col-md-6">
                <label for="jumlah_perusahaan_wawancara" class="form-label">
                    <i class="fas fa-users text-warning"></i>
                    Jumlah perusahaan yang mengundang wawancara
                </label>
                <input type="number" name="jumlah_perusahaan_wawancara" id="jumlah_perusahaan_wawancara" class="form-control"
                    value="{{ old('jumlah_perusahaan_wawancara', $tracer->pencarianKerja->jumlah_perusahaan_wawancara ?? '') }}" placeholder="Diisi angka">
            </div>


        </div>
    </div>
</div>
