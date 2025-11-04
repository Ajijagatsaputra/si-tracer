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
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PrediksiOpenRouterController;
use App\Http\Controllers\AdminPrediksiController;
use App\Http\Controllers\GeminiExtractController;

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
    Route::get('/listhasiltracer', [HasilTracerController::class, 'index'])->name('tracer.rekap');
    Route::get('/api/mahasiswa', [MahasiswaController::class, 'getData'])->name('api.mahasiswa');
    Route::get('/api/alumni', [AdminTracerStudyAlumniController::class, 'getData'])->name('api.alumni');
    Route::get('/api/dosen', [DosenController::class, 'getDataDosen'])->name('api.dosen');
    Route::get('/api/tahun-akademik', [DosenController::class, 'getTahunAkademik'])->name('api.tahun-akademik');

    // Admin Prediksi pages
    Route::get('/admin/prediksi', [AdminPrediksiController::class, 'index'])->name('admin.prediksi.index');
    Route::get('/admin/prediksi/data', [AdminPrediksiController::class, 'data'])->name('admin.prediksi.data');
});

// Alumni-only routes
Route::middleware(['auth', 'cekrole:alumni'])->group(function () {
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
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// API untuk wilayah
Route::get('/api/provinsi', [WilayahController::class, 'getProvinsi']);
Route::get('/api/kota/{provinceCode}', [WilayahController::class, 'getKota']);


//Route untuk Prediksi
Route::match(['get', 'post'], '/prediksi', [PrediksiController::class, 'predictOutcome'])->name('predictOutcome');
Route::get('/prediksi', [PrediksiController::class, 'showForm'])->name('predictOutcome');
Route::post('/prediksi', [PrediksiController::class, 'predictOutcome']);

// (migrated to controller routes above)

// OCR API endpoint
Route::post('/api/ocr-pdf', [OcrController::class, 'processPdf'])->name('api.ocr-pdf');
Route::post('/api/ocr-gemini-extract', [GeminiExtractController::class, 'extractFromPdf'])->name('api.ocr-gemini-extract');

// Academic Scores API endpoints
Route::middleware('auth')->group(function () {
    Route::post('/api/academic-scores/save', [MataKuliahController::class, 'saveAcademicScores'])->name('api.academic-scores.save');
    Route::get('/api/academic-scores', [MataKuliahController::class, 'getUserAcademicScores'])->name('api.academic-scores.get');
    Route::put('/api/academic-scores/update', [MataKuliahController::class, 'updateAcademicScore'])->name('api.academic-scores.update');
    Route::delete('/api/academic-scores/delete', [MataKuliahController::class, 'deleteAcademicScore'])->name('api.academic-scores.delete');
});

Route::post('/api/predict-gemini', [\App\Http\Controllers\PrediksiController::class, 'ajaxPredictGemini'])->name('api.predict-gemini');
Route::post('/api/predict-openrouter', [\App\Http\Controllers\PrediksiOpenRouterController::class, 'ajaxPredictOpenRouter'])->name('api.predict-openrouter');
