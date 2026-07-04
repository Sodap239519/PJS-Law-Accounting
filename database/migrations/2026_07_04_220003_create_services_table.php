<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable(); // bootstrap-icon class เช่น "bi bi-briefcase"
            $table->longText('content')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        // cover (optional) เก็บผ่าน spatie medialibrary collection 'cover'
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
