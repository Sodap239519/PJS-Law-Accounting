<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->string('intro_title')->nullable()->after('layout');
            $table->string('intro_subtitle')->nullable()->after('intro_title');
            $table->text('vision')->nullable()->after('intro_subtitle');
            $table->text('mission')->nullable()->after('vision');
            // sections: [{ icon, heading, content, image, position }]
            $table->json('sections')->nullable()->after('content');
        });
    }

    public function down(): void
    {
        Schema::table('about_page', function (Blueprint $table) {
            $table->dropColumn(['intro_title', 'intro_subtitle', 'vision', 'mission', 'sections']);
        });
    }
};
