<x-mail::message>
    # Lowongan Tidak Disetujui

    Halo **{{ $job->pic_name }}**,

    Mohon maaf, lowongan pekerjaan yang Anda unggah **tidak disetujui** oleh Admin setelah proses moderasi.

    ## Detail Lowongan:

    | Info | Detail |
    |------|--------|
    | **Perusahaan** | {{ $job->company_name }} |
    | **Posisi** | {{ $job->position }} |
    | **Kategori** | {{ $job->category }} |
    | **Status** | ❌ Ditolak |

    > Hal ini bisa terjadi karena beberapa alasan, seperti informasi yang kurang lengkap, konten yang tidak sesuai, atau
    duplikasi data. Silakan perbaiki dan unggah ulang lowongan Anda.

    <x-mail::button :url="url('/mitra/loker/buat')" color="primary">
        Unggah Ulang Lowongan
    </x-mail::button>

    Jika Anda memiliki pertanyaan, silakan hubungi Admin melalui portal kami.

    Salam hormat,<br>
    **Tim Tracer Study TI UHN**
</x-mail::message>