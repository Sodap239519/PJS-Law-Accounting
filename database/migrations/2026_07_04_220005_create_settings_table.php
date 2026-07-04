<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general'); // general, site, contact, ...
            $table->timestamps();
        });
        // logo / favicon เก็บ path ของไฟล์ไว้ในคอลัมน์ value
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
