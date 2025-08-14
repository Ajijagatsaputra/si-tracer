<!-- Bagian 14: Aktivitas Saat Ini -->
<div class="section-card animate-fade-in" id="aktivitasSaatIni" style="display: none;">
    <div class="section-header">
        <i class="fas fa-tasks"></i>
        Aktivitas Saat Ini
    </div>
    <div class="section-body">
        <div class="alert"
            style="background: linear-gradient(135deg, rgba(139, 69, 19, 0.1), rgba(139, 69, 19, 0.05)); border-left: 4px solid #8b4513; color: #a0522d;">
            <i class="fas fa-info-circle me-2"></i>
            Informasi mengenai aktivitas Anda dalam 4 minggu terakhir
        </div>
        <div class="row g-4">
            <div class="col-12">
                <label for="aktif_cari_kerja_4minggu" class="form-label">
                    <i class="fas fa-search text-primary"></i>
                    Apakah Anda aktif mencari pekerjaan dalam 4 minggu terakhir?
                </label>
                <select name="aktif_cari_kerja_4minggu" id="aktif_cari_kerja_4minggu" class="form-select">
                    <option value="" disabled {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == '' ? 'selected' : '' }}>-- Pilih Jawaban --</option>
                    <option value="tidak" {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    <option value="tidak_ada_lowongan" {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == 'tidak_ada_lowongan' ? 'selected' : '' }}>Tidak, karena tidak ada lowongan kerja</option>
                    <option value="tidak_ada_lowongan_sesuai" {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == 'tidak_ada_lowongan_sesuai' ? 'selected' : '' }}>Tidak, karena tidak ada lowongan kerja yang sesuai</option>
                    <option value="tidak_memenuhi_kualifikasi" {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == 'tidak_memenuhi_kualifikasi' ? 'selected' : '' }}>Tidak, karena tidak memenuhi kualifikasi</option>
                    <option value="sudah_dapat_pekerjaan" {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == 'sudah_dapat_pekerjaan' ? 'selected' : '' }}>Tidak, karena sudah dapat pekerjaan namun belum mulai bekerja</option>
                    <option value="sedang_mencari" {{ old('aktif_cari_kerja_4minggu', $tracer->pencarianKerja->aktif_cari_kerja_4minggu ?? '') == 'sedang_mencari' ? 'selected' : '' }}>Ya, sedang aktif mencari</option>
                </select>
            </div>

            <div class="col-md-12">
                <label for="alasan_pekerjaan_tidak_sesuai" class="form-label">
                    <i class="fas fa-question-circle text-primary"></i>
                    Jika pekerjaan saat ini tidak sesuai dengan pendidikan, jelaskan alasannya
                </label>
                <select name="alasan_pekerjaan_tidak_sesuai" id="alasan_pekerjaan_tidak_sesuai" class="form-select" required>
                    <option value="" disabled {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '' ? 'selected' : '' }}>-- Pilih Jawaban --</option>
                    <option value="1" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '1' ? 'selected' : '' }}>1. Pekerjaan saya sekarang sudah sesuai dengan pendidikan saya</option>
                    <option value="2" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '2' ? 'selected' : '' }}>2. Saya belum mendapatkan pekerjaan yg lebih sesuai</option>
                    <option value="3" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '3' ? 'selected' : '' }}>3. Di pekerjaan ini saya memeroleh prospek karir yang baik</option>
                    <option value="4" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '4' ? 'selected' : '' }}>4. Saya lebih suka bekerja di area pekerjaan yang tidak ada hubungannya dengan pendidikan saya</option>
                    <option value="5" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '5' ? 'selected' : '' }}>5. Saya dipromosikan ke posisi yg kurang berhubungan dengan pendidikan saya dibanding posisi sebelumnya</option>
                    <option value="6" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '6' ? 'selected' : '' }}>6. Saya dapat memeroleh pendapatan yang lebih tinggi di pekerjaan ini</option>
                    <option value="7" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '7' ? 'selected' : '' }}>7. Pekerjaan saya saat ini lebih aman/terjamin/secure</option>
                    <option value="8" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '8' ? 'selected' : '' }}>8. Pekerjaan saya saat ini lebih menarik</option>
                    <option value="9" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '9' ? 'selected' : '' }}>9. Pekerjaan saya saat ini lebih memungkinkan saya mengambil pekerjaan tambahan/jadwal yang fleksibel, dll</option>
                    <option value="10" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '10' ? 'selected' : '' }}>10. Pekerjaan saya saat ini lokasinya lebih dekat dari rumah saya</option>
                    <option value="11" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '11' ? 'selected' : '' }}>11. Pekerjaan saya saat ini dapat lebih menjamin kebutuhan keluarga saya</option>
                    <option value="12" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '12' ? 'selected' : '' }}>12. Pada awal meniti karir ini, saya harus menerima pekerjaan yang tidak berhubungan dengan pendidikan saya</option>
                    <option value="13" {{ old('alasan_pekerjaan_tidak_sesuai', $tracer->pencarianKerja->alasan_pekerjaan_tidak_sesuai ?? '') == '13' ? 'selected' : '' }}>13. Lainnya...</option>
                </select>
            </div>
        </div>
    </div>
</div>
