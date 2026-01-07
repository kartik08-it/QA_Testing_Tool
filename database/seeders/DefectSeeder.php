<?php

namespace Database\Seeders;

use App\Models\Defect;
use Illuminate\Database\Seeder;

class DefectSeeder extends Seeder
{
    public function run(): void
    {
        $defects = [
            [
                'project_id' => 1,
                'title' => 'Cart total not updating after quantity change',
                'description' => 'When user updates product quantity in cart, the total price does not recalculate automatically. User needs to refresh page to see updated total.',
                'steps_to_reproduce' => "1. Add product to cart\n2. Navigate to cart page\n3. Change quantity using +/- buttons\n4. Observe total price remains unchanged",
                'severity' => 'high',
                'priority' => 'high',
                'status' => 'open',
                'environment' => 'Staging - Chrome 120, Windows 11',
                'reported_by' => 1,
                'assigned_to' => 2,
            ],
            [
                'project_id' => 1,
                'title' => 'Payment confirmation email not sent',
                'description' => 'After successful payment, order confirmation email is not being sent to customer',
                'steps_to_reproduce' => "1. Complete checkout process\n2. Make successful payment\n3. Check email inbox\n4. No confirmation email received",
                'severity' => 'critical',
                'priority' => 'critical',
                'status' => 'in_progress',
                'environment' => 'Production',
                'reported_by' => 1,
                'assigned_to' => 2,
            ],
            [
                'project_id' => 1,
                'title' => 'Product images not loading on mobile',
                'description' => 'Product detail page images fail to load on mobile devices',
                'steps_to_reproduce' => "1. Open site on mobile browser\n2. Navigate to any product\n3. Images show broken image icon",
                'severity' => 'medium',
                'priority' => 'high',
                'status' => 'resolved',
                'environment' => 'Production - iOS Safari',
                'reported_by' => 3,
                'assigned_to' => 2,
            ],
            [
                'project_id' => 1,
                'title' => 'Search returns irrelevant results',
                'description' => 'Product search showing products that do not match search criteria',
                'steps_to_reproduce' => "1. Enter 'laptop' in search\n2. Results include phones and accessories\n3. Search relevance is poor",
                'severity' => 'medium',
                'priority' => 'medium',
                'status' => 'open',
                'environment' => 'Staging',
                'reported_by' => 1,
                'assigned_to' => null,
            ],
            [
                'project_id' => 2,
                'title' => 'Account balance shows incorrect amount',
                'description' => 'After recent transaction, account balance is not reflecting correct amount',
                'steps_to_reproduce' => "1. Login to account\n2. Make a transfer\n3. Check balance\n4. Balance shows old amount",
                'severity' => 'critical',
                'priority' => 'critical',
                'status' => 'resolved',
                'environment' => 'Production - Android App v2.0.0',
                'reported_by' => 2,
                'assigned_to' => 3,
            ],
            [
                'project_id' => 2,
                'title' => 'Session timeout too aggressive',
                'description' => 'Users being logged out after 2 minutes of inactivity',
                'steps_to_reproduce' => "1. Login to app\n2. Wait 2 minutes without interaction\n3. Try to make transaction\n4. User is logged out",
                'severity' => 'high',
                'priority' => 'medium',
                'status' => 'in_progress',
                'environment' => 'Production',
                'reported_by' => 4,
                'assigned_to' => 3,
            ],
            [
                'project_id' => 3,
                'title' => 'Scheduled posts not publishing at set time',
                'description' => 'Posts scheduled for specific time are not being published automatically',
                'steps_to_reproduce' => "1. Create new post\n2. Schedule for future time\n3. Wait for scheduled time\n4. Post not published",
                'severity' => 'high',
                'priority' => 'high',
                'status' => 'open',
                'environment' => 'Production',
                'reported_by' => 3,
                'assigned_to' => null,
            ],
            [
                'project_id' => 3,
                'title' => 'Analytics dashboard shows data from wrong date range',
                'description' => 'When selecting custom date range, dashboard shows data from different period',
                'steps_to_reproduce' => "1. Navigate to analytics\n2. Select custom date range\n3. Click Apply\n4. Data shown is from different dates",
                'severity' => 'medium',
                'priority' => 'low',
                'status' => 'open',
                'environment' => 'Staging',
                'reported_by' => 5,
                'assigned_to' => null,
            ],
            [
                'project_id' => 4,
                'title' => 'Patient records not saving medical history',
                'description' => 'When updating patient medical history, changes are not persisted',
                'steps_to_reproduce' => "1. Open patient record\n2. Add medical history entry\n3. Click Save\n4. Refresh page\n5. Entry is missing",
                'severity' => 'critical',
                'priority' => 'critical',
                'status' => 'in_progress',
                'environment' => 'Production',
                'reported_by' => 4,
                'assigned_to' => 5,
            ],
            [
                'project_id' => 5,
                'title' => 'Stock report export generates corrupt file',
                'description' => 'Exported stock reports cannot be opened in Excel',
                'steps_to_reproduce' => "1. Navigate to reports\n2. Select stock report\n3. Click Export to Excel\n4. Downloaded file cannot be opened",
                'severity' => 'high',
                'priority' => 'medium',
                'status' => 'open',
                'environment' => 'Production',
                'reported_by' => 5,
                'assigned_to' => null,
            ],
            [
                'project_id' => 1,
                'title' => 'Login page layout broken on iPad',
                'description' => 'Login form elements overlapping on iPad screen sizes',
                'steps_to_reproduce' => "1. Open site on iPad\n2. Navigate to login page\n3. Form fields overlap",
                'severity' => 'low',
                'priority' => 'low',
                'status' => 'closed',
                'environment' => 'Production - iPad Safari',
                'reported_by' => 3,
                'assigned_to' => 2,
            ],
            [
                'project_id' => 2,
                'title' => 'Bill payment fails for certain providers',
                'description' => 'Payment to specific utility companies fails with timeout error',
                'steps_to_reproduce' => "1. Navigate to bill payment\n2. Select specific provider\n3. Enter amount and confirm\n4. Transaction times out",
                'severity' => 'high',
                'priority' => 'high',
                'status' => 'reopened',
                'environment' => 'Production',
                'reported_by' => 2,
                'assigned_to' => 3,
            ],
        ];

        foreach ($defects as $defect) {
            Defect::create(array_merge($defect, [
                'created_at' => now()->subDays(rand(1, 20)),
                'updated_at' => now()
            ]));
        }
    }
}
