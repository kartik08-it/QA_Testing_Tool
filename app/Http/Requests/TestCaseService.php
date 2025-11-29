<?php
namespace App\Services;

use App\Models\TestCase;
use App\Models\Project;

class TestCaseService
{
    public function exportToCSV(Project $project)
    {
        $testCases = $project->testCases()->with('testSuite')->get();
        
        $filename = "test-cases-{$project->key}-" . now()->format('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename={$filename}");
        
        // Headers
        fputcsv($handle, [
            'ID', 'Title', 'Suite', 'Description', 'Priority', 
            'Type', 'Status', 'Automated', 'Steps', 'Expected Result'
        ]);
        
        // Data
        foreach ($testCases as $testCase) {
            fputcsv($handle, [
                $testCase->id,
                $testCase->title,
                $testCase->testSuite?->name ?? 'N/A',
                $testCase->description,
                $testCase->priority,
                $testCase->type,
                $testCase->status,
                $testCase->automated,
                json_encode($testCase->steps),
                $testCase->expected_result,
            ]);
        }
        
        fclose($handle);
        exit;
    }

    public function importFromCSV(Project $project, $file)
    {
        $handle = fopen($file->getPathname(), 'r');
        $header = fgetcsv($handle);
        
        $imported = 0;
        while (($data = fgetcsv($handle)) !== false) {
            TestCase::create([
                'project_id' => $project->id,
                'title' => $data[1],
                'description' => $data[3],
                'priority' => $data[4],
                'type' => $data[5],
                'status' => $data[6],
                'automated' => $data[7],
                'steps' => json_decode($data[8], true),
                'expected_result' => $data[9],
                'created_by' => auth()->id(),
            ]);
            $imported++;
        }
        
        fclose($handle);
        return $imported;
    }
}