<x-mail::message>
    # Lowongan Berhasil Diunggah!

    Halo **{{ $job->pic_name }}**,

    Terima kasih telah mengunggah lowongan pekerjaan melalui portal Tracer Study TI — Universitas Harkat Negeri.

    ## Detail Lowongan Anda:

    | Info | Detail |
    |------|--------|
    | **Perusahaan** | {{ $job->company_name }} |
    | **Posisi** | {{ $job->position }} |
    | **Kategori** | {{ $job->category }} |
    | **Lokasi** | {{ $job->location ?? '-' }} |

    > **Status: Menunggu Moderasi**
    > Lowongan Anda saat ini sedang dalam proses review oleh tim Admin. Anda akan menerima notifikasi email kembali
    setelah lowongan disetujui atau ditolak.

    Proses moderasi biasanya memakan waktu **1–2 hari kerja**.

    Terima kasih atas kontribusi Anda dalam membantu alumni kami meraih karir terbaik!

    Salam hormat,<br>
    **Tim Tracer Study TI UHN**
</x-mail::message>