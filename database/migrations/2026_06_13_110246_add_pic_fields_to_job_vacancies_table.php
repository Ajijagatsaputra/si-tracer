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
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->string('pic_name')->nullable()->after('status');
            $table->string('pic_email')->nullable()->after('pic_name');
            $table->string('pic_phone', 20)->nullable()->after('pic_email');
            $table->string('pic_position')->nullable()->after('pic_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn(['pic_name', 'pic_email', 'pic_phone', 'pic_position']);
        });
    }
};
