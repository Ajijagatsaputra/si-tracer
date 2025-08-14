// Progress tracking dengan animasi yang lebih smooth
function updateProgress() {
    const form = document.getElementById("alumniForm");
    if (!form) return; // Safety check

    const requiredInputs = form.querySelectorAll(
        "input[required], select[required], textarea[required]"
    );
    const visibleRequiredInputs = Array.from(requiredInputs).filter((input) => {
        const section = input.closest(".section-card");
        return !section || section.style.display !== "none";
    });

    let filledInputs = 0;

    visibleRequiredInputs.forEach((input) => {
        if (input.type === "radio") {
            const radioGroup = form.querySelector(
                `input[name="${input.name}"]:checked`
            );
            if (radioGroup && visibleRequiredInputs.includes(input)) {
                filledInputs++;
            }
        } else if (input.value.trim() !== "") {
            filledInputs++;
        }
    });

    const progress =
        visibleRequiredInputs.length > 0
            ? (filledInputs / visibleRequiredInputs.length) * 100
            : 0;

    // Animasi progress bar
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");

    if (progressBar) progressBar.style.width = progress + "%";
    if (progressText) progressText.textContent = Math.round(progress) + "%";

    // Ubah warna progress berdasarkan persentase
    if (progressBar) {
        if (progress < 33) {
            progressBar.style.background =
                "linear-gradient(90deg, #ef4444, #f97316)";
        } else if (progress < 66) {
            progressBar.style.background =
                "linear-gradient(90deg, #f59e0b, #eab308)";
        } else {
            progressBar.style.background =
                "linear-gradient(90deg, #06b6d4, #10b981)";
        }
    }
}

