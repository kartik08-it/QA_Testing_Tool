<?php

namespace Database\Seeders;

use App\Models\TestRun;
use Illuminate\Database\Seeder;

class TestRunSeeder extends Seeder
{
    public function run(): void
    {
        $testRuns = [
            [
                'project_id' => 1,
                'name' => 'Sprint 1 - Authentication Testing',
                'description' => 'Complete authentication module testing',
                'environment' => 'Staging',
                'build_version' => 'v1.0.0',
                'created_by' => 1,
                'started_at' => now()->subDays(5),
                'completed_at' => now()->subDays(4),
                'status' => 'completed',
            ],
            [
                'project_id' => 1,
                'name' => 'Sprint 1 - Shopping Cart Testing',
                'description' => 'Cart and checkout flow validation',
                'environment' => 'Staging',
                'build_version' => 'v1.0.0',
                'created_by' => 1,
                'started_at' => now()->subDays(3),
                'completed_at' => now()->subDays(2),
                'status' => 'completed',
            ],
            [
                'project_id' => 1,
                'name' => 'Sprint 2 - Payment Integration',
                'description' => 'Payment gateway integration tests',
                'environment' => 'Staging',
                'build_version' => 'v1.1.0',
                'created_by' => 1,
                'started_at' => now()->subDays(1),
                'status' => 'in_progress',
            ],
            [
                'project_id' => 2,
                'name' => 'Security Audit - Round 1',
                'description' => 'Security and authentication testing',
                'environment' => 'Production',
                'build_version' => 'v2.0.0',
                'created_by' => 2,
                'started_at' => now()->subDays(7),
                'completed_at' => now()->subDays(6),
                'status' => 'completed',
            ],
            [
                'project_id' => 2,
                'name' => 'Transaction Testing',
                'description' => 'Money transfer and bill payment tests',
                'environment' => 'Staging',
                'build_version' => 'v2.1.0',
                'created_by' => 2,
                'started_at' => now()->subDays(2),
                'status' => 'in_progress',
            ],
            [
                'project_id' => 3,
                'name' => 'Post Management Tests',
                'description' => 'Social media posting functionality',
                'environment' => 'Development',
                'build_version' => 'v0.9.0',
                'created_by' => 3,
                'started_at' => now()->subDays(4),
                'completed_at' => now()->subDays(3),
                'status' => 'completed',
            ],
            [
                'project_id' => 4,
                'name' => 'Patient Portal Testing',
                'description' => 'Appointment and records management',
                'environment' => 'Staging',
                'build_version' => 'v1.2.0',
                'created_by' => 4,
                'started_at' => now()->subDays(6),
                'completed_at' => now()->subDays(5),
                'status' => 'completed',
            ],
            [
                'project_id' => 5,
                'name' => 'Inventory Operations',
                'description' => 'Stock management and reporting',
                'environment' => 'Staging',
                'build_version' => 'v1.0.5',
                'created_by' => 5,
                'started_at' => now()->subDay(),
                'status' => 'in_progress',
            ],
            [
                'project_id' => 1,
                'name' => 'Regression Testing - Release 1.2',
                'description' => 'Full regression test suite',
                'environment' => 'Staging',
                'build_version' => 'v1.2.0',
                'created_by' => 1,
                'status' => 'planned',
            ],
            [
                'project_id' => 2,
                'name' => 'Performance Testing',
                'description' => 'Load and performance validation',
                'environment' => 'Performance',
                'build_version' => 'v2.1.0',
                'created_by' => 2,
                'status' => 'planned',
            ],
        ];

        foreach ($testRuns as $runData) {
            TestRun::create($runData);
        }

        $this->command->info('Created 10 test runs');
    }
}
