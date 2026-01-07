<?php

namespace Database\Seeders;

use App\Models\TestSuite;
use Illuminate\Database\Seeder;

class TestSuiteSeeder extends Seeder
{
    public function run(): void
    {
        $suites = [
            // E-Commerce Platform
            ['project_id' => 1, 'name' => 'Authentication', 'description' => 'User login, registration, and password management'],
            ['project_id' => 1, 'name' => 'Product Management', 'description' => 'Product listing, search, and filtering'],
            ['project_id' => 1, 'name' => 'Shopping Cart', 'description' => 'Cart operations and checkout process'],
            ['project_id' => 1, 'name' => 'Payment Processing', 'description' => 'Payment gateway integration tests'],
            
            // Mobile Banking App
            ['project_id' => 2, 'name' => 'Account Management', 'description' => 'Account operations and balance checks'],
            ['project_id' => 2, 'name' => 'Transactions', 'description' => 'Money transfer and bill payments'],
            ['project_id' => 2, 'name' => 'Security', 'description' => 'Authentication and authorization tests'],
            
            // Social Media Dashboard
            ['project_id' => 3, 'name' => 'Post Management', 'description' => 'Creating and scheduling posts'],
            ['project_id' => 3, 'name' => 'Analytics', 'description' => 'Reporting and insights'],
            
            // Healthcare Portal
            ['project_id' => 4, 'name' => 'Patient Records', 'description' => 'Medical history and patient data'],
            ['project_id' => 4, 'name' => 'Appointments', 'description' => 'Booking and scheduling'],
            
            // Inventory Management
            ['project_id' => 5, 'name' => 'Stock Management', 'description' => 'Inventory tracking and updates'],
            ['project_id' => 5, 'name' => 'Reporting', 'description' => 'Stock reports and analytics'],
            
            // Other projects
            ['project_id' => 6, 'name' => 'Course Management', 'description' => 'Course creation and enrollment'],
            ['project_id' => 7, 'name' => 'Booking Flow', 'description' => 'Room selection and reservation'],
            ['project_id' => 8, 'name' => 'Sales Pipeline', 'description' => 'Lead and opportunity management'],
            ['project_id' => 9, 'name' => 'Order Management', 'description' => 'Food ordering and tracking'],
            ['project_id' => 10, 'name' => 'Task Management', 'description' => 'Project and task operations'],
        ];

        foreach ($suites as $suiteData) {
            TestSuite::create($suiteData);
        }

        $this->command->info('Created 18 test suites');
    }
}
