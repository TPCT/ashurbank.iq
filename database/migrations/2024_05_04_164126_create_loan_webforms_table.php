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
        Schema::create('loan_webforms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Loan::class)->index()->constrained()->cascadeOnDelete();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('nationality');
            $table->string('place_date_of_birth');
            $table->string('address');
            $table->string('phone_number');
            $table->string('preferred_method_of_communication');
            $table->string('email');
            $table->string('workplace');
            $table->string('current_position');
            $table->string('work_start_date');
            $table->string('monthly_salary');
            $table->string('extra_work');
            $table->string('other_sources_of_income');
            $table->string('loan_amount');
            $table->string('payment_period');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_webforms');
    }
};
