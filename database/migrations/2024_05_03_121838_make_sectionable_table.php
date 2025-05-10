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
        Schema::create('sectional', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Section::class)->index()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('model_id')->nullable()->index();
            $table->string('model_type')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('sectionables');
    }
};
