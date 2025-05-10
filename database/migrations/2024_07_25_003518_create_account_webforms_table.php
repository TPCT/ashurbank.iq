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
        Schema::create('account_webforms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Account::class)->index()->constrained()->cascadeOnDelete();
//            $table->foreignIdFor(\App\Models\Branch::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Currency::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignId('martial_status_id')->references('id')->on('dropdowns')->cascadeOnDelete();
            $table->foreignId('scientific_status_id')->references('id')->on('dropdowns')->cascadeOnDelete();
            $table->foreignId('accommodation_type_id')->references('id')->on('dropdowns')->cascadeOnDelete();
            $table->foreignId('labor_sector_id')->references('id')->on('dropdowns')->cascadeOnDelete();

            $table->string('name_ar');
            $table->string('name_en');

            $table->string('national_id');
            $table->string('nation_id_place_of_issue');
            $table->string('national_id_release_date');

            $table->string('residence_id');
            $table->string('residence_id_place_of_issue');
            $table->string('residence_id_release_date');

            $table->string('civil_status_number');
            $table->string('civil_status_number_please_of_issue');
            $table->string('civil_status_number_release_date');

            $table->string('passport_number');
            $table->string('passport_number_place_of_issue');
            $table->string('passport_number_release_date');

            $table->string('nationality_certificate');
            $table->string('nationality_certificate_place_of_issue');
            $table->string('nationality_certificate_release_date');

            $table->string('mother_name');
            $table->string('partner_name');

            $table->string('governorate');
            $table->string('area');
            $table->string('place');

            $table->string('alley');
            $table->string('building_number');
            $table->string('nearest_point');
            $table->string('phone_number_1');
            $table->string('phone_number_2');
            $table->string('email');

            $table->string('foreign_country')->nullable();
            $table->string('foreign_city')->nullable();
            $table->string('foreign_region')->nullable();
            $table->string('foreign_street_name')->nullable();
            $table->string('foreign_building_number')->nullable();
            $table->string('foreign_nearest_point')->nullable();
            $table->string('foreign_phone_number')->nullable();
            $table->string('foreign_mailbox')->nullable();
            $table->string('foreign_postal_code')->nullable();

            $table->string('company_name');
            $table->string('institution_activity')->nullable();
            $table->string('institution_nationality')->nullable();
            $table->string('occupation')->nullable();
            $table->string('job_title')->nullable();

            $table->string('document');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_webforms');
    }
};
