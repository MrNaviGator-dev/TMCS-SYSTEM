<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate report generation
$reportType = 'all_members';
$format = 'pdf';
$role = null;
$fromDate = null;
$toDate = null;
$includePaymentHistory = false;
$includeContactDetails = true;

echo "=== Testing Member Report Generation ===\n\n";

// Build query
$query = App\Models\User::query();

// Apply report type specific filters
switch ($reportType) {
    case 'all_members':
        // No additional filters - get all members
        break;
}

// Fetch complete member data including phone_number and home_diocese
$members = $query->select('id', 'name', 'email', 'role', 'status', 'phone_number', 'home_diocese', 'created_at', 'updated_at')
                  ->orderBy('created_at', 'desc')
                  ->get();

echo "Members loaded: " . $members->count() . "\n\n";

foreach ($members as $member) {
    echo "Name: " . $member->name . "\n";
    echo "Phone: " . ($member->phone_number ?? 'NULL') . "\n";
    echo "Diocese: " . ($member->home_diocese ?? 'NULL') . "\n";
    echo "Status: '" . $member->status . "'\n";
    echo "---\n";
}

?>
