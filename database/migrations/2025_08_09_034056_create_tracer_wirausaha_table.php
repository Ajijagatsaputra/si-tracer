<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tracer_wirausaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            $table->string('nama_usaha')->nullable();
            $table->enum('posisi_usaha', ['founder', 'co-founder', 'staff', 'freelance'])->nullable();
            $table->enum('tingkat_usaha_level', [
                'lokal', 'nasional', 'internasional'
            ])->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->decimal('pendapatan_usaha', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_wirausaha');
    }
};
