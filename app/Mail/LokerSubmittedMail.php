<?php

namespace App\Mail;

use App\Models\JobVacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LokerSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public JobVacancy $job;

    public function __construct(JobVacancy $job)
    {
        $this->job = $job;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Lowongan Berhasil Diunggah — Menunggu Moderasi Admin',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.loker.submitted',
            with: [
                'job' => $this->job,
            ],
        );
    }
}
