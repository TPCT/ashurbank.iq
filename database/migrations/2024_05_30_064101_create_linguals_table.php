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
        Schema::create('lingual', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Language::class)->index()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('model_id')->nullable()->index();
            $table->string('model_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lingual');
    }
};
