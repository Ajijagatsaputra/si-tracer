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
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('requirements')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->string('contact_email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->text('requirements')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
            $table->string('contact_email')->nullable(false)->change();
        });
    }
};