// Show/hide sections berdasarkan status pekerjaan
document.addEventListener('DOMContentLoaded', function() {
    const bekerjaRadios = document.querySelectorAll('input[name="bekerja"]');
    if (bekerjaRadios.length > 0) {
        bekerjaRadios.forEach((radio) => {
            radio.addEventListener("change", function () {
                const detailPekerjaan = document.getElementById("detailPekerjaan");
                const detailWirausaha = document.getElementById("detailWirausaha");
                const detailLanjutStudy = document.getElementById("detailLanjutStudy");
                const sectionCariKerja = document.getElementById("sectionCariKerja");
                const kompetensiA = document.getElementById("kompetensiA");
                const kompetensiB = document.getElementById("kompetensiB");
                const bagian2 = document.getElementById(
                    "waktuAlumniMendapatkanPekerjaan"
                );
                const wiraswasta = document.getElementById("wiraswasta");
                const lokasiPekerjaan = document.getElementById("lokasikerja");
                const kesesuaianKerja = document.getElementById("kesesuaianPekerjaan");
                const aktivitasSaatini = document.getElementById("aktivitasSaatIni");
                const evaluasi = document.getElementById("evaluasiPendidikan");
                const caramendapatkankerjaan = document.getElementById(
                    "caraMendapatkanPekerjaan"
                );

                // Sembunyikan semua detail section + cari kerja + kompetensi
                [
                    detailPekerjaan,
                    detailWirausaha,
                    detailLanjutStudy,
                    sectionCariKerja,
                    kompetensiA,
                    kompetensiB,
                    bagian2,
                    wiraswasta,
                    lokasiPekerjaan,
                    kesesuaianKerja,
                    aktivitasSaatini,
                ].forEach((section) => {
                    if (section) section.style.display = "none";
                });

                // Hapus required dan kosongkan nilai
                [
                    detailPekerjaan,
                    detailWirausaha,
                    detailLanjutStudy,
                    sectionCariKerja,
                ].forEach((section) => {
                    if (section) {
                        section.querySelectorAll("input, select").forEach((el) => {
                            el.removeAttribute("required");
                            el.value = "";
                        });
                    }
                });

                // Tampilkan section sesuai pilihan
                if (this.value === "bekerja") {
                    if (detailPekerjaan) detailPekerjaan.style.display = "block";
                    if (kompetensiA) kompetensiA.style.display = "block";
                    if (kompetensiB) kompetensiB.style.display = "block";
                    if (bagian2) bagian2.style.display = "block";
                    if (wiraswasta) wiraswasta.style.display = "block";
                    if (lokasiPekerjaan) lokasiPekerjaan.style.display = "block";
                    if (kesesuaianKerja) kesesuaianKerja.style.display = "block";
                    if (aktivitasSaatini) aktivitasSaatini.style.display = "block";
                    if (evaluasi) evaluasi.style.display = "block";
                    if (caramendapatkankerjaan) caramendapatkankerjaan.style.display = "block";
                } else if (this.value === "wirausaha") {
                    if (detailWirausaha) detailWirausaha.style.display = "block";
                    if (kompetensiA) kompetensiA.style.display = "block";
                    if (kompetensiB) kompetensiB.style.display = "block";
                    if (bagian2) bagian2.style.display = "block";
                    if (wiraswasta) wiraswasta.style.display = "block";
                    if (lokasiPekerjaan) lokasiPekerjaan.style.display = "block";
                    if (kesesuaianKerja) kesesuaianKerja.style.display = "block";
                    if (aktivitasSaatini) aktivitasSaatini.style.display = "block";
                    if (evaluasi) evaluasi.style.display = "block";
                    if (caramendapatkankerjaan) caramendapatkankerjaan.style.display = "block";
                } else if (this.value === "lanjut_study") {
                    if (detailLanjutStudy) detailLanjutStudy.style.display = "block";
                    if (kompetensiA) kompetensiA.style.display = "block";
                    if (kompetensiB) kompetensiB.style.display = "block";
                    if (bagian2) bagian2.style.display = "block";
                    if (wiraswasta) wiraswasta.style.display = "block";
                    if (lokasiPekerjaan) lokasiPekerjaan.style.display = "block";
                    if (kesesuaianKerja) kesesuaianKerja.style.display = "block";
                    if (aktivitasSaatini) aktivitasSaatini.style.display = "block";
                    if (evaluasi) evaluasi.style.display = "block";
                    if (caramendapatkankerjaan) caramendapatkankerjaan.style.display = "block";
                } else if (this.value === "cari_kerja") {
                    if (sectionCariKerja) sectionCariKerja.style.display = "block";
                    if (kompetensiA) kompetensiA.style.display = "block";
                    if (kompetensiB) kompetensiB.style.display = "block";
                    if (bagian2) bagian2.style.display = "block";
                    if (wiraswasta) wiraswasta.style.display = "block";
                    if (lokasiPekerjaan) lokasiPekerjaan.style.display = "block";
                    if (kesesuaianKerja) kesesuaianKerja.style.display = "block";
                    if (aktivitasSaatini) aktivitasSaatini.style.display = "block";
                    if (evaluasi) evaluasi.style.display = "block";
                    if (caramendapatkankerjaan) caramendapatkankerjaan.style.display = "block";
                }

                updateProgress();
            });
        });
    }

    // Logika lanjutan bulan sebelum/sesudah lulus
    const waktuCariKerja = document.getElementById("waktuCariKerja");
    if (waktuCariKerja) {
        waktuCariKerja.addEventListener("change", function () {
            const sebelumGroup = document.getElementById("sebelumLulusGroup");
            const setelahGroup = document.getElementById("setelahLulusGroup");

            if (!sebelumGroup || !setelahGroup) return; // Safety check

            // Reset tampilan
            sebelumGroup.style.display = "none";
            setelahGroup.style.display = "none";

            // Reset nilai dan required
            const sebelumInput = sebelumGroup.querySelector("input");
            const setelahInput = setelahGroup.querySelector("input");

            if (sebelumInput) {
                sebelumInput.value = "";
                sebelumInput.removeAttribute("required");
            }
            if (setelahInput) {
                setelahInput.value = "";
                setelahInput.removeAttribute("required");
            }

            if (this.value === "sebelum_lulus") {
                sebelumGroup.style.display = "block";
                if (sebelumInput) {
                    sebelumInput.setAttribute("required", "required");
                }
            } else if (this.value === "setelah_lulus") {
                setelahGroup.style.display = "block";
                if (setelahInput) {
                    setelahInput.setAttribute("required", "required");
                }
            }

            updateProgress(); // Optional jika pakai progress
        });
    }

    // Update progress saat input berubah
    document.addEventListener("input", updateProgress);
    document.addEventListener("change", updateProgress);

    // Floating back to top button
    window.addEventListener("scroll", function () {
        const backToTop = document.getElementById("backToTop");
        if (backToTop) {
            if (window.pageYOffset > 300) {
                backToTop.style.display = "block";
            } else {
                backToTop.style.display = "none";
            }
        }
    });

    // Form submission dengan loading state
    const alumniForm = document.getElementById("alumniForm");
    if (alumniForm) {
        alumniForm.addEventListener("submit", function (e) {
            const submitBtn = document.querySelector(".btn-submit");
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;

                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                submitBtn.disabled = true;

                // Jika ada error, kembalikan button ke state semula
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 10000);
            }
        });
    }

    // Animasi fade in untuk section cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = "1";
                entry.target.style.transform = "translateY(0)";
            }
        });
    }, observerOptions);

    // Observe semua section cards
    document.querySelectorAll(".section-card").forEach((card) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(30px)";
        card.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        observer.observe(card);
    });

    // Initialize progress
    updateProgress();
});

