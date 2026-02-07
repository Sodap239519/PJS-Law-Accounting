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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('title_th');
            $table->string('title_en');
            $table->string('slug');
            $table->string('client_name')->nullable();
            $table->text('challenge_th')->nullable();
            $table->text('challenge_en')->nullable();
            $table->text('solution_th')->nullable();
            $table->text('solution_en')->nullable();
            $table->text('result_th')->nullable();
            $table->text('result_en')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable(); // Store multiple images as JSON
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->boolean('is_published')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
