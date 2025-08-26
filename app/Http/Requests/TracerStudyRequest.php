<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TracerStudyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Info Pribadi
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'nim' => ['required', 'string', 'max:20'],
            'tahun_lulus' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 5)],
            'prodi' => ['nullable', 'string', 'max:100'],
            'alamat' => ['required', 'string'],

            // Status Pekerjaan
            'bekerja' => ['required', 'string', Rule::in([
                'bekerja_full', 'belum_bekerja', 'wirausaha', 'lanjutstudy', 'tidak'
            ])],

            // Detail Pekerjaan (conditional)
            'mendapatkan_pekerjaan' => ['nullable', 'string', Rule::in(['<=6bulan', '>6bulan'])],
            'bulan_kerja_kurang6' => ['nullable', 'integer', 'min:0', 'max:6'],
            'bulan_kerja_lebih6' => ['nullable', 'numeric', 'min:7'],
            'pendapatan_kurang6' => ['nullable', 'numeric', 'min:0'],
            'pendapatan_lebih6' => ['nullable', 'numeric', 'min:0'],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'nipy' => ['nullable', 'max:20'],
            'alamat_pekerjaan' => ['nullable', 'string'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kota' => ['nullable', 'string', 'max:100'],
            'tingkat_usaha_level' => ['nullable', 'string'],
            'wa_atasan' => ['nullable', 'string', 'max:20', 'regex:/^\+62[0-9]{9,12}$/'],
            'email_atasan' => ['nullable', 'email', 'max:255'],

            // kesesuaian pekerjaan
            'hubungan_studi_pekerjaan' => ['nullable', 'string', Rule::in([
                'sangat_erat', 'erat', 'cukup_erat', 'kurang_erat', 'tidak_erat'
            ])],
            'pendidikan_sesuai_pekerjaan' => ['nullable', 'string', Rule::in([
                'lebih_tinggi', 'sama', 'lebih_rendah', 'tidak_perlu_pt'
            ])],

            // Detail Wirausaha (conditional)
            'nama_usaha' => ['nullable', 'string', 'max:255'],
            'posisi_usaha' => ['nullable', 'string', Rule::in(['founder', 'co-founder', 'staff', 'freelance'])],
            'alamat_usaha' => ['nullable', 'string'],
            'pendapatan_usaha' => ['nullable', 'numeric', 'min:0'],

            // Detail Pendidikan (conditional)
            'universitas' => ['nullable', 'string', 'max:255'],
            'program_studi' => ['nullable', 'string', 'max:255'],
            'sumber_biaya' => ['nullable', 'string', Rule::in(['biaya_sendiri', 'beasiswa_pemerintah', 'beasiswa_swasta', 'beasiswa_institusi'])],
            'tanggal_masuk' => ['nullable', 'date'],
            'lokasi_universitas' => ['nullable', 'string'],
            'sumber_biaya_politeknik' => ['nullable', 'string', Rule::in([
                'biaya_sendiri_orangtua', 'beasiswa_adik', 'beasiswa_bidikmisi',
                'beasiswa_ppa', 'beasiswa_afirmasi', 'beasiswa_swasta', 'lainnya'
            ])],
            'sumber_biaya_lainnya' => ['nullable', 'string', 'max:255'],

            // Kompetensi (untuk semua)
            'etika_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'keahlian_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'bahasa_inggris_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'komunikasi_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'kerjasama_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'teknologi_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'pengembangan_awal' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'etika_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'keahlian_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'bahasa_inggris_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'komunikasi_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'kerjasama_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'teknologi_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'pengembangan_sekarang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],

            // Pencarian Kerja (conditional)
            'waktu_cari_kerja' => ['nullable', 'string', Rule::in(['sebelum_lulus', 'setelah_lulus', 'tidak_mencari'])],
            'bulan_sebelum_lulus' => ['nullable', 'integer', 'min:0'],
            'bulan_setelah_lulus' => ['nullable', 'integer', 'min:0'],
            'aktif_cari_kerja' => ['nullable', 'string'],
            'jumlah_perusahaan_lamar' => ['nullable', 'integer', 'min:0'],
            'jumlah_perusahaan_respon' => ['nullable', 'integer', 'min:0'],
            'jumlah_perusahaan_wawancara' => ['nullable', 'integer', 'min:0'],
            'aktif_cari_kerja_4minggu' => ['nullable', 'string'],
            'alasan_pekerjaan_tidak_sesuai' => ['nullable', 'integer', 'min:1', 'max:13'],

            // Evaluasi Pendidikan (untuk semua)
            'perkuliahan' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'praktikum' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'demonstrasi' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'riset' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'magang' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'kerja_lapangan' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],
            'diskusi' => ['nullable', 'string', Rule::in(['sangat_baik', 'baik', 'cukup', 'kurang_baik', 'tidak_baik'])],

            // Saran dan Masukan (untuk semua)
            'saran' => ['nullable', 'string', 'max:2000'],

            // Field lama yang masih digunakan
            'cara_mencari_kerja' => ['nullable', 'array'],
            'cara_mencari_kerja.*' => ['string'],
            'sumber_informasi' => ['nullable', 'string', 'max:255'],
            'faktor_utama_diterima' => ['nullable', 'string', 'max:255'],
            'hambatan_mencari_kerja' => ['nullable', 'string'],

            // Data Atasan (wajib jika status bekerja_full)
            'nama_atasan' => ['nullable', 'string', 'max:255'],
            'jabatan_atasan' => ['nullable', 'string', 'max:255'],
            'wa_atasan' => ['nullable', 'string', 'max:20', 'regex:/^\+62[0-9]{9,12}$/'],
            'email_atasan' => ['nullable', 'email', 'max:255'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'tahun_lulus.required' => 'Tahun lulus wajib diisi.',
            'tahun_lulus.min' => 'Tahun lulus minimal 2000.',
            'alamat.required' => 'Alamat wajib diisi.',
            'bekerja.required' => 'Status pekerjaan wajib dipilih.',
            'bekerja.in' => 'Status pekerjaan tidak valid.',
            'bulan_kerja_kurang6.max' => 'Untuk pilihan kurang dari 6 bulan, maksimal 6 bulan.',
            'bulan_kerja_lebih6.min' => 'Untuk pilihan lebih dari 6 bulan, minimal 7 bulan.',
            'pendapatan_kurang6.numeric' => 'Pendapatan harus berupa angka.',
            'pendapatan_lebih6.numeric' => 'Pendapatan harus berupa angka.',
            'pendapatan_usaha.numeric' => 'Pendapatan usaha harus berupa angka.',
            'tanggal_masuk.date' => 'Format tanggal tidak valid.',
            'wa_atasan.regex' => 'Format nomor WhatsApp harus dimulai dengan +62 dan diikuti 9-12 digit angka.',
            'email_atasan.email' => 'Format email tidak valid.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validasi conditional berdasarkan status pekerjaan
            $status = $this->input('bekerja');

            // Log untuk debugging
            \Log::info('TracerStudyRequest validation:', [
                'status' => $status,
                'all_data' => $this->all()
            ]);

            // Jika bekerja, beberapa field wajib diisi
            if ($status === 'bekerja_full') {
                if (empty($this->input('nama_perusahaan'))) {
                    $validator->errors()->add('nama_perusahaan', 'Nama perusahaan wajib diisi untuk yang bekerja.');
                }
                if (empty($this->input('jabatan'))) {
                    $validator->errors()->add('jabatan', 'Jabatan wajib diisi untuk yang bekerja.');
                }

                // Validasi field atasan wajib untuk yang bekerja
                if (empty($this->input('nama_atasan'))) {
                    $validator->errors()->add('nama_atasan', 'Nama atasan wajib diisi untuk yang bekerja.');
                }
                if (empty($this->input('jabatan_atasan'))) {
                    $validator->errors()->add('jabatan_atasan', 'Jabatan atasan wajib diisi untuk yang bekerja.');
                }

                // Validasi field mendapatkan_pekerjaan dan bulan kerja
                $mendapatkanPekerjaan = $this->input('mendapatkan_pekerjaan');
                if ($mendapatkanPekerjaan === '<=6bulan') {
                    if (empty($this->input('bulan_kerja_kurang6'))) {
                        $validator->errors()->add('bulan_kerja_kurang6', 'Bulan kerja wajib diisi untuk pilihan kurang dari 6 bulan.');
                    }
                    if (empty($this->input('pendapatan_kurang6'))) {
                        $validator->errors()->add('pendapatan_kurang6', 'Pendapatan wajib diisi untuk pilihan kurang dari 6 bulan.');
                    }
                } elseif ($mendapatkanPekerjaan === '>6bulan') {
                    if (empty($this->input('bulan_kerja_lebih6'))) {
                        $validator->errors()->add('bulan_kerja_lebih6', 'Bulan kerja wajib diisi untuk pilihan lebih dari 6 bulan.');
                    }
                    if (empty($this->input('pendapatan_lebih6'))) {
                        $validator->errors()->add('pendapatan_lebih6', 'Pendapatan wajib diisi untuk pilihan lebih dari 6 bulan.');
                    }
                }

                // Validasi data atasan: minimal salah satu kontak harus diisi
                $waAtasan = $this->input('wa_atasan');
                $emailAtasan = $this->input('email_atasan');

                if (empty($waAtasan) && empty($emailAtasan)) {
                    $validator->errors()->add('wa_atasan', 'Minimal salah satu kontak atasan (WhatsApp atau Email) harus diisi untuk pengiriman kuesioner evaluasi.');
                    $validator->errors()->add('email_atasan', 'Minimal salah satu kontak atasan (WhatsApp atau Email) harus diisi untuk pengiriman kuesioner evaluasi.');
                }
            }

            // Jika wirausaha, beberapa field wajib diisi
            if ($status === 'wirausaha') {
                if (empty($this->input('nama_usaha'))) {
                    $validator->errors()->add('nama_usaha', 'Nama usaha wajib diisi untuk wiraswasta.');
                }
                if (empty($this->input('posisi_usaha'))) {
                    $validator->errors()->add('posisi_usaha', 'Posisi usaha wajib diisi untuk wiraswasta.');
                }
            }

            // Jika lanjut studi, beberapa field wajib diisi
            if ($status === 'lanjutstudy') {
                if (empty($this->input('universitas'))) {
                    $validator->errors()->add('universitas', 'Nama universitas wajib diisi untuk yang melanjutkan pendidikan.');
                }
                if (empty($this->input('program_studi'))) {
                    $validator->errors()->add('program_studi', 'Program studi wajib diisi untuk yang melanjutkan pendidikan.');
                }
            }

            // Log validation errors jika ada
            if ($validator->errors()->count() > 0) {
                \Log::warning('TracerStudyRequest validation failed:', [
                    'status' => $status,
                    'errors' => $validator->errors()->toArray()
                ]);
            }
        });
    }
}