// Konfirmasi sebelum meninggalkan halaman jika form sudah diisi
document.addEventListener('DOMContentLoaded', function() {
    let formChanged = false;
    document.addEventListener("input", () => (formChanged = true));
    document.addEventListener("change", () => (formChanged = true));

    window.addEventListener("beforeunload", function (e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = "";
        }
    });

    // Remove konfirmasi saat form di-submit
    const alumniForm = document.getElementById("alumniForm");
    if (alumniForm) {
        alumniForm.addEventListener("submit", function () {
            formChanged = false;
        });
    }

    // Auto-save ke localStorage setiap 30 detik (opsional)
    setInterval(function () {
        if (formChanged) {
            const formData = new FormData(document.getElementById("alumniForm"));
            if (formData) {
                const data = {};
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }
                // Note: localStorage tidak tersedia di Claude artifacts
                // localStorage.setItem('tracer_study_draft', JSON.stringify(data));
            }
        }
    }, 30000);

    // Section: Input Tambahan 'Lainnya'
    // ================================= //
    const sumberBiayaSelect = document.getElementById("sumberBiayaSelect");
    const sumberBiayaLainnya = document.getElementById("sumberBiayaLainnya");

    if (sumberBiayaSelect && sumberBiayaLainnya) {
        sumberBiayaSelect.addEventListener("change", function () {
            if (this.value === "lainnya") {
                sumberBiayaLainnya.style.display = "block";
                const input = sumberBiayaLainnya.querySelector("input");
                if (input) {
                    input.setAttribute("required", "required");
                }
            } else {
                sumberBiayaLainnya.style.display = "none";
                const input = sumberBiayaLainnya.querySelector("input");
                if (input) {
                    input.removeAttribute("required");
                    input.value = "";
                }
            }
        });
    }

    // logic untuk mengambil data kota berdasarkan provinsi'
    // ================================= //
    const provinsiSelect = document.getElementById("provinsi");
    if (provinsiSelect) {
        provinsiSelect.addEventListener("change", function () {
            const provinceCode = this.value;
            const kotaSelect = document.getElementById("kota");
            if (kotaSelect) {
                kotaSelect.innerHTML =
                    '<option value="" disabled selected>Memuat data...</option>';

                fetch(`/api/kota/${provinceCode}`)
                    .then((response) => response.json())
                    .then((data) => {
                        kotaSelect.innerHTML =
                            '<option value="" disabled selected>-- Pilih Kabupaten/Kota --</option>';
                        for (const [code, name] of Object.entries(data)) {
                            const option = document.createElement("option");
                            option.value = code;
                            option.textContent = name;
                            kotaSelect.appendChild(option);
                        }
                    })
                    .catch((error) => {
                        kotaSelect.innerHTML =
                            '<option value="">Gagal memuat data</option>';
                        console.error("Gagal fetch kota:", error);
                    });
            }
        });
    }
});

// Add scrollToTop function back
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
}
