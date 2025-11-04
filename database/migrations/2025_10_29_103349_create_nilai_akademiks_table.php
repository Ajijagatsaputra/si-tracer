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
        Schema::create('nilai_akademik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAlumni');
            $table->foreign('idAlumni')->references('id')->on('alumni')->onDelete('cascade');
            $table->Text('mataKuliah');
            $table->Integer('sks');
            $table->string('grade', 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_akademik');
    }
};
