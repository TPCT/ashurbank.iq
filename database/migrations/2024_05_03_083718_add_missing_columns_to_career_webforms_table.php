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
        Schema::table('career_webforms', function (Blueprint $table) {
            $table->dropColumn('cover_letter');
            $table->dropColumn('phone');
            $table->string('place_date_of_birth');
            $table->string('gender');
            $table->string('phone_number');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('qualifications');
            $table->string('specialization');
            $table->string('scientific_expertise');
            $table->string('years_of_experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_webforms', function (Blueprint $table) {
            //
        });
    }
};
