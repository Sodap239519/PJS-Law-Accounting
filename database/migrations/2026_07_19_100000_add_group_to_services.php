<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('services') && ! Schema::hasColumn('services', 'group')) {
            Schema::table('services', function (Blueprint $t) {
                $t->string('group')->nullable()->after('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'group')) {
            Schema::table('services', function (Blueprint $t) {
                $t->dropColumn('group');
            });
        }
    }
};
