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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Illuminate\Foundation\Auth\User::class)->index()->constrained()->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->string('inner_image')->nullable();
            $table->text('title');
            $table->text('second_title')->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->string('button_url')->nullable();
            $table->string('view');
            $table->string('slug');
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
        Schema::dropIfExists('transfers');
    }
};
