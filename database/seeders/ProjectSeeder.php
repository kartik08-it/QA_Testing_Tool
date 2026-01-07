<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'name' => 'E-Commerce Platform',
                'key' => 'EsCP',
                'description' => 'Online shopping platform with payment integration and user management.',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Mobile Banking App',
                'key' => 'MBA',
                'description' => 'Secure mobile banking application with transactions and account management.',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Social Media Dashboard',
                'key' => 'SMD',
                'description' => 'Social media management tool with analytics and scheduling features.',
                'status' => 'active',
                'created_by' => 2,
            ],
            [
                'name' => 'Healthcare Portal',
                'key' => 'HCP',
                'description' => 'Patient management system with appointment scheduling and medical records.',
                'status' => 'active',
                'created_by' => 2,
            ],
            [
                'name' => 'Inventory Management System',
                'key' => 'IMS',
                'description' => 'Warehouse and inventory tracking system with real-time updates.',
                'status' => 'active',
                'created_by' => 3,
            ],
            [
                'name' => 'Learning Management System',
                'key' => 'LMS',
                'description' => 'Online education platform with courses, quizzes, and certifications.',
                'status' => 'active',
                'created_by' => 3,
            ],
            [
                'name' => 'Hotel Booking System',
                'key' => 'HBS',
                'description' => 'Hotel reservation platform with room management and payment processing.',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'CRM Application',
                'key' => 'CRM',
                'description' => 'Customer relationship management with sales pipeline and analytics.',
                'status' => 'active',
                'created_by' => 2,
            ],
            [
                'name' => 'Food Delivery App',
                'key' => 'FDA',
                'description' => 'Restaurant ordering and delivery tracking application.',
                'status' => 'active',
                'created_by' => 1,
            ],
            [
                'name' => 'Project Management Tool',
                'key' => 'PMT',
                'description' => 'Task and project tracking with team collaboration features.',
                'status' => 'active',
                'created_by' => 3,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        $this->command->info('Created 10 projects');
    }
}
