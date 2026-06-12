<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Alumni;
use App\Models\JobVacancy;
use App\Models\JobApplication;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic users & roles
        $this->adminUser = User::create([
            'username' => 'testadmin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->alumniUser = User::create([
            'username' => 'testalumni',
            'email' => 'alumni@test.com',
            'password' => bcrypt('password'),
            'role' => 'alumni',
        ]);

        $this->alumni = Alumni::create([
            'id_users' => $this->alumniUser->id,
            'nama_lengkap' => 'Test Alumni ' . rand(),
            'nim' => 12345678,
            'prodi' => 'Teknik Informatika',
            'kelas' => 'A',
            'jalur' => 'Mandiri',
            'tahun_masuk' => '2020',
            'tahun_lulus' => '2024',
            'status_mahasiswa' => 'Alumni',
        ]);

        // Create a vacancy
        $this->jobVacancy = JobVacancy::create([
            'company_name' => 'PT Test Technology',
            'position' => 'Laravel Developer',
            'category' => 'IT Developer',
            'description' => 'Great position.',
            'requirements' => 'Skill in Laravel.',
            'location' => 'Medan',
            'contact_email' => 'hr@test.com',
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function alumni_can_view_job_applications_index()
    {
        $response = $this->actingAs($this->alumniUser)
            ->get(route('alumni.loker.index'));

        $response->assertStatus(200);
        $response->assertViewIs('alumni.loker.index-loker');
    }

    /** @test */
    public function alumni_can_apply_for_approved_job_vacancy()
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->actingAs($this->alumniUser)
            ->postJson(route('alumni.loker.apply', $this->jobVacancy->id), [
                'cover_letter' => 'I am very interested in this job!',
                'phone' => '081234567890',
                'expected_salary' => 'Rp 5.000.000',
                'cv' => $file,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('job_applications', [
            'alumni_id' => $this->alumni->id,
            'job_vacancy_id' => $this->jobVacancy->id,
            'status' => 'applied',
            'cover_letter' => 'I am very interested in this job!',
            'phone' => '081234567890',
            'expected_salary' => 'Rp 5.000.000',
        ]);
    }

    /** @test */
    public function alumni_cannot_apply_twice_to_same_job_vacancy()
    {
        \Illuminate\Support\Facades\Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->create('document.pdf', 100);

        // First application
        JobApplication::create([
            'alumni_id' => $this->alumni->id,
            'job_vacancy_id' => $this->jobVacancy->id,
            'status' => 'applied',
        ]);

        // Second application attempt
        $response = $this->actingAs($this->alumniUser)
            ->postJson(route('alumni.loker.apply', $this->jobVacancy->id), [
                'cover_letter' => 'Another cover letter',
                'phone' => '081234567890',
                'expected_salary' => 'Rp 5.000.000',
                'cv' => $file,
            ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Anda sudah melamar posisi ini.',
        ]);
    }

    /** @test */
    public function admin_can_view_applications_management()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.loker.applications'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.loker.applications');
    }

    /** @test */
    public function admin_can_update_application_status()
    {
        $application = JobApplication::create([
            'alumni_id' => $this->alumni->id,
            'job_vacancy_id' => $this->jobVacancy->id,
            'status' => 'applied',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->putJson(route('admin.loker.application.update-status', $application->id), [
                'status' => 'reviewed',
                'admin_notes' => 'Kualifikasi cocok, dilanjutkan ke interview.',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
            'status' => 'reviewed',
            'admin_notes' => 'Kualifikasi cocok, dilanjutkan ke interview.',
        ]);
    }
}
