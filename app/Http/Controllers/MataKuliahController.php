<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\MataKuliah;
use App\Models\NilaiAkademik;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MataKuliahController extends Controller
{
    /**
     * Save academic scores data to database
     */
    public function saveAcademicScores(Request $request): JsonResponse
    {
        // dd($request);
        try {
            // Validate request
            $request->validate([
                'academic_scores' => 'required|array|min:1',
                'academic_scores.*.mataKuliah' => 'required|string|max:255',
                'academic_scores.*.sks' => 'required|integer|min:1|max:6',
                'academic_scores.*.grade' => 'required|string|in:A,A-,B+,B,B-,C+,C,C-,D+,D,E',
            ]);

            $academicScores = $request->input('academic_scores');
            $userId = Auth::id();

            // Get alumni ID from user, or create one if doesn't exist
            $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
            if (!$alumni) {
                // Create new alumni record for this user
                $user = \App\Models\User::find($userId);
                if (!$user) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User tidak ditemukan'
                    ], 404);
                }

                $alumni = \App\Models\Alumni::create([
                    'id_users' => $userId,
                    'nim' => $userId, // Using user ID as NIM for now
                    'nama_lengkap' => $user->name ?? 'User ' . $userId,
                    'prodi' => 'Unknown',
                    'kelas' => 'Unknown',
                    'jalur' => 'Unknown',
                    'tahun_masuk' => date('Y'),
                    'status_mahasiswa' => 'Alumni',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            $alumniId = $alumni->id;

            // Start database transaction
            DB::beginTransaction();

            try {
                $savedCount = 0;
                $errors = [];

                foreach ($academicScores as $score) {
                    // Check if user already has this mata kuliah
                    $existingNilai = NilaiAkademik::where('idAlumni', $alumniId)
                        ->where('mataKuliah', $score['mataKuliah'])
                        ->first();

                    if ($existingNilai) {
                        // Update existing nilai
                        $existingNilai->update([
                            'sks' => $score['sks'],
                            'grade' => $score['grade'],
                            'updated_at' => now()
                        ]);
                    } else {
                        // Create new nilai akademik
                        NilaiAkademik::create([
                            'idAlumni' => $alumniId,
                            'mataKuliah' => $score['mataKuliah'],
                            'sks' => $score['sks'],
                            'grade' => $score['grade'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }

                    $savedCount++;
                }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => "Berhasil menyimpan {$savedCount} mata kuliah",
                    'data' => [
                        'saved_count' => $savedCount,
                        'total_submitted' => count($academicScores)
                    ]
                ]);

            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Save Academic Scores Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get user's academic scores
     */
    public function getUserAcademicScores(): JsonResponse
    {
        try {
            $userId = Auth::id();

            // Get alumni ID from user, or create one if doesn't exist
            $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
            if (!$alumni) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diambil',
                    'data' => []
                ]);
            }

            $academicScores = NilaiAkademik::where('idAlumni', $alumni->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($nilai) {
                    return [
                        'id' => $nilai->id,
                        'mataKuliah' => $nilai->mataKuliah,
                        'sks' => $nilai->sks,
                        'grade' => $nilai->grade,
                        'created_at' => $nilai->created_at->format('Y-m-d H:i:s')
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil',
                'data' => $academicScores
            ]);

        } catch (\Exception $e) {
            Log::error('Get Academic Scores Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Delete specific academic score
     */
    public function deleteAcademicScore(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:nilai_akademik,id'
            ]);

            $userId = Auth::id();
            $nilaiId = $request->input('id');

            // Get alumni ID from user
            $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
            if (!$alumni) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data alumni tidak ditemukan untuk user ini'
                ], 404);
            }

            $nilai = NilaiAkademik::where('id', $nilaiId)
                ->where('idAlumni', $alumni->id)
                ->first();

            if (!$nilai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan atau tidak memiliki akses'
                ], 404);
            }

            $nilai->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Delete Academic Score Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update specific academic score
     */
    public function updateAcademicScore(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:nilai_akademik,id',
                'mataKuliah' => 'required|string|max:255',
                'sks' => 'required|integer|min:1|max:6',
                'grade' => 'required|string|in:A,A-,B+,B,B-,C+,C,C-,D+,D,E',
            ]);

            $userId = Auth::id();
            $nilaiId = $request->input('id');

            // Get alumni ID from user
            $alumni = \App\Models\Alumni::where('id_users', $userId)->first();
            if (!$alumni) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data alumni tidak ditemukan untuk user ini'
                ], 404);
            }

            $nilai = NilaiAkademik::where('id', $nilaiId)
                ->where('idAlumni', $alumni->id)
                ->first();

            if (!$nilai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan atau tidak memiliki akses'
                ], 404);
            }

            // Update nilai akademik
            $nilai->update([
                'mataKuliah' => $request->input('mataKuliah'),
                'sks' => $request->input('sks'),
                'grade' => $request->input('grade'),
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => [
                    'id' => $nilai->id,
                    'mataKuliah' => $nilai->mataKuliah,
                    'sks' => $nilai->sks,
                    'grade' => $nilai->grade
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Update Academic Score Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }
}
