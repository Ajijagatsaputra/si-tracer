<x-mail::message>
    # Lowongan Anda Telah Disetujui! 🎉

    Halo **{{ $job->pic_name }}**,

    Kabar baik! Lowongan pekerjaan yang Anda unggah telah **disetujui** oleh Admin dan sekarang sudah **tayang** di
    portal Bursa Kerja Tracer Study TI UHN.

    ## Detail Lowongan:

    | Info | Detail |
    |------|--------|
    | **Perusahaan** | {{ $job->company_name }} |
    | **Posisi** | {{ $job->position }} |
    | **Kategori** | {{ $job->category }} |
    | **Lokasi** | {{ $job->location ?? '-' }} |
    | **Status** | ✅ Approved — Tayang |

    Lowongan Anda sekarang dapat dilihat dan dilamar oleh alumni Teknik Informatika Universitas Harkat Negeri.

    <x-mail::button :url="url('/')" color="success">
        Lihat Portal Bursa Kerja
    </x-mail::button>

    Terima kasih atas kolaborasi Anda!

    Salam hormat,<br>
    **Tim Tracer Study TI UHN**
</x-mail::message>