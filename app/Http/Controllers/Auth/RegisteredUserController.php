<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nim' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tahun_angkatan' => ['required']
        ]);

        if (Cache::has('oase:is_offline')) {
            return back()->withErrors([
                'nim' => 'Pendaftaran tidak dapat diproses saat ini karena verifikasi data alumni (API OASE) sedang offline. Silakan coba beberapa saat lagi.',
            ]);
        }

        try {
            $response = Http::timeout(10)->get('https://api.oase.poltektegal.ac.id/api/web/mahasiswa', [
                'key' => env('OASE_API_KEY'),
                'nim' => $request->nim,
                'tahun_angkatan' => $request->tahun_angkatan
            ]);

            if (!$response->successful()) {
                return back()->withErrors([
                    'nim' => 'Gagal memverifikasi data ke API OASE. Respons server tidak berhasil.',
                ]);
            }

            $dataJson = $response->json();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Cache::put('oase:is_offline', true, 300);
            return back()->withErrors([
                'nim' => 'API OASE tidak merespons. Proses verifikasi data alumni tertunda, silakan coba lagi nanti.',
            ]);
        }

        if (!isset($dataJson['status']) || $dataJson['status'] == false || empty($dataJson['data'])) {
            return back()->withErrors([
                'nim' => 'NIM tidak ditemukan atau data mahasiswa tidak valid',
            ]);
        } elseif ($dataJson['data'][0]['status_mahasiswa'] != 'Lulus') {
            return back()->withErrors([
                'nim' => 'Mahasiswa belum lulus',
            ]);
        } else {
            $user = User::create([
                'username' => str_replace(' ', '', strtolower($dataJson['data'][0]['nama_lengkap'])),
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $alumni = Alumni::create([
                'id_users' => $user->id,
                'nim' => $dataJson['data'][0]['nim'],
                'nama_lengkap' => $dataJson['data'][0]['nama_lengkap'],
                'no_hp' => $dataJson['data'][0]['no_whatsapp'],
                'prodi' => $dataJson['data'][0]['prodi']['nama'],
                'kelas' => $dataJson['data'][0]['kelas'],
                'jalur' => $dataJson['data'][0]['jalur'],
                'tahun_masuk' => $dataJson['data'][0]['tahun_masuk'],
                'status_mahasiswa' => $dataJson['data'][0]['status_mahasiswa'],
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        }

    }
}
