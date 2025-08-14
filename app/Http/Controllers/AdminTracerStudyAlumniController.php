<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AdminTracerStudyAlumniController extends Controller
{
    // Menampilkan halaman dengan DataTables
    public function index()
    {
        $totalAlumni = Alumni::count();

        // Total yang sudah mengisi TracerStudy (menggunakan alumni_id yang baru)
        $sudahMengisi = TracerStudy::distinct('alumni_id')->count('alumni_id');

        // Yang belum mengisi = total - sudah mengisi
        $belumMengisi = $totalAlumni - $sudahMengisi;

        if (request()->ajax()) {
            // Ambil query TracerStudy dengan relasi alumni dan users
            $tracer = TracerStudy::with(['alumni.users', 'pekerjaan', 'wirausaha', 'pendidikan']);

            // Filter status pekerjaan jika ada (menggunakan status_pekerjaan yang baru)
            if (request()->has('status') && request()->status !== '') {
                $status = strtolower(request()->status);
                $tracer->whereRaw('LOWER(status_pekerjaan) LIKE ?', ["%$status%"]);
            }

            // Ambil hasil akhir
            $tracer = $tracer->get();

            // Kembalikan data untuk DataTables
            return DataTables::of($tracer)
                ->addColumn('nama_alumni', function ($row) {
                    return $row->alumni && $row->alumni->nama_lengkap
                        ? $row->alumni->nama_lengkap
                        : ($row->nama ?? '-');
                })
                ->addColumn('status_pekerjaan_badge', function ($row) {
                    $statusMap = [
                        'bekerja_full' => '<span class="badge bg-success">Bekerja</span>',
                        'wirausaha' => '<span class="badge bg-info">Wiraswasta</span>',
                        'lanjutstudy' => '<span class="badge bg-primary">Melanjutkan Pendidikan</span>',
                        'belum_bekerja' => '<span class="badge bg-warning">Belum Memungkinkan Bekerja</span>',
                        'tidak' => '<span class="badge bg-secondary">Tidak Kerja</span>'
                    ];
                    return $statusMap[$row->status_pekerjaan] ?? '<span class="badge bg-light text-dark">' . ($row->status_pekerjaan ?? '-') . '</span>';
                })
                ->addColumn('detail_info', function ($row) {
                    if ($row->status_pekerjaan === 'bekerja_full' && $row->pekerjaan) {
                        return $row->pekerjaan->nama_perusahaan ?? '-';
                    } elseif ($row->status_pekerjaan === 'wirausaha' && $row->wirausaha) {
                        return $row->wirausaha->nama_usaha ?? '-';
                    } elseif ($row->status_pekerjaan === 'lanjutstudy' && $row->pendidikan) {
                        return $row->pendidikan->nama_universitas ?? '-';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('listtraceralumni.edit', $row->id);
                    $deleteUrl = route('listtraceralumni.destroy', $row->id);
                    return '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa fa-cog"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" class="dropdown-item btn-view" data-id="' . $row->id . '">
                                <i class="fa fa-eye text-info me-2"></i> Detail</a></li>
                            <li><a href="' . $editUrl . '" class="dropdown-item">
                                <i class="fa fa-edit text-warning me-2"></i> Edit</a></li>
                            <li><a href="#" class="dropdown-item btn-delete" data-id="' . $row->id . '">
                                <i class="fa fa-trash-alt text-danger me-2"></i> Hapus</a></li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['status_pekerjaan_badge', 'action'])
                ->make(true);
        }

        // Return ke view utama jika bukan request Ajax
        $role = auth()->user()->role ?? 'user';
        return view('admin.tracer.alumni.table-salinan-alumni', compact('totalAlumni', 'sudahMengisi', 'belumMengisi', 'role'));
    }


    // Contoh fungsi lain untuk data alumni (jika dibutuhkan)
    public function getData()
    {
        if (request()->ajax()) {
            $query = Alumni::with('users');

            if (request()->filled('tahun_angkatan')) {
                $query->where('tahun_masuk', request('tahun_angkatan'));
            }

            return DataTables::of($query->get())
                ->addColumn('nama', function ($row) {
                    return $row->users ? $row->users->name : '-';
                })
                ->make(true);
        }
    }

    /**
     * Menampilkan form edit data tracer
     */
    public function edit($id)
    {
        $data = TracerStudy::with(['alumni.users', 'pekerjaan', 'wirausaha', 'pendidikan', 'kompetensi', 'pencarianKerja', 'evaluasiPendidikan'])
            ->findOrFail($id);
        $alumniList = \App\Models\Alumni::all();
        return view('admin.tracer.alumni.edit-salinan-table', compact('data', 'alumniList'));
    }

    /**
     * Mengambil detail data tracer untuk modal (AJAX)
     */
    public function detail($id)
    {
        $data = TracerStudy::with(['alumni.users', 'pekerjaan', 'wirausaha', 'pendidikan', 'kompetensi', 'pencarianKerja', 'evaluasiPendidikan'])
            ->findOrFail($id);

        return response()->json($data);
    }

    /**
     * Menampilkan halaman detail tracer study
     */
    public function show($id)
    {
        $tracerStudy = TracerStudy::with(['alumni.users', 'pekerjaan', 'wirausaha', 'pendidikan', 'kompetensi', 'pencarianKerja', 'evaluasiPendidikan'])
            ->findOrFail($id);

        return view('admin.tracer.alumni.show', compact('tracerStudy'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $data = TracerStudy::with(['alumni.users', 'pekerjaan', 'wirausaha', 'pendidikan', 'kompetensi', 'pencarianKerja', 'evaluasiPendidikan'])
            ->findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required'],
            'email' => ['required', 'email', 'max:255'],
            'tahun_lulus' => ['required', 'integer'],
            'alamat' => ['required', 'string', 'max:255'],
            'status_pekerjaan' => ['required', 'string', 'in:bekerja_full,wirausaha,lanjutstudy,belum_bekerja,tidak'],

            // Detail pekerjaan
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'alamat_pekerjaan' => ['nullable', 'string', 'max:255'],
            'pendapatan' => ['nullable', 'string', 'max:255'],

            // Detail wirausaha
            'nama_usaha' => ['nullable', 'string', 'max:255'],
            'posisi_usaha' => ['nullable', 'string', 'max:255'],
            'tingkat_usaha' => ['nullable', 'string', 'max:255'],
            'alamat_usaha' => ['nullable', 'string', 'max:255'],
            'pendapatan_usaha' => ['nullable', 'string', 'max:255'],

            // Detail pendidikan
            'nama_universitas' => ['nullable', 'string', 'max:255'],
            'program_studi' => ['nullable', 'string', 'max:255'],
            'sumber_biaya' => ['nullable', 'string', 'max:255'],
            'tanggal_masuk' => ['nullable', 'date'],
            'lokasi_universitas' => ['nullable', 'string', 'max:255'],

            // Kompetensi
            'etika_awal' => ['nullable', 'string'],
            'keahlian_awal' => ['nullable', 'string'],
            'komunikasi_awal' => ['nullable', 'string'],
            'kerjasama_awal' => ['nullable', 'string'],
            'teknologi_awal' => ['nullable', 'string'],
            'bahasa_inggris_awal' => ['nullable', 'string'],

            'etika_sekarang' => ['nullable', 'string'],
            'keahlian_sekarang' => ['nullable', 'string'],
            'komunikasi_sekarang' => ['nullable', 'string'],
            'kerjasama_sekarang' => ['nullable', 'string'],
            'teknologi_sekarang' => ['nullable', 'string'],
            'bahasa_inggris_sekarang' => ['nullable', 'string'],

            // Evaluasi
            // 'saran' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            DB::transaction(function () use ($data, $validated) {
                // Update data utama
                $data->update([
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'no_hp' => $validated['no_hp'],
                    'tahun_lulus' => $validated['tahun_lulus'],
                    'alamat' => $validated['alamat'],
                    'status_pekerjaan' => $validated['status_pekerjaan'],
                    // 'saran' => $validated['saran'],
                ]);

                // Update detail berdasarkan status pekerjaan
                $this->updateDetailByStatus($data, $validated);

                // Update data alumni & user jika perlu
                if ($data->alumni) {
                    $data->alumni->update([
                        'nama_lengkap' => $validated['nama'],
                        'no_hp' => $validated['no_hp'],
                        'tahun_lulus' => $validated['tahun_lulus'],
                        'alamat' => $validated['alamat'],
                    ]);
                    if ($data->alumni->users) {
                        $data->alumni->users->update([
                            'email' => $validated['email'],
                        ]);
                    }
                }
            });

            return redirect()->route('listtraceralumni.index')->with('success', 'Data berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function updateDetailByStatus($tracerStudy, $data)
    {
        // Hapus detail lama yang tidak sesuai status baru
        $this->cleanupOldDetails($tracerStudy, $data['status_pekerjaan']);

        switch ($data['status_pekerjaan']) {
            case 'bekerja_full':
                $this->updatePekerjaanDetail($tracerStudy, $data);
        $this->updateKompetensiDetail($tracerStudy, $data);

                break;
            case 'wirausaha':
                $this->updateWirausahaDetail($tracerStudy, $data);
        $this->updateKompetensiDetail($tracerStudy, $data);

                break;
            case 'lanjutstudy':
                $this->updatePendidikanDetail($tracerStudy, $data);
                break;
        }

        // Update kompetensi (semua status memiliki kompetensi)
    }

    private function cleanupOldDetails($tracerStudy, $newStatus)
    {
        if ($newStatus !== 'bekerja_full') {
            $tracerStudy->pekerjaan()->delete();
        }
        if ($newStatus !== 'wirausaha') {
            $tracerStudy->wirausaha()->delete();
        }
        if ($newStatus !== 'lanjutstudy') {
            $tracerStudy->pendidikan()->delete();
        }
    }

    private function updatePekerjaanDetail($tracerStudy, $data)
    {
        $tracerStudy->pekerjaan()->updateOrCreate(
            ['tracer_study_id' => $tracerStudy->id],
            [
                'nama_perusahaan' => $data['nama_perusahaan'],
                'jabatan' => $data['jabatan'],
                'alamat_pekerjaan' => $data['alamat_pekerjaan'],
                'pendapatan' => $data['pendapatan'],
            ]
        );
    }

    private function updateWirausahaDetail($tracerStudy, $data)
    {
        $tracerStudy->wirausaha()->updateOrCreate(
            ['tracer_study_id' => $tracerStudy->id],
            [
                'nama_usaha' => $data['nama_usaha'],
                'posisi_usaha' => $data['posisi_usaha'],
                'tingkat_usaha' => $data['tingkat_usaha'],
                'alamat_usaha' => $data['alamat_usaha'],
                'pendapatan_usaha' => $data['pendapatan_usaha'],
            ]
        );
    }

    private function updatePendidikanDetail($tracerStudy, $data)
    {
        $tracerStudy->pendidikan()->updateOrCreate(
            ['tracer_study_id' => $tracerStudy->id],
            [
                'universitas' => $data['nama_universitas'],
                'program_studi' => $data['program_studi'],
                'sumber_biaya' => $data['sumber_biaya'],
                'tanggal_masuk' => $data['tanggal_masuk'],
                'lokasi_universitas' => $data['lokasi_universitas'],
            ]
        );
    }

    private function updateKompetensiDetail($tracerStudy, $data)
    {
        $tracerStudy->kompetensi()->updateOrCreate(
            ['tracer_study_id' => $tracerStudy->id],
            [
                'etika_awal' => $data['etika_awal'],
                'keahlian_awal' => $data['keahlian_awal'],
                'komunikasi_awal' => $data['komunikasi_awal'],
                'kerjasama_awal' => $data['kerjasama_awal'],
                'teknologi_awal' => $data['teknologi_awal'],
                'bahasa_inggris_awal' => $data['bahasa_inggris_awal'],

                'etika_sekarang' => $data['etika_sekarang'],
                'keahlian_sekarang' => $data['keahlian_sekarang'],
                'komunikasi_sekarang' => $data['komunikasi_sekarang'],
                'kerjasama_sekarang' => $data['kerjasama_sekarang'],
                'teknologi_sekarang' => $data['teknologi_sekarang'],
                'bahasa_inggris_sekarang' => $data['bahasa_inggris_sekarang'],
            ]
        );
    }

    // Hapus
    public function destroy($id)
    {
        $tracer = TracerStudy::findOrFail($id);
        $tracer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
