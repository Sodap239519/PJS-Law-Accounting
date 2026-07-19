<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            ContactChannelSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            TeamMemberSeeder::class,
            NewsSeeder::class,
            NewsPr1Seeder::class,
            CaseStudySeeder::class,
            DailyStatSeeder::class,
        ]);
    }
}
