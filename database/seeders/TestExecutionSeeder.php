<?php

namespace Database\Seeders;

use App\Models\TestExecution;
use App\Models\TestRun;
use App\Models\TestCase;
use Illuminate\Database\Seeder;

class TestExecutionSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * -----------------------------------------
         * Test Run 1 - All cases passed
         * -----------------------------------------
         */
        $testRun1 = TestRun::find(1);
        $testCases1 = TestCase::where('project_id', 1)
            ->where('test_suite_id', 1)
            ->get();
        
        foreach ($testCases1 as $index => $testCase) {
            TestExecution::create([
                'test_run_id' => $testRun1->id,
                'test_case_id' => $testCase->id,
                'executed_by' => 1,
                'status' => 'passed',
                'actual_result' => 'Test executed successfully as expected',
                'comments' => 'All steps completed without issues',
                'execution_time' => rand(3, 10),
                'executed_at' => now()->subDays(4)->addHours($index),
            ]);
        }

        /**
         * -----------------------------------------
         * Test Run 2 - Mixed results
         * -----------------------------------------
         */
        $testRun2 = TestRun::find(2);
        $testCases2 = TestCase::where('project_id', 1)
            ->where('test_suite_id', 3)
            ->get();
        
        $statuses = ['passed', 'passed', 'failed', 'passed'];

        foreach ($testCases2 as $index => $testCase) {
            $status = $statuses[$index % count($statuses)];

            TestExecution::create([
                'test_run_id' => $testRun2->id,
                'test_case_id' => $testCase->id,
                'executed_by' => 1,
                'status' => $status,
                'actual_result' => $status === 'passed'
                    ? 'Test passed as expected'
                    : 'Cart quantity not updating correctly',
                'comments' => $status === 'failed'
                    ? 'Issue with cart total calculation'
                    : 'Working as expected',
                'execution_time' => rand(4, 12),
                'executed_at' => now()->subDays(2)->addHours($index),
            ]);
        }

        /**
         * -----------------------------------------
         * Test Run 3 - In progress (half pending)
         * -----------------------------------------
         */
        $testRun3 = TestRun::find(3);
        $testCases3 = TestCase::where('project_id', 1)
            ->where('test_suite_id', 4)
            ->get();
        
        foreach ($testCases3 as $index => $testCase) {
            $status = $index < ($testCases3->count() / 2)
                ? 'passed'
                : 'pending';

            TestExecution::create([
                'test_run_id' => $testRun3->id,
                'test_case_id' => $testCase->id,
                'executed_by' => $status === 'pending' ? null : 1,
                'status' => $status,
                'actual_result' => $status === 'pending'
                    ? null
                    : 'Steps executed successfully',
                'comments' => $status === 'pending'
                    ? 'Awaiting execution'
                    : 'Test completed',
                'execution_time' => $status === 'pending' ? null : rand(5, 15),
                'executed_at' => $status === 'pending'
                    ? null
                    : now()->subDay()->addHours($index),
            ]);
        }
    }
}
