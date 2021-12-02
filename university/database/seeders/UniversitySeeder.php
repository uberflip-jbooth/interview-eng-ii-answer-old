<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\University;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        University::factory()
            ->count(3000)
            ->hasDomains(2)
            ->hasWebPages(2)
            ->create();
        University::factory()
            ->count(7000)
            ->hasDomains(1)
            ->hasWebPages(1)
            ->create();
    }
}
