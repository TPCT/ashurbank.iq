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
        Schema::create('financial_statements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Illuminate\Foundation\Auth\User::class)->index()->constrained()->cascadeOnDelete();
            $table->text('title')->nullable(false);
            $table->text('link')->nullable(false);
            $table->boolean('status')->default(1);
            $table->unsignedInteger('weight')->default(0);
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_statements');
    }
};
