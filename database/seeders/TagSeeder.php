<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\TestCase;
use App\Models\Defect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Critical Path', 'color' => '#ef4444'],
            ['name' => 'Regression', 'color' => '#f59e0b'],
            ['name' => 'Smoke Test', 'color' => '#10b981'],
            ['name' => 'UI', 'color' => '#3b82f6'],
            ['name' => 'API', 'color' => '#8b5cf6'],
            ['name' => 'Security', 'color' => '#ec4899'],
            ['name' => 'Performance', 'color' => '#06b6d4'],
            ['name' => 'Mobile', 'color' => '#84cc16'],
            ['name' => 'Integration', 'color' => '#f97316'],
            ['name' => 'Bug', 'color' => '#dc2626'],
        ];

        // Create Tags
        $tagIds = [];
        foreach ($tags as $tag) {
            $created = Tag::create([
                'name' => $tag['name'],
                'slug' => Str::slug($tag['name']),
                'color' => $tag['color'],
                'created_at' => now()->subDays(rand(1, 15)),
                'updated_at' => now()
            ]);
            $tagIds[] = $created->id;
        }

        // Assign random tags to Test Cases
        $testCases = TestCase::all();
        foreach ($testCases as $testCase) {
            $randomTags = collect($tagIds)->random(rand(1, 3)); // each TC gets 1–3 tags
            $testCase->tags()->sync($randomTags);
        }

        // Assign random tags to Defects
        $defects = Defect::all();
        foreach ($defects as $defect) {
            $randomTags = collect($tagIds)->random(rand(1, 2)); // each defect gets 1–2 tags
            $defect->tags()->sync($randomTags);
        }
    }
}
