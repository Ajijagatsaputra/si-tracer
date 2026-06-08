<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_vacancies', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('company_name');
            $blueprint->string('logo_path')->nullable();
            $blueprint->string('position');
            $blueprint->string('category');
            $blueprint->text('description');
            $blueprint->text('requirements');
            $blueprint->string('location');
            $blueprint->string('salary_range')->nullable();
            $blueprint->string('contact_email');
            $blueprint->string('contact_link')->nullable();
            $blueprint->string('status')->default('pending'); // pending, approved, rejected
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
