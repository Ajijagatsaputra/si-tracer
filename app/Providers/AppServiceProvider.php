<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Alumni;
use App\Models\TracerStudy;
use App\Models\JobVacancy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share dynamic notifications with the layout
        View::composer('layout', function ($view) {
            $notifications = [];
            $unreadCount = 0;
            $user = Auth::user();

            if ($user) {
                // --- Alumni-specific notifications ---
                if ($user->role === 'alumni') {
                    $alumni = $user->alumni ?? Alumni::where('id_users', $user->id)->first();

                    // 1) Tracer Study status
                    $hasFilledTracer = $alumni
                        ? TracerStudy::where('alumni_id', $alumni->id)->exists()
                        : false;

                    if ($hasFilledTracer) {
                        $tracer = TracerStudy::where('alumni_id', $alumni->id)->first();
                        $notifications[] = [
                            'icon' => 'fa-check-circle',
                            'color' => 'text-success',
                            'title' => 'Kuesioner Tracer Study telah diisi',
                            'desc' => 'Terima kasih telah berpartisipasi dalam Tracer Study.',
                            'time' => $tracer->tanggal_isi
                                ? $tracer->tanggal_isi->translatedFormat('d M Y')
                                : ($tracer->created_at ? $tracer->created_at->translatedFormat('d M Y') : '-'),
                            'url' => $alumni ? route('new-tracer.show', $alumni->id) : '#',
                            'unread' => false,
                        ];
                    } else {
                        $notifications[] = [
                            'icon' => 'fa-exclamation-triangle',
                            'color' => 'text-warning',
                            'title' => 'Anda belum mengisi Kuesioner Tracer Study',
                            'desc' => 'Segera isi kuesioner untuk membantu evaluasi kampus.',
                            'time' => 'Penting',
                            'url' => route('new-tracer.index'),
                            'unread' => true,
                        ];
                        $unreadCount++;
                    }

                    // 2) Profile completeness check
                    if ($alumni) {
                        $missingFields = [];
                        if (empty($alumni->alamat))
                            $missingFields[] = 'Alamat';
                        if (empty($alumni->no_hp))
                            $missingFields[] = 'No. HP';

                        if (!empty($missingFields)) {
                            $notifications[] = [
                                'icon' => 'fa-user-edit',
                                'color' => 'text-info',
                                'title' => 'Lengkapi data profil Anda',
                                'desc' => 'Data belum lengkap: ' . implode(', ', $missingFields) . '.',
                                'time' => 'Aksi diperlukan',
                                'url' => route('profile'),
                                'unread' => true,
                            ];
                            $unreadCount++;
                        }
                    }

                    // 3) Job Applications status info
                    if ($alumni) {
                        $appliedJobsCount = \App\Models\JobApplication::where('alumni_id', $alumni->id)->count();
                        if ($appliedJobsCount > 0) {
                            $notifications[] = [
                                'icon' => 'fa-briefcase',
                                'color' => 'text-primary',
                                'title' => 'Anda memiliki ' . $appliedJobsCount . ' lamaran terkirim',
                                'desc' => 'Pantau status lamaran pekerjaan Anda secara berkala.',
                                'time' => 'Lamaran',
                                'url' => route('alumni.loker.index'),
                                'unread' => false,
                            ];
                        }
                    }

                    // --- Admin-specific notifications ---
                } elseif (in_array($user->role, ['admin', 'superadmin'])) {
                    $totalAlumni = Alumni::count();
                    $totalTracer = TracerStudy::count();
                    $belumMengisi = $totalAlumni - $totalTracer;

                    if ($belumMengisi > 0) {
                        $notifications[] = [
                            'icon' => 'fa-users',
                            'color' => 'text-warning',
                            'title' => $belumMengisi . ' alumni belum mengisi kuesioner',
                            'desc' => 'Dari total ' . $totalAlumni . ' alumni terdaftar.',
                            'time' => 'Info',
                            'url' => route('listalumni'),
                            'unread' => true,
                        ];
                        $unreadCount++;
                    }

                    $pendingJobs = JobVacancy::where('status', 'pending')->count();
                    if ($pendingJobs > 0) {
                        $notifications[] = [
                            'icon' => 'fa-briefcase',
                            'color' => 'text-info',
                            'title' => $pendingJobs . ' lowongan menunggu persetujuan',
                            'desc' => 'Terdapat lowongan baru dari mitra yang perlu ditinjau.',
                            'time' => 'Aksi diperlukan',
                            'url' => route('admin.loker.index'),
                            'unread' => true,
                        ];
                        $unreadCount++;
                    }

                    $newApplications = \App\Models\JobApplication::where('status', 'applied')->count();
                    if ($newApplications > 0) {
                        $notifications[] = [
                            'icon' => 'fa-file-signature',
                            'color' => 'text-success',
                            'title' => $newApplications . ' lamaran alumni baru masuk',
                            'desc' => 'Tinjau lamaran kerja alumni yang belum diproses.',
                            'time' => 'Aksi diperlukan',
                            'url' => route('admin.loker.applications'),
                            'unread' => true,
                        ];
                        $unreadCount++;
                    }
                }

                // 4) Welcome notification (always shown for all roles)
                $notifications[] = [
                    'icon' => 'fa-hand-sparkles',
                    'color' => 'text-success',
                    'title' => 'Selamat datang, ' . $user->username . '!',
                    'desc' => 'Anda login sebagai ' . ucfirst($user->role) . ' di Tracer Study TI UHN.',
                    'time' => now()->translatedFormat('d M Y'),
                    'url' => '#',
                    'unread' => false,
                ];
            }

            $view->with('headerNotifications', $notifications);
            $view->with('headerUnreadCount', $unreadCount);
        });
    }
}
