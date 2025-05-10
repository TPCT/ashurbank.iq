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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable(false);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('promote_to_homepage')->default(false);
            $table->boolean('is_video')->default(false);
            $table->text('video_url')->nullable();

            $table->foreignIdFor(\App\Models\User::class)->index()->constrained()->cascadeOnDelete();
            $table->timestamp('published_at');
            $table->boolean('status')->default(false);
            $table->unsignedInteger('weight')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
