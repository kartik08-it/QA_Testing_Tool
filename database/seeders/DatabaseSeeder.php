<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        UserSeeder::class,
        ProjectSeeder::class,
        // ProjectMemberSeeder::class, // if exists
        TestSuiteSeeder::class,
        TestCaseSeeder::class,
        TestRunSeeder::class,
        TestExecutionSeeder::class,
        DefectSeeder::class,
        TagSeeder::class,
    ]);
}

}
