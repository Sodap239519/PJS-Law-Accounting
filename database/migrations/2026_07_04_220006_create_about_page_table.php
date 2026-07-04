<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_page', function (Blueprint $table) {
            $table->id();
            $table->string('layout')->default('layout1'); // layout1 / layout2 / layout3
            $table->longText('content')->nullable();
            $table->timestamps();
        });
        // รูปประกอบเก็บผ่าน spatie medialibrary collection 'gallery' (singleton)
    }

    public function down(): void
    {
        Schema::dropIfExists('about_page');
    }
};
