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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title_th');
            $table->string('title_en');
            $table->text('description_th')->nullable();
            $table->text('description_en')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->integer('file_size'); // in bytes
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->integer('downloads')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
