<?php

namespace Database\Seeders;

use App\Models\JobVacancy;
use Illuminate\Database\Seeder;

class DummyJobVacancySeeder extends Seeder
{
    public function run(): void
    {
        $vacancies = [
            ['company_name' => 'Arunika Digital Nusantara', 'position' => 'Frontend Developer', 'category' => 'IT Developer (Frontend/Backend/Fullstack)', 'location' => 'Jakarta / Hybrid', 'salary_range' => 'Rp6.000.000 - Rp9.000.000', 'contact_email' => 'karier@arunika.example', 'contact_link' => 'https://example.com/karier/arunika-frontend', 'pic_name' => 'Nadia Pratama', 'pic_email' => 'nadia@arunika.example', 'pic_phone' => '081200000101', 'pic_position' => 'Talent Acquisition'],
            ['company_name' => 'Kreasi Data Indonesia', 'position' => 'Data Analyst', 'category' => 'Data & Analitik', 'location' => 'Bandung / Hybrid', 'salary_range' => 'Rp5.500.000 - Rp8.000.000', 'contact_email' => 'rekrutmen@kreasidata.example', 'contact_link' => 'https://example.com/karier/kreasidata-analyst', 'pic_name' => 'Rizky Mahendra', 'pic_email' => 'rizky@kreasidata.example', 'pic_phone' => '081200000102', 'pic_position' => 'Recruiter'],
            ['company_name' => 'Sagara Teknologi', 'position' => 'Backend Developer', 'category' => 'IT Developer (Frontend/Backend/Fullstack)', 'location' => 'Yogyakarta / Remote', 'salary_range' => 'Rp7.000.000 - Rp11.000.000', 'contact_email' => 'people@sagara.example', 'contact_link' => 'https://example.com/karier/sagara-backend', 'pic_name' => 'Dewi Lestari', 'pic_email' => 'dewi@sagara.example', 'pic_phone' => '081200000103', 'pic_position' => 'People Partner'],
            ['company_name' => 'Langit Kreatif Studio', 'position' => 'Digital Marketing Specialist', 'category' => 'Pemasaran Digital', 'location' => 'Semarang / Hybrid', 'salary_range' => 'Rp4.500.000 - Rp7.000.000', 'contact_email' => 'talent@langitkreatif.example', 'contact_link' => 'https://example.com/karier/langit-marketing', 'pic_name' => 'Fajar Wibowo', 'pic_email' => 'fajar@langitkreatif.example', 'pic_phone' => '081200000104', 'pic_position' => 'HR Generalist'],
            ['company_name' => 'Cakrawala Solusi Bisnis', 'position' => 'UI/UX Designer', 'category' => 'Desain Produk & UI/UX', 'location' => 'Surabaya / Hybrid', 'salary_range' => 'Rp5.000.000 - Rp8.000.000', 'contact_email' => 'jobs@cakrawala.example', 'contact_link' => 'https://example.com/karier/cakrawala-uiux', 'pic_name' => 'Alya Putri', 'pic_email' => 'alya@cakrawala.example', 'pic_phone' => '081200000105', 'pic_position' => 'People Operations'],
            ['company_name' => 'Nusa Cloud Services', 'position' => 'Cloud Support Engineer', 'category' => 'Infrastruktur & Cloud', 'location' => 'Jakarta / On-site', 'salary_range' => 'Rp6.000.000 - Rp9.500.000', 'contact_email' => 'career@nusacloud.example', 'contact_link' => 'https://example.com/karier/nusacloud-support', 'pic_name' => 'Bagas Santoso', 'pic_email' => 'bagas@nusacloud.example', 'pic_phone' => '081200000106', 'pic_position' => 'Recruitment Specialist'],
            ['company_name' => 'Fintek Aman Sentosa', 'position' => 'QA Engineer', 'category' => 'Quality Assurance & Testing', 'location' => 'Tangerang / Hybrid', 'salary_range' => 'Rp5.500.000 - Rp8.500.000', 'contact_email' => 'hr@fintekaman.example', 'contact_link' => 'https://example.com/karier/fintek-qa', 'pic_name' => 'Citra Anggraini', 'pic_email' => 'citra@fintekaman.example', 'pic_phone' => '081200000107', 'pic_position' => 'Talent Partner'],
            ['company_name' => 'Lintas Niaga Digital', 'position' => 'Product Operations Associate', 'category' => 'Produk & Operasional', 'location' => 'Depok / Hybrid', 'salary_range' => 'Rp5.000.000 - Rp7.500.000', 'contact_email' => 'people@lintasniaga.example', 'contact_link' => 'https://example.com/karier/lintas-product-ops', 'pic_name' => 'Andi Kurniawan', 'pic_email' => 'andi@lintasniaga.example', 'pic_phone' => '081200000108', 'pic_position' => 'HR Officer'],
            ['company_name' => 'Bumi Hijau Teknologi', 'position' => 'IT Support Specialist', 'category' => 'Dukungan TI', 'location' => 'Tegal / On-site', 'salary_range' => 'Rp4.000.000 - Rp6.000.000', 'contact_email' => 'rekrut@bumihijau.example', 'contact_link' => 'https://example.com/karier/bumihijau-it-support', 'pic_name' => 'Sinta Maharani', 'pic_email' => 'sinta@bumihijau.example', 'pic_phone' => '081200000109', 'pic_position' => 'HR Staff'],
            ['company_name' => 'Awan Cerdas Indonesia', 'position' => 'Machine Learning Associate', 'category' => 'Data & Kecerdasan Buatan', 'location' => 'Remote Indonesia', 'salary_range' => 'Rp7.000.000 - Rp12.000.000', 'contact_email' => 'talent@awancerdas.example', 'contact_link' => 'https://example.com/karier/awancerdas-ml', 'pic_name' => 'Yoga Prasetyo', 'pic_email' => 'yoga@awancerdas.example', 'pic_phone' => '081200000110', 'pic_position' => 'Technical Recruiter'],
        ];

        foreach ($vacancies as $vacancy) {
            JobVacancy::updateOrCreate(
                ['company_name' => $vacancy['company_name'], 'position' => $vacancy['position']],
                array_merge($vacancy, [
                    'description' => 'Lowongan simulasi untuk kebutuhan demonstrasi portal Bursa Kerja Tracer Study. Informasi ini bukan lowongan nyata dan tidak menerima lamaran sungguhan.',
                    'requirements' => 'Data simulasi. Persyaratan berikut hanya contoh: komunikasi yang baik, mampu bekerja dalam tim, dan memiliki minat pada bidang terkait.',
                    'status' => 'approved',
                ])
            );
        }
    }
}
