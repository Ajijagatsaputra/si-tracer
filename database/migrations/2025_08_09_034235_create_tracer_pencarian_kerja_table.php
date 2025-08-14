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
         Schema::create('tracer_pencarian_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tracer_study_id')->constrained('tracer_studies')->onDelete('cascade');

            $table->json('cara_mencari_kerja')->nullable(); // multiple choice
            $table->string('sumber_informasi')->nullable();
            $table->string('faktor_utama_diterima')->nullable();
            $table->text('hambatan_mencari_kerja')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_pencarian_kerja');
    }
};
