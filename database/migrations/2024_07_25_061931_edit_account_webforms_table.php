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
        Schema::table('account_webforms', function (Blueprint $table) {
            $table->foreignId('document_type_id')
                ->after('currency_id')
                ->references('id')->on('dropdowns')->cascadeOnDelete();

            $table->dropColumn('national_id');
            $table->dropColumn('nation_id_place_of_issue');
            $table->dropColumn('national_id_release_date');

            $table->dropColumn('residence_id');
            $table->dropColumn('residence_id_place_of_issue');
            $table->dropColumn('residence_id_release_date');

            $table->dropColumn('civil_status_number');
            $table->dropColumn('civil_status_number_please_of_issue');
            $table->dropColumn('civil_status_number_release_date');

            $table->dropColumn('passport_number');
            $table->dropColumn('passport_number_place_of_issue');
            $table->dropColumn('passport_number_release_date');

            $table->dropColumn('nationality_certificate');
            $table->dropColumn('nationality_certificate_place_of_issue');
            $table->dropColumn('nationality_certificate_release_date');

            $table->string('document_number')->after('name_ar');
            $table->string('document_place_of_issue')->after('document_number');
            $table->string('document_release_date')->after('document_place_of_issue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
