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
        Schema::create('history_prediksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAlumni');
            $table->foreign('idAlumni')->references('id')->on('alumni')->onDelete('cascade');
            $table->longText('hasil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_prediksi');
    }
};
