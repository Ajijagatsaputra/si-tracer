<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Models\JobApplication;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobVacancyController extends Controller
{
    // ─────────────────────────────────────────────────────
    //  MITRA (PUBLIC) — Upload loker dari form publik
    // ─────────────────────────────────────────────────────

    /**
     * Show public job posting form for Mitra.
     */
    public function mitraCreate()
    {
        return view('mitra.create-loker');
    }

    /**
     * Store public job posting from Mitra.
     */
    public function mitraStore(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_link' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posters' => 'nullable|array|max:10',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', 'posters']);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $data['logo_path'] = '/storage/' . $path;
        }

        if ($request->hasFile('posters')) {
            $paths = [];
            foreach ($request->file('posters') as $file) {
                $path = $file->store('uploads/posters', 'public');
                $paths[] = '/storage/' . $path;
            }
            $data['poster_paths'] = $paths;
        }

        $data['status'] = 'pending';

        JobVacancy::create($data);

        return redirect()->back()->with('success_message', 'Lowongan pekerjaan berhasil diunggah! Lowongan Anda sedang dalam proses moderasi oleh Admin.');
    }

    // ─────────────────────────────────────────────────────
    //  ALUMNI — Riwayat Lamaran & Apply
    // ─────────────────────────────────────────────────────

    /**
     * Display alumni's job application history (riwayat lamaran).
     */
    public function alumniIndex(Request $request)
    {
        $user = Auth::user();
        $alumni = $user->alumni ?? Alumni::where('id_users', $user->id)->first();

        if (!$alumni) {
            return redirect()->route('dashboard')->with('error', 'Data alumni tidak ditemukan.');
        }

        $query = JobApplication::where('alumni_id', $alumni->id)
            ->with('jobVacancy')
            ->latest('applied_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jobVacancy', function ($q) use ($search) {
                $q->where('position', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10);

        // Stats
        $stats = [
            'total' => JobApplication::where('alumni_id', $alumni->id)->count(),
            'applied' => JobApplication::where('alumni_id', $alumni->id)->where('status', 'applied')->count(),
            'reviewed' => JobApplication::where('alumni_id', $alumni->id)->where('status', 'reviewed')->count(),
            'accepted' => JobApplication::where('alumni_id', $alumni->id)->where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('alumni_id', $alumni->id)->where('status', 'rejected')->count(),
        ];

        return view('alumni.loker.index-loker', compact('applications', 'stats'));
    }

    /**
     * Alumni apply for a job vacancy.
     */
    public function applyJob(Request $request, $id)
    {
        $user = Auth::user();
        $alumni = $user->alumni ?? Alumni::where('id_users', $user->id)->first();

        if (!$alumni) {
            return response()->json(['success' => false, 'message' => 'Data alumni tidak ditemukan.'], 404);
        }

        $job = JobVacancy::where('id', $id)->where('status', 'approved')->firstOrFail();

        // Check duplicate
        $existing = JobApplication::where('alumni_id', $alumni->id)
            ->where('job_vacancy_id', $job->id)
            ->first();

        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melamar posisi ini.'], 422);
        }

        $request->validate([
            'cover_letter' => 'nullable|string|max:1000',
            'phone' => 'required|string|max:20',
            'expected_salary' => 'nullable|string|max:100',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $path = $request->file('cv')->store('uploads/cvs', 'public');
            $cvPath = '/storage/' . $path;
        }

        JobApplication::create([
            'alumni_id' => $alumni->id,
            'job_vacancy_id' => $job->id,
            'status' => 'applied',
            'cover_letter' => $request->cover_letter,
            'phone' => $request->phone,
            'expected_salary' => $request->expected_salary,
            'cv_path' => $cvPath,
            'applied_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lamaran berhasil dikirim! Silakan pantau status di dashboard.',
        ]);
    }

    /**
     * Fetch job details via AJAX for modal view.
     */
    public function alumniShow($id)
    {
        $job = JobVacancy::findOrFail($id);

        // Check if current alumni already applied
        $alreadyApplied = false;
        $user = Auth::user();
        if ($user && $user->role === 'alumni') {
            $alumni = $user->alumni;
            if ($alumni) {
                $alreadyApplied = JobApplication::where('alumni_id', $alumni->id)
                    ->where('job_vacancy_id', $job->id)
                    ->exists();
            }
        }

        $jobData = $job->toArray();
        $jobData['already_applied'] = $alreadyApplied;

        return response()->json($jobData);
    }

    // ─────────────────────────────────────────────────────
    //  ADMIN — Moderasi Loker + Upload + Kelola Lamaran
    // ─────────────────────────────────────────────────────

    /**
     * Display job postings for Admin moderation.
     */
    public function adminIndex(Request $request)
    {
        $query = JobVacancy::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('position', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        $jobs = $query->latest()->paginate(15);

        return view('admin.loker.manage-loker', compact('jobs'));
    }

    /**
     * Show admin create loker form.
     */
    public function adminCreate()
    {
        return view('admin.loker.create-loker');
    }

    /**
     * Store loker from admin (langsung approved).
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_link' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posters' => 'nullable|array|max:10',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', 'posters']);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $data['logo_path'] = '/storage/' . $path;
        }

        if ($request->hasFile('posters')) {
            $paths = [];
            foreach ($request->file('posters') as $file) {
                $path = $file->store('uploads/posters', 'public');
                $paths[] = '/storage/' . $path;
            }
            $data['poster_paths'] = $paths;
        }

        // Admin upload → langsung approved
        $data['status'] = 'approved';

        JobVacancy::create($data);

        return redirect()->route('admin.loker.index')->with('success', 'Lowongan pekerjaan berhasil ditambahkan dan langsung aktif!');
    }

    /**
     * Display alumni job applications for admin management.
     */
    public function adminApplications(Request $request)
    {
        $query = JobApplication::with(['alumni', 'jobVacancy'])->latest('applied_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('alumni', function ($q2) use ($search) {
                    $q2->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%");
                })->orWhereHas('jobVacancy', function ($q2) use ($search) {
                    $q2->where('position', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query->paginate(15);

        // Stats
        $stats = [
            'total' => JobApplication::count(),
            'applied' => JobApplication::where('status', 'applied')->count(),
            'reviewed' => JobApplication::where('status', 'reviewed')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.loker.applications', compact('applications', 'stats'));
    }

    /**
     * Admin update application status.
     */
    public function adminUpdateApplicationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:reviewed,accepted,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $application = JobApplication::findOrFail($id);
        $application->status = $request->status;
        $application->admin_notes = $request->admin_notes;

        if (in_array($request->status, ['reviewed', 'accepted', 'rejected'])) {
            $application->reviewed_at = now();
        }

        $application->save();

        return response()->json([
            'success' => true,
            'message' => 'Status lamaran berhasil diperbarui menjadi: ' . $application->status_label,
        ]);
    }

    /**
     * Approve job vacancy.
     */
    public function approve($id)
    {
        $job = JobVacancy::findOrFail($id);
        $job->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan pekerjaan berhasil disetujui!'
        ]);
    }

    /**
     * Reject job vacancy.
     */
    public function reject($id)
    {
        $job = JobVacancy::findOrFail($id);
        $job->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan pekerjaan berhasil ditolak!'
        ]);
    }

    /**
     * Show edit form for job vacancy (Admin).
     */
    public function adminEdit($id)
    {
        $job = JobVacancy::findOrFail($id);
        return view('admin.loker.edit-loker', compact('job'));
    }

    /**
     * Update job vacancy (Admin).
     */
    public function adminUpdate(Request $request, $id)
    {
        $job = JobVacancy::findOrFail($id);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_link' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'posters' => 'nullable|array|max:10',
            'posters.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['logo', 'posters', 'keep_posters']);

        // Handle Logo Update
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($job->logo_path) {
                $oldPath = str_replace('/storage/', '', $job->logo_path);
                Storage::disk('public')->delete($oldPath);
            }
            // Store new logo
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $data['logo_path'] = '/storage/' . $path;
        }

        // Handle Posters Edit
        $currentPosters = is_array($job->poster_paths) ? $job->poster_paths : [];
        $keepPosters = $request->input('keep_posters', []);

        // Delete removed posters from disk
        foreach ($currentPosters as $posterPath) {
            if (!in_array($posterPath, $keepPosters)) {
                $path = str_replace('/storage/', '', $posterPath);
                Storage::disk('public')->delete($path);
            }
        }

        $finalPosters = $keepPosters;

        // Store new posters
        if ($request->hasFile('posters')) {
            $newCount = count($request->file('posters'));
            if (count($finalPosters) + $newCount > 10) {
                return back()->withErrors(['posters' => 'Total poster (lama + baru) tidak boleh melebihi 10 gambar.'])->withInput();
            }

            foreach ($request->file('posters') as $file) {
                $path = $file->store('uploads/posters', 'public');
                $finalPosters[] = '/storage/' . $path;
            }
        }

        $data['poster_paths'] = $finalPosters;

        $job->update($data);

        return redirect()->route('admin.loker.index')->with('success', 'Lowongan pekerjaan berhasil diperbarui!');
    }

    /**
     * Delete job vacancy.
     */
    public function destroy($id)
    {
        $job = JobVacancy::findOrFail($id);

        // Delete logo if exists
        if ($job->logo_path) {
            $path = str_replace('/storage/', '', $job->logo_path);
            Storage::disk('public')->delete($path);
        }

        // Delete posters if exist
        if (is_array($job->poster_paths)) {
            foreach ($job->poster_paths as $posterPath) {
                $path = str_replace('/storage/', '', $posterPath);
                Storage::disk('public')->delete($path);
            }
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lowongan pekerjaan berhasil dihapus!'
        ]);
    }
}