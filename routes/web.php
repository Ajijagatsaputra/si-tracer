<?php

use App\Http\Controllers\AdminTracerPenggunaController;
use App\Http\Controllers\ProfileAlumniController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HasilTracerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminTracerStudyAlumniController;
use App\Http\Controllers\TracerStudyController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileAdminController;
use App\Http\Controllers\WilayahController;

// Route untuk CSRF token (untuk refresh token)
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Auth
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Register (umum)
Route::get('/register', fn() => view('register'))->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

// Admin-only routes
Route::middleware(['auth', 'cekrole:admin,superadmin'])->group(function () {
    Route::get('/admin', function () {
        $response = Http::get('https://api.oase.poltektegal.ac.id/api/web/mahasiswa', [
            'key' => env('OASE_API_KEY'),
            'tahun_angkatan' => '2021'
        ]);
        $count = count($response->json()['data']);
        return view('admin.admin-dashboard', compact('count'));
    })->name('admin.dashboard');


    Route::get('/profileadmin/index', [ProfileAdminController::class, 'show'])->name('profileadmin.index');
    Route::put('/profileadmin/update', [ProfileAdminController::class, 'update'])->name('profileadmin.update');
    Route::put('/profileadmin/password', [ProfileAdminController::class, 'updatePassword'])->name('profileadmin.update-password');

    Route::get('/listmahasiswa', fn() => view('admin.dataMaster.table-mahasiswa'))->name('listmahasiswa');
    Route::get('/listdosen', fn() => view('admin.dataMaster.table-dosen'))->name('listdosen');
    Route::get('/listalumni', fn() => view('admin.dataMaster.table-alumni'))->name('listalumni');

    // Route::get('/listhasiltracer', fn() => view('tracer.hasil'));
    Route::get('/listhasiltracer', [HasilTracerController::class, 'index'])->name('tracer.rekap');

    // Route::get('/listtraceralumni', [TracerAlumniController::class, 'index'])->name('tracer.index');
    Route::get('/api/mahasiswa', [MahasiswaController::class, 'getData'])->name('api.mahasiswa');
    Route::get('/api/alumni', [AdminTracerStudyAlumniController::class, 'getData'])->name('api.alumni');
    Route::get('/api/dosen', [DosenController::class, 'getDataDosen'])->name('api.dosen');
    Route::get('/api/tahun-akademik', [DosenController::class, 'getTahunAkademik'])->name('api.tahun-akademik');
});

// Alumni-only routes
Route::middleware(['auth', 'cekrole:alumni'])->group(function () {
    // Route::get('/kuesioner', [KuesionerAlumniController::class, 'index'])->name('tracer.kuesioner');
    // Route::post('/kuesioner/store', [KuesionerAlumniController::class, 'store'])->name('tracer.create');
    // Route::get('/kuesioner/edit', [KuesionerAlumniController::class, 'edit'])->name('kuesioner.edit');
    // Route::put('/kuesioner/update/{id}', [KuesionerAlumniController::class, 'update'])->name('kuesioner.update');

    // Route::get('/tracer-study/form/{id}', [KuesionerAlumniController::class, 'showStudy'])->name('tracer.showstudy');
    // Route::get('/tracer-pengguna/form/{id}', [KuesionerPenggunaController::class, 'showPengguna'])->name('tracer.showpengguna');
    // Route::get('/kuesioner-pengguna/edit/{id}', [KuesionerPenggunaController::class, 'edit'])->name('tracer.kuesioner-pengguna.edit');
    // Route::put('/kuesioner-pengguna/update/{id}', [KuesionerPenggunaController::class, 'update'])->name('tracer.kuesioner-pengguna.update');
    Route::get('/profil', [ProfileAlumniController::class, 'show'])->name('profile');
    Route::get('/profil/edit', [ProfileAlumniController::class, 'edit'])->name('profile.edit');
    Route::put('/profil/update', [ProfileAlumniController::class, 'update'])->name('profile.update');

    // Routes untuk Tracer Study yang Dioptimalkan (Alumni only)
    Route::prefix('new-tracer')->group(function () {
        Route::get('/', [TracerStudyController::class, 'index'])->name('new-tracer.index');
        Route::post('/store', [TracerStudyController::class, 'store'])->name('new-tracer.store');
        Route::get('/edit', [TracerStudyController::class, 'edit'])->name('new-tracer.edit');
        Route::put('/update/{id}', [TracerStudyController::class, 'update'])->name('new-tracer.update');
        Route::get('/show/{id}', [TracerStudyController::class, 'show'])->name('new-tracer.show');
        Route::get('/check-existing', [TracerStudyController::class, 'checkExisting'])->name('new-tracer.check-existing');
    });
});



Route::resource('listtracerpengguna', AdminTracerPenggunaController::class);
Route::get('listtraceralumni/{id}/detail', [AdminTracerStudyAlumniController::class, 'detail'])->name('listtraceralumni.detail');
Route::resource('listtraceralumni', AdminTracerStudyAlumniController::class);

// Route::put('/kuesioner-pengguna/update/{id}', [KuesionerPenggunaController::class, 'update'])->name('tracer.kuesioner-pengguna.update');
//     Route::get('/kuesioner-pengguna', [KuesionerPenggunaController::class, 'index'])->name('tracer.kuesioner-pengguna');
//     Route::post('/kuesioner-pengguna/store', [KuesionerPenggunaController::class, 'store'])->name('tracer.store');

// Routes untuk Supervisor Questionnaire
Route::prefix('supervisor')->group(function () {
    Route::get('/questionnaire/{token}', [App\Http\Controllers\SupervisorQuestionnaireController::class, 'show'])->name('supervisor.questionnaire');
    Route::get('/questionnaire/{token}/preview', [App\Http\Controllers\SupervisorQuestionnaireController::class, 'preview'])->name('supervisor.questionnaire.preview');
    Route::get('/questionnaire/{token}/hasil', [App\Http\Controllers\SupervisorQuestionnaireController::class, 'hasil'])->name('supervisor.questionnaire.hasil');
    Route::post('/questionnaire/{token}/submit', [App\Http\Controllers\SupervisorQuestionnaireController::class, 'submit'])->name('supervisor.questionnaire.submit');
});

// Admin routes untuk Supervisor Questionnaire
Route::middleware(['auth', 'cekrole:admin,superadmin'])->group(function () {
    // Routes untuk AdminSupervisorQuestionnaireController
    Route::prefix('admin/supervisor-questionnaire')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'index'])->name('admin.supervisor-questionnaire.index');
        Route::get('/dashboard', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'dashboard'])->name('admin.supervisor-questionnaire.dashboard');
        Route::get('/{id}', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'show'])->name('admin.supervisor-questionnaire.show');
        Route::get('/{id}/edit', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'edit'])->name('admin.supervisor-questionnaire.edit');
        Route::put('/{id}', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'update'])->name('admin.supervisor-questionnaire.update');
        Route::delete('/{id}', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'destroy'])->name('admin.supervisor-questionnaire.destroy');
        Route::get('/{id}/resend-notification', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'resendNotification'])->name('admin.supervisor-questionnaire.resend-notification');
        Route::post('/{id}/extend-expiry', [App\Http\Controllers\AdminSupervisorQuestionnaireController::class, 'extendExpiry'])->name('admin.supervisor-questionnaire.extend-expiry');
    });
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Route::post('/kuesioner/store', [KuesionerAlumni::class, 'create'])->name('tracer.create');
    // Route::get('/tracer/user-data', [KuesionerAlumniController::class, 'getUserData'])->name('tracer.user-data');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});

// Admin routes
// Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
//     Route::get('/tracer/results', [KuesionerAlumniController::class, 'results'])->name('admin.tracer.results');
//     Route::get('/tracer/export', [KuesionerAlumniController::class, 'export'])->name('admin.tracer.export');
//     Route::delete('/tracer/{id}', [KuesionerAlumniController::class, 'destroy'])->name('admin.tracer.destroy');
// });

// Alternative routes if you don't use admin middleware
// Route::middleware('auth')->group(function () {
//     Route::get('/tracer/results', [KuesionerAlumniController::class, 'results'])->name('tracer.results');
//     Route::get('/tracer/export', [KuesionerAlumniController::class, 'export'])->name('tracer.export');
//     Route::delete('/tracer/{id}', [KuesionerAlumniController::class, 'destroy'])->name('tracer.destroy');
// });

// API untuk wilayah
Route::get('/api/provinsi', [WilayahController::class, 'getProvinsi']);
Route::get('/api/kota/{provinceCode}', [WilayahController::class, 'getKota']);

// CSRF Token route untuk refresh token
// Route::get('/csrf-token', function () {
//     return response()->json(['token' => csrf_token()]);
// });


use App\Http\Controllers\PrediksiController;

Route::match(['get', 'post'], '/prediksi', [PrediksiController::class, 'predictOutcome'])->name('predictOutcome');
Route::get('/prediksi', [PrediksiController::class, 'showForm'])->name('predictOutcome');
Route::post('/prediksi', [PrediksiController::class, 'predictOutcome']);
