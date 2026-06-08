<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobVacancyController extends Controller
{
    /**
     * Show public job posting form for Mitra.
     */
    public function showUploadForm()
    {
        return view('mitra.create-loker');
    }

    /**
     * Store public job posting from Mitra.
     */
    public function storePublic(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_link' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads/logos', 'public');
            $data['logo_path'] = '/storage/' . $path;
        }

        $data['status'] = 'pending';

        JobVacancy::create($data);

        return redirect()->back()->with('success_message', 'Lowongan pekerjaan berhasil diunggah! Lowongan Anda sedang dalam proses moderasi oleh Admin.');
    }

    /**
     * Display approved job postings for Alumni.
     */
    public function alumniIndex(Request $request)
    {
        $query = JobVacancy::where('status', 'approved');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('position', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $jobs = $query->latest()->paginate(9);

        // Get unique categories for filtering
        $categories = JobVacancy::where('status', 'approved')
            ->distinct()
            ->pluck('category');

        return view('alumni.loker.index-loker', compact('jobs', 'categories'));
    }

    /**
     * Fetch job details via AJAX for modal view.
     */
    public function alumniShow($id)
    {
        $job = JobVacancy::findOrFail($id);
        return response()->json($job);
    }

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
     * Approve job vacancy.
     */
    public function adminApprove($id)
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
    public function adminReject($id)
    {
        $job = JobVacancy::findOrFail($id);
        $job->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan pekerjaan berhasil ditolak!'
        ]);
    }

    /**
     * Delete job vacancy.
     */
    public function adminDestroy($id)
    {
        $job = JobVacancy::findOrFail($id);

        // Delete logo if exists
        if ($job->logo_path) {
            $path = str_replace('/storage/', '', $job->logo_path);
            Storage::disk('public')->delete($path);
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lowongan pekerjaan berhasil dihapus!'
        ]);
    }
}
