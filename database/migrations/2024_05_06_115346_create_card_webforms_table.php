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
        Schema::create('card_webforms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Card::class)->index()->constrained()->cascadeOnDelete();
            /* single form */
            $table->string('name_on_card')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('date')->nullable();
            $table->string('account_number')->nullable();
            $table->string('full_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();

            /* progress form */
            $table->string('full_name_en')->nullable();
            $table->string('full_name_ar')->nullable();
            $table->string('nationality')->nullable();
            $table->string('place_date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('preferred_communication_method')->nullable();
            $table->string('email')->nullable();

            $table->string('workplace')->nullable();
            $table->string('current_position')->nullable();
            $table->string('work_start_date')->nullable();
            $table->string('monthly_salary')->nullable();
            $table->string('extra_work')->nullable();
            $table->string('other_sources_of_income')->nullable();
            $table->string('card_identity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_webforms');
    }
};
