@extends('layouts.admin')

@section('content')
<div class="max-w-6xl p-6 mx-auto transition-shadow duration-500 bg-white border border-gray-100 shadow-2xl sm:p-10 rounded-3xl">
    <div class="flex flex-col items-start justify-between pb-4 mb-8 border-b border-gray-200 sm:flex-row sm:items-center sm:mb-10">
        <h2 class="flex items-center gap-3 text-2xl font-extrabold text-gray-800 sm:text-3xl">
            <i class="text-teal-600 fa-solid fa-brain"></i>
            Detail Riwayat Prediksi
        </h2>
        <a href="{{ route('admin.prediksi.data') }}"
           class="inline-flex items-center px-4 py-2 mt-4 text-sm font-semibold text-gray-600 transition-all duration-300 bg-gray-100 rounded-full shadow-md sm:mt-0 hover:bg-gray-200 hover:shadow-lg">
            <i class="mr-2 fa-solid fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="p-6 space-y-6 border border-gray-100 shadow-inner lg:col-span-1 bg-gray-50 rounded-xl">
            <h3 class="pb-2 mb-4 text-lg font-bold text-gray-700 border-b">Informasi Transaksi</h3>

            <div>
                <p class="text-xs font-medium tracking-widest text-gray-500 uppercase">ID Prediksi</p>
                <p class="mt-1 text-xl font-bold text-gray-900">{{ $history->id }}</p>
            </div>

            <div>
                <p class="text-xs font-medium tracking-widest text-gray-500 uppercase">Nama Alumni</p>
                <p class="mt-1 text-lg font-semibold text-teal-600">
                    {{ $history->alumni->nama_lengkap ?? 'Alumni Tidak Ditemukan' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium tracking-widest text-gray-500 uppercase">Tanggal Prediksi</p>
                <p class="mt-1 text-gray-700 text-md">
                    <i class="mr-1 text-gray-400 fa-regular fa-clock"></i>
                    {{ $history->created_at->translatedFormat('d F Y') }}
                    <span class="text-gray-500">pukul {{ $history->created_at->translatedFormat('H:i') }} WIB</span>
                </p>
            </div>
        </div>

        <div class="lg:col-span-2">
            <p class="mb-3 text-xs font-medium tracking-widest text-gray-500 uppercase">Ringkasan Hasil Prediksi AI</p>
            <div class="h-full p-6 bg-white border-4 border-teal-500 shadow-xl sm:p-8 rounded-xl">
                <div class="text-base leading-relaxed text-gray-800 whitespace-pre-line">
                    {!! nl2br(e($history->hasil)) !!}
                </div>
            </div>
        </div>
    </div>

    @if (!empty($history->extracted_job_titles))
        <div class="p-6 mt-10 bg-white border border-teal-100 shadow-md rounded-xl">
            <h3 class="flex items-center gap-2 mb-5 text-xl font-bold text-gray-800">
                <i class="text-teal-500 fa-solid fa-clipboard-list"></i>
                Rekomendasi Jabatan / Job Titles Terdeteksi
            </h3>
            <div class="flex flex-wrap gap-3">
                @foreach ($history->extracted_job_titles as $title)
                    <span class="inline-flex items-center px-4 py-2 text-sm font-semibold text-teal-800 transition-all border border-teal-200 rounded-lg shadow-sm bg-teal-50 hover:bg-teal-100">
                        <i class="mr-2 text-xs text-teal-500 fa-solid fa-medal"></i> {{ $title }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
    {{-- Memastikan Font Awesome 6 (fa-solid) tersedia untuk ikon modern --}}
    {{-- Jika belum ada di layout.admin, Anda mungkin perlu menambahkannya --}}
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
@endsection
