<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * เก็บคำแปลแบบ optional ต่อรายการ: { "en": {...}, "zh": {...} }
     * ถ้าไม่มีคำแปล หน้าเว็บจะใช้ Google Translate แปลจากไทยแทน
     */
    public function up(): void
    {
        foreach (['news', 'announcements', 'case_studies', 'services'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->json('translations')->nullable()->after('content');
            });
        }
    }

    public function down(): void
    {
        foreach (['news', 'announcements', 'case_studies', 'services'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropColumn('translations');
            });
        }
    }
};
