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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('alumni')->cascadeOnDelete();
            $table->foreignId('job_vacancy_id')->constrained('job_vacancies')->cascadeOnDelete();
            $table->enum('status', ['applied', 'reviewed', 'accepted', 'rejected'])->default('applied');
            $table->text('cover_letter')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            // 1 alumni hanya bisa apply 1x per loker
            $table->unique(['alumni_id', 'job_vacancy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
