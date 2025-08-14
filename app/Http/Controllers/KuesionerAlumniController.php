<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KuesionerAlumniController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $alumni = Alumni::where('id_users', auth()->user()->id)->first();
        $tracer = null;

    return view('alumni.tracer.study.kuesioner', compact('alumni', 'tracer'));
    }

     public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'no_hp' => ['required'],
                'nim' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'tahun_lulus' => ['required', 'integer'],
                'alamat' => ['required', 'string', 'max:255'],
                'bekerja' => ['required', 'string', 'in:ya,wirausaha,tidak'],
                // detail pekerjaan
                'nama_perusahaan' => ['nullable', 'string', 'max:255'],
                'jabatan' => ['nullable', 'string', 'max:255'],
                'alamat_pekerjaan' => ['nullable', 'string', 'max:255'],
                'gaji' => ['nullable', 'string', 'max:255'],
                'provinsi' => ['nullable', 'string', 'max:255'],
                'kota' => ['nullable', 'string', 'max:255'],
                'tingkat_usaha_level' => ['nullable', 'string', 'max:255'],
                // informasi atasan
                'nama_atasan' => ['nullable', 'string', 'max:255'],
                'jabatan_atasan' => ['nullable', 'string', 'max:255'],
                'wa_atasan' => ['nullable', 'string', 'max:255'],
                'email_atasan' => ['nullable', 'email', 'max:255'],
                // detail wirausaha
                'nama_usaha' => ['nullable', 'string', 'max:255'],
                'posisi_usaha' => ['nullable', 'string', 'max:255'],
                'tingkat_usaha' => ['nullable', 'string', 'max:255'],
                'alamat_usaha' => ['nullable', 'string', 'max:255'],
                'pendapatan_usaha' => ['nullable', 'string', 'max:255'],
                // kompetensi
                'etika' => ['required', 'string'],
                'keahlian' => ['required', 'string'],
                'penggunaanteknologi' => ['required', 'string'],
                'teamwork' => ['required', 'string'],
                'komunikasi' => ['required', 'string'],
                'pengembangan' => ['required', 'string'],
                // evaluasi
                'relevansi_kurikulum' => ['required', 'string'],
                'saran' => ['nullable', 'string', 'max:500'],
            ]);

            DB::beginTransaction();

            $user = auth()->user();
            $alumni = Alumni::firstOrCreate(
                ['id_users' => $user->id],
                [
                    'nama_lengkap' => $validated['nama'],
                    'no_hp' => $validated['no_hp'],
                    'tahun_lulus' => $validated['tahun_lulus'],
                    'alamat' => $validated['alamat'],
                ]
            );
            $alumni->update([
                'nama_lengkap' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
                'tahun_lulus' => $validated['tahun_lulus'],
                'alamat' => $validated['alamat'],
            ]);
            $user->update(['email' => $validated['email']]);

            // Default null untuk data pekerjaan/wirausaha
            $dataPekerjaan = [
                'nama_perusahaan' => null,
                'jabatan' => null,
                'alamat_pekerjaan' => null,
                'gaji' => null,
                'provinsi' => null,
                'kota' => null,
                'tingkat_usaha_level' => null,
                'nama_atasan' => null,
                'jabatan_atasan' => null,
                'wa_atasan' => null,
                'email_atasan' => null,
                'nama_usaha' => null,
                'posisi_usaha' => null,
                'tingkat_usaha' => null,
                'alamat_usaha' => null,
                'pendapatan_usaha' => null,
            ];

            if ($validated['bekerja'] == 'ya') {
                $dataPekerjaan['nama_perusahaan'] = $validated['nama_perusahaan'];
                $dataPekerjaan['jabatan'] = $validated['jabatan'];
                $dataPekerjaan['alamat_pekerjaan'] = $validated['alamat_pekerjaan'];
                $dataPekerjaan['gaji'] = $validated['gaji'];
                $dataPekerjaan['provinsi'] = $validated['provinsi'];
                $dataPekerjaan['kota'] = $validated['kota'];
                $dataPekerjaan['tingkat_usaha_level'] = $validated['tingkat_usaha_level'];
                $dataPekerjaan['nama_atasan'] = $validated['nama_atasan'];
                $dataPekerjaan['jabatan_atasan'] = $validated['jabatan_atasan'];
                $dataPekerjaan['wa_atasan'] = $validated['wa_atasan'];
                $dataPekerjaan['email_atasan'] = $validated['email_atasan'];
            } elseif ($validated['bekerja'] == 'wirausaha') {
                $dataPekerjaan['nama_usaha'] = $validated['nama_usaha'];
                $dataPekerjaan['posisi_usaha'] = $validated['posisi_usaha'];
                $dataPekerjaan['tingkat_usaha'] = $validated['tingkat_usaha'];
                $dataPekerjaan['alamat_usaha'] = $validated['alamat_usaha'];
                $dataPekerjaan['pendapatan_usaha'] = $validated['pendapatan_usaha'];
            }

            TracerStudy::updateOrCreate(
                ['id_alumni' => $alumni->id],
                [
                    'tanggal_isi' => now(),
                    'bekerja' => $validated['bekerja'],
                    'nama_perusahaan' => $dataPekerjaan['nama_perusahaan'],
                    'jabatan' => $dataPekerjaan['jabatan'],
                    'alamat_pekerjaan' => $dataPekerjaan['alamat_pekerjaan'],
                    'gaji' => $dataPekerjaan['gaji'],
                    'provinsi' => $dataPekerjaan['provinsi'],
                    'kota' => $dataPekerjaan['kota'],
                    'tingkat_usaha_level' => $dataPekerjaan['tingkat_usaha_level'],
                    'nama_atasan' => $dataPekerjaan['nama_atasan'],
                    'jabatan_atasan' => $dataPekerjaan['jabatan_atasan'],
                    'wa_atasan' => $dataPekerjaan['wa_atasan'],
                    'email_atasan' => $dataPekerjaan['email_atasan'],
                    'nama_usaha' => $dataPekerjaan['nama_usaha'],
                    'posisi_usaha' => $dataPekerjaan['posisi_usaha'],
                    'tingkat_usaha' => $dataPekerjaan['tingkat_usaha'],
                    'alamat_usaha' => $dataPekerjaan['alamat_usaha'],
                    'pendapatan_usaha' => $dataPekerjaan['pendapatan_usaha'],
                    'status_kerja' => $validated['bekerja'],
                    'etika' => $validated['etika'],
                    'keahlian' => $validated['keahlian'],
                    'penggunaanteknologi' => $validated['penggunaanteknologi'],
                    'teamwork' => $validated['teamwork'],
                    'komunikasi' => $validated['komunikasi'],
                    'pengembangan' => $validated['pengembangan'],
                    'relevansi_pekerjaan' => $validated['relevansi_kurikulum'],
                    'saran' => $validated['saran'],
                ]
            );

            // Buat kuesioner atasan jika alumni bekerja dan ada informasi atasan
            if ($validated['bekerja'] == 'ya' &&
                $validated['nama_atasan'] &&
                $validated['jabatan_atasan']) {

                $tracerStudy = TracerStudy::where('id_alumni', $alumni->id)->first();

                if ($tracerStudy) {
                    \App\Models\SupervisorQuestionnaire::create([
                        'tracer_study_id' => $tracerStudy->id,
                        'nama_atasan' => $validated['nama_atasan'],
                        'jabatan_atasan' => $validated['jabatan_atasan'],
                        'nama_perusahaan' => $validated['nama_perusahaan'],
                        'nama_alumni' => $validated['nama'],
                        'jabatan_alumni' => $validated['jabatan'],
                        'tanggal_mulai_kerja' => now(), // Bisa diubah sesuai kebutuhan
                        'status_pengisian' => 'pending',
                        'token_akses' => \Str::random(32),
                        'expired_at' => now()->addDays(30),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('home')->with('success', 'Kuesioner berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        $tracer = TracerStudy::findOrFail($id);
        $tracer->delete();

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
    public function showStudy($id)
    {
        $tracer = TracerStudy::with('alumni')->where('id_alumni', $id)->firstOrFail();

        return view('alumni.tracer.study.detail-study', compact('tracer'));
    }
    public function edit()
{
    $user = auth()->user();
    $alumni = Alumni::where('id_users', $user->id)->first();
    $tracer = $alumni ? TracerStudy::where('id_alumni', $alumni->id)->first() : null;

    return view('alumni.tracer.study.edit-kuesioner', compact('alumni', 'tracer'));
}
public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required'],
            'email' => ['required', 'email', 'max:255'],
            'tahun_lulus' => ['required', 'integer'],
            'alamat' => ['required', 'string', 'max:255'],
            'bekerja' => ['required', 'string', 'in:ya,wirausaha,tidak'],
            // detail pekerjaan
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'alamat_pekerjaan' => ['nullable', 'string', 'max:255'],
            'gaji' => ['nullable', 'string', 'max:255'],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'kota' => ['nullable', 'string', 'max:255'],
            'tingkat_usaha_level' => ['nullable', 'string', 'max:255'],
            // informasi atasan
            'nama_atasan' => ['nullable', 'string', 'max:255'],
            'jabatan_atasan' => ['nullable', 'string', 'max:255'],
            'wa_atasan' => ['nullable', 'string', 'max:255'],
            'email_atasan' => ['nullable', 'email', 'max:255'],
            // detail wirausaha
            'nama_usaha' => ['nullable', 'string', 'max:255'],
            'posisi_usaha' => ['nullable', 'string', 'max:255'],
            'tingkat_usaha' => ['nullable', 'string', 'max:255'],
            'alamat_usaha' => ['nullable', 'string', 'max:255'],
            'pendapatan_usaha' => ['nullable', 'string', 'max:255'],
            // kompetensi
            'etika' => ['required', 'string'],
            'keahlian' => ['required', 'string'],
            'penggunaanteknologi' => ['required', 'string'],
            'teamwork' => ['required', 'string'],
            'komunikasi' => ['required', 'string'],
            'pengembangan' => ['required', 'string'],
            // evaluasi
            'relevansi_kurikulum' => ['required', 'string'],
            'saran' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();

        $user = auth()->user();
        $alumni = Alumni::where('id_users', $user->id)->firstOrFail();

        $alumni->update([
            'nama_lengkap' => $validated['nama'],
            'no_hp' => $validated['no_hp'],
            'tahun_lulus' => $validated['tahun_lulus'],
            'alamat' => $validated['alamat'],
        ]);

        $user->update(['email' => $validated['email']]);

        $dataPekerjaan = [
            'nama_perusahaan' => null,
            'jabatan' => null,
            'alamat_pekerjaan' => null,
            'gaji' => null,
            'provinsi' => null,
            'kota' => null,
            'tingkat_usaha_level' => null,
            'nama_atasan' => null,
            'jabatan_atasan' => null,
            'wa_atasan' => null,
            'email_atasan' => null,
            'nama_usaha' => null,
            'posisi_usaha' => null,
            'tingkat_usaha' => null,
            'alamat_usaha' => null,
            'pendapatan_usaha' => null,
        ];

        if ($validated['bekerja'] === 'ya') {
            $dataPekerjaan['nama_perusahaan'] = $validated['nama_perusahaan'];
            $dataPekerjaan['jabatan'] = $validated['jabatan'];
            $dataPekerjaan['alamat_pekerjaan'] = $validated['alamat_pekerjaan'];
            $dataPekerjaan['gaji'] = $validated['gaji'];
            $dataPekerjaan['provinsi'] = $validated['provinsi'];
            $dataPekerjaan['kota'] = $validated['kota'];
            $dataPekerjaan['tingkat_usaha_level'] = $validated['tingkat_usaha_level'];
            $dataPekerjaan['nama_atasan'] = $validated['nama_atasan'];
            $dataPekerjaan['jabatan_atasan'] = $validated['jabatan_atasan'];
            $dataPekerjaan['wa_atasan'] = $validated['wa_atasan'];
            $dataPekerjaan['email_atasan'] = $validated['email_atasan'];
        } elseif ($validated['bekerja'] === 'wirausaha') {
            $dataPekerjaan['nama_usaha'] = $validated['nama_usaha'];
            $dataPekerjaan['posisi_usaha'] = $validated['posisi_usaha'];
            $dataPekerjaan['tingkat_usaha'] = $validated['tingkat_usaha'];
            $dataPekerjaan['alamat_usaha'] = $validated['alamat_usaha'];
            $dataPekerjaan['pendapatan_usaha'] = $validated['pendapatan_usaha'];
        }

        $tracer = TracerStudy::findOrFail($id);
        $tracer->update([
            'tanggal_isi' => now(),
            'bekerja' => $validated['bekerja'],
            'nama_perusahaan' => $dataPekerjaan['nama_perusahaan'],
            'jabatan' => $dataPekerjaan['jabatan'],
            'alamat_pekerjaan' => $dataPekerjaan['alamat_pekerjaan'],
            'gaji' => $dataPekerjaan['gaji'],
            'provinsi' => $dataPekerjaan['provinsi'],
            'kota' => $dataPekerjaan['kota'],
            'tingkat_usaha_level' => $dataPekerjaan['tingkat_usaha_level'],
            'nama_atasan' => $dataPekerjaan['nama_atasan'],
            'jabatan_atasan' => $dataPekerjaan['jabatan_atasan'],
            'wa_atasan' => $dataPekerjaan['wa_atasan'],
            'email_atasan' => $dataPekerjaan['email_atasan'],
            'nama_usaha' => $dataPekerjaan['nama_usaha'],
            'posisi_usaha' => $dataPekerjaan['posisi_usaha'],
            'tingkat_usaha' => $dataPekerjaan['tingkat_usaha'],
            'alamat_usaha' => $dataPekerjaan['alamat_usaha'],
            'pendapatan_usaha' => $dataPekerjaan['pendapatan_usaha'],
            'status_kerja' => $validated['bekerja'],
            'etika' => $validated['etika'],
            'keahlian' => $validated['keahlian'],
            'penggunaanteknologi' => $validated['penggunaanteknologi'],
            'teamwork' => $validated['teamwork'],
            'komunikasi' => $validated['komunikasi'],
            'pengembangan' => $validated['pengembangan'],
            'relevansi_pekerjaan' => $validated['relevansi_kurikulum'],
            'saran' => $validated['saran'],
        ]);

        DB::commit();

        return redirect()->route('home')->with('success', 'Data kuesioner berhasil diperbarui!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
    }
}


}
