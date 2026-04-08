<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Payment;

class ReportController extends Controller
{
    /**
     * Generate Payment Report
     */
    public function generatePaymentReport(Request $request)
    {
        try {
            $reportType = $request->input('paymentReportType');
            $format = $request->input('paymentReportFormat');
            $paymentType = $request->input('paymentTypeFilter');
            $status = $request->input('paymentStatusFilter');
            $memberId = $request->input('memberSelect');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            // Debug logging
            Log::info('Payment report request:', [
                'reportType' => $reportType,
                'format' => $format,
                'paymentType' => $paymentType,
                'status' => $status,
                'memberId' => $memberId,
                'fromDate' => $fromDate,
                'toDate' => $toDate
            ]);

            // Validate format
            if (!$format || !in_array($format, ['pdf', 'excel', 'csv'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid format specified. Please select PDF, Excel, or CSV.'
                ]);
            }

            // Build query
            $query = Payment::with('user');
            
            // Apply filters
            if ($paymentType) {
                $query->where('payment_type', $paymentType);
            }
            
            if ($status) {
                $query->where('status', $status);
            }
            
            if ($memberId) {
                $query->where('user_id', $memberId);
            }
            
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }
            
            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }
            
            // Apply report type specific filters
            switch ($reportType) {
                case 'pending_payments':
                    $query->where('status', 'pending');
                    break;
                case 'approved_payments':
                    $query->where('status', 'approved');
                    break;
            }
            
            $payments = $query->orderBy('user_id')->orderBy('created_at', 'desc')->get();
            
            // Generate report based on format
            if ($format === 'pdf') {
                return $this->generatePaymentPDF($payments, $reportType);
            } elseif ($format === 'excel') {
                return $this->generatePaymentExcel($payments, $reportType);
            } elseif ($format === 'csv') {
                return $this->generatePaymentCSV($payments, $reportType);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid format specified'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error generating payment report: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Member Report
     */
    public function generateMemberReport(Request $request)
    {
        try {
            $reportType = $request->input('memberReportType');
            $format = $request->input('memberReportFormat');
            $role = $request->input('memberRoleFilter');
            $fromDate = $request->input('memberFromDate');
            $toDate = $request->input('memberToDate');
            $includePaymentHistory = $request->input('includePaymentHistory');
            $includeContactDetails = $request->input('includeContactDetails');

            // Debug logging
            Log::info('Member report request:', [
                'reportType' => $reportType,
                'format' => $format,
                'role' => $role,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'includePaymentHistory' => $includePaymentHistory,
                'includeContactDetails' => $includeContactDetails
            ]);

            // Validate format
            if (!$format || !in_array($format, ['pdf', 'excel', 'csv'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid format specified. Please select PDF, Excel, or CSV.'
                ]);
            }

// Build query with complete member data (excluding user ID 16)
            $query = User::where('id', '!=', 16);
            
            // Apply filters
            if ($role) {
                $query->where('role', $role);
            }
            
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }
            
            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }
            
            // Apply report type specific filters
            switch ($reportType) {
                case 'all_members':
                    // No additional filters - get all members
                    break;
                case 'inactive_members':
                    $query->where('membership_status', '!=', 'Active');
                    break;
                case 'by_role':
                    // Role filter already applied above
                    break;
            }
            
            // Fetch complete member data including phone_number and home_diocese
            $members = $query->select('id', 'name', 'email', 'role', 'membership_status', 'phone_number', 'home_diocese', 'created_at', 'updated_at')
                              ->orderByRaw("CASE WHEN role = 'admin' THEN 1 ELSE 2 END")
                              ->orderBy('id', 'desc')
                              ->orderBy('created_at', 'desc')
                              ->get();
            
            // Debug: Check if phone numbers are loaded
            \Log::info('Members loaded with phone numbers:', [
                'total_members' => $members->count(),
                'first_member_phone' => $members->first()->phone_number ?? 'NULL',
                'first_member_diocese' => $members->first()->home_diocese ?? 'NULL'
            ]);
            
            // Load payment history if requested
            if ($includePaymentHistory) {
                $members->load(['payments' => function($query) {
                    $query->orderBy('created_at', 'desc');
                }]);
            }
            
            // Generate report based on format
            if ($format === 'pdf') {
                return $this->generateMemberPDF($members, $reportType, $includePaymentHistory, $includeContactDetails);
            } elseif ($format === 'excel') {
                return $this->generateMemberExcel($members, $reportType, $includePaymentHistory, $includeContactDetails);
            } elseif ($format === 'csv') {
                return $this->generateMemberCSV($members, $reportType, $includePaymentHistory, $includeContactDetails);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid format specified'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error generating member report: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate General Report
     */
    public function generateGeneralReport(Request $request)
    {
        try {
            $reportType = $request->input('generalReportType');
            $format = $request->input('generalReportFormat');
            $fromDate = $request->input('generalFromDate');
            $toDate = $request->input('generalToDate');
            $includeCharts = $request->input('includeCharts');
            $includeSummary = $request->input('includeSummary');
            $paymentType = $request->input('generalPaymentTypeFilter');
            $specificDate = $request->input('generalSpecificDate');

            // Debug logging
            Log::info('General report request:', [
                'reportType' => $reportType,
                'format' => $format,
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'includeCharts' => $includeCharts,
                'includeSummary' => $includeSummary,
                'paymentType' => $paymentType,
                'specificDate' => $specificDate
            ]);

            // Validate format
            if (!$format || !in_array($format, ['pdf', 'excel', 'csv'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid format specified. Please select PDF, Excel, or CSV.'
                ]);
            }

            // Generate report based on type
            switch ($reportType) {
                case 'all_payments_list':
                    return $this->generateAllPaymentsList($format, $includeSummary, $paymentType, $specificDate);
                case 'payments_by_date_range':
                    return $this->generatePaymentsByDateRange($format, $fromDate, $toDate, $includeSummary, $paymentType);
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid report type specified'
                    ]);
            }
            
        } catch (\Exception $e) {
            Log::error('Error generating general report: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error generating report: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generatePaymentPDF($payments, $reportType)
    {
        try {
            // Check if FPDF file exists
            $fpdfPath = base_path('fpdf186/fpdf.php');
            if (!file_exists($fpdfPath)) {
                Log::error('FPDF file not found at: ' . $fpdfPath);
                return response()->json([
                    'success' => false,
                    'message' => 'PDF generation library not found. Please contact administrator.'
                ]);
            }
            
            require_once $fpdfPath;
            
            $pdf = new \FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Times', 'B', 16);
            
            // Title
            $pdf->Cell(0, 10, 'Payment Report - ' . ucfirst(str_replace('_', ' ', $reportType)), 0, 1, 'C');
            $pdf->Ln(10);
            
            // Table headers
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Cell(30, 10, 'Date', 1);
            $pdf->Cell(40, 10, 'Member', 1);
            $pdf->Cell(30, 10, 'Type', 1);
            $pdf->Cell(30, 10, 'Amount', 1);
            $pdf->Cell(30, 10, 'Status', 1);
            $pdf->Ln();
            
            // Table data
            $pdf->SetFont('Times', '', 10);
            foreach ($payments as $payment) {
                $pdf->Cell(30, 10, $payment->created_at->format('Y-m-d'), 1);
                $pdf->Cell(40, 10, $payment->user->name ?? 'Unknown', 1);
                $pdf->Cell(30, 10, ucfirst($payment->payment_type), 1);
                $pdf->Cell(30, 10, number_format($payment->amount, 2), 1);
                $pdf->Cell(30, 10, ucfirst($payment->status), 1);
                $pdf->Ln();
            }
            
            // Save file
            $filename = 'payment_report_' . date('Y_m_d_His') . '.pdf';
            $filepath = storage_path('app/public/reports/' . $filename);
            
            // Create directory if it doesn't exist
            if (!is_dir(dirname($filepath))) {
                mkdir(dirname($filepath), 0755, true);
            }
            
            $pdf->Output('F', $filepath);
            
            // Return the PDF directly for download instead of URL
            return response()->download($filepath, $filename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
            
        } catch (\Exception $e) {
            Log::error('PDF generation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'PDF generation failed: ' . $e->getMessage()
            ]);
        }
    }

    private function generatePaymentExcel($payments, $reportType)
    {
        // Simple CSV format for Excel compatibility
        $filename = 'payment_report_' . date('Y_m_d_His') . '.csv';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $file = fopen($filepath, 'w');
        
        // Headers
        fputcsv($file, ['Date', 'Member', 'Type', 'Amount', 'Status', 'Description']);
        
        // Data
        foreach ($payments as $payment) {
            fputcsv($file, [
                $payment->created_at->format('Y-m-d'),
                $payment->user->name ?? 'Unknown',
                ucfirst($payment->payment_type),
                $payment->amount,
                ucfirst($payment->status),
                $payment->description
            ]);
        }
        
        fclose($file);
        
        // Return the CSV directly for download
        return response()->download($filepath, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Generate Payment CSV Report
     */
    private function generatePaymentCSV($payments, $reportType)
    {
        return $this->generatePaymentExcel($payments, $reportType);
    }

    /**
     * Generate Member PDF Report
     */
    private function generateMemberPDF($members, $reportType, $includePaymentHistory, $includeContactDetails)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF('P', 'mm', 'A4'); // Portrait orientation for mobile-friendly view
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Modern header section - adjusted for portrait
        $pdf->SetFillColor(52, 152, 219); // Modern blue
        $pdf->Rect(0, 0, 210, 40, 'F'); // Header background for portrait
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('Times', 'B', 20);
        $pdf->Cell(0, 30, 'MEMBER REPORTS', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 14);
        
        // Title with report type
        $title = 'Member Report - ' . ucfirst(str_replace('_', ' ', $reportType));
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        
        // Reset for content
        $pdf->SetTextColor(0, 0, 0); // Black text
        $pdf->Ln(25); // Increased spacing from 15 to 25
        
        // Well-organized summary statistics
        $pdf->SetFillColor(241, 196, 15); // Gold/yellow background
        $pdf->Rect(10, $pdf->GetY() - 5, 190, 10, 'F');
        $pdf->SetTextColor(0, 0, 0); // Black text
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 15, 'SUMMARY STATISTICS', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Summary box with centered layout
        $pdf->SetFillColor(248, 248, 248); // Light gray background
        $pdf->Rect(10, $pdf->GetY(), 190, 60, 'F');
        $pdf->SetFillColor(52, 152, 219); // Blue accent
        $pdf->Rect(10, $pdf->GetY(), 5, 60, 'F');
        
        $pdf->SetTextColor(0, 0, 0); // Black text
        $pdf->SetFont('Times', '', 12);
        
        // Total users
        $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
        $pdf->Cell(0, 10, 'Total Users: ' . $members->count(), 0, 1);
        
        // Count by roles (Admin, Leader, Member)
        $roleCounts = $members->groupBy('role')->map->count();
        $adminCount = $roleCounts['admin'] ?? 0;
        $leaderCount = $roleCounts['leader'] ?? 0;
        $memberCount = $roleCounts['member'] ?? 0;
        
        $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
        $pdf->Cell(0, 10, 'Admins: ' . $adminCount, 0, 1);
        $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
        $pdf->Cell(0, 10, 'Leaders: ' . $leaderCount, 0, 1);
        $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
        $pdf->Cell(0, 10, 'Members: ' . $memberCount, 0, 1);
        
        $pdf->Ln(25); // Increased spacing before table
        
        // Smart table headers - optimized for portrait mobile view
        $pdf->SetFillColor(52, 152, 219); // Modern blue
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('Times', 'B', 11); // Smaller font for more space
        $pdf->Cell(15, 10, 'S/No', 1, 0, 'C', true); // Serial number column
        $pdf->Cell(33, 10, 'Name', 1, 0, 'C', true); // Reduced from 35 to 33
        $pdf->Cell(16, 10, 'Role', 1, 0, 'C', true);
        $pdf->Cell(16, 10, 'Status', 1, 0, 'C', true);
        $pdf->Cell(24, 10, 'Phone', 1, 0, 'C', true); // Reduced from 26 to 24
        $pdf->Cell(32, 10, 'Home Diocese', 1, 0, 'C', true); // Increased from 26 to 32
        $pdf->Cell(54, 10, 'Email', 1, 0, 'C', true); // Reduced from 56 to 54
        
        $pdf->Ln();
        
        // Table data with alternating row colors - optimized for mobile
        $pdf->SetTextColor(0, 0, 0); // Black text
        $rowCount = 0;
        $serialNumber = 1; // Start serial number from 1
        foreach ($members as $member) {
            // Alternating row colors
            if ($rowCount % 2 == 0) {
                $pdf->SetFillColor(248, 248, 248); // Light gray
            } else {
                $pdf->SetFillColor(255, 255, 255); // White
            }
            
            $pdf->SetFont('Times', '', 9); // Smaller font for mobile
            
            // Serial number
            $pdf->Cell(15, 8, $serialNumber, 1, 0, 'C', true);
            
            // Truncate long names for mobile - adjusted limit
            $name = strlen($member->name) > 15 ? substr($member->name, 0, 15) . '...' : $member->name; // Reduced from 16 to 15
            $pdf->Cell(33, 8, $name, 1, 0, 'L', true); // Reduced from 35 to 33
            $pdf->Cell(16, 8, ucfirst($member->role), 1, 0, 'C', true);
            
            // Status with color coding
            $status = ucfirst($member->membership_status) ?? 'Pending';
            if ($status === 'Active') {
                $pdf->SetTextColor(0, 128, 0); // Green
                $pdf->SetFont('Times', 'B', 9); // Bold
            } elseif ($status === 'Inactive') {
                $pdf->SetTextColor(255, 0, 0); // Red
                $pdf->SetFont('Times', 'B', 9); // Bold
            } else {
                $pdf->SetTextColor(255, 165, 0); // Orange
                $pdf->SetFont('Times', 'B', 9); // Bold
            }
            
            $pdf->Cell(16, 8, $status, 1, 0, 'C', true);
            
            // Reset to normal
            $pdf->SetTextColor(0, 0, 0); // Black
            $pdf->SetFont('Times', '', 9); // Normal
            
            $pdf->Cell(24, 8, $member->phone_number ?? 'N/A', 1, 0, 'C', true); // Reduced from 26 to 24
            
            // Truncate diocese for mobile - increased limit
            $diocese = $member->home_diocese ?? 'N/A';
            $diocese = strlen($diocese) > 13 ? substr($diocese, 0, 13) . '...' : $diocese; // Increased from 11 to 13
            $pdf->Cell(32, 8, $diocese, 1, 0, 'C', true); // Increased from 26 to 32
            
            // Better email truncation for mobile - adjusted limit
            $email = $member->email;
            if (strlen($email) > 30) { // Reduced from 32 to 30
                $email = substr($email, 0, 30) . '...';
            }
            $pdf->Cell(54, 8, $email, 1, 0, 'L', true); // Reduced from 56 to 54
            
            $pdf->Ln();
            $rowCount++;
            $serialNumber++; // Increment serial number
        }
        
        // Minimal footer
        $pdf->SetY(-15);
        $pdf->SetTextColor(128, 128, 128); // Light gray text
        $pdf->SetFont('Times', 'I', 7);
        $pdf->Cell(0, 8, 'Generated on ' . date('Y-m-d H:i:s') . ' | TMCS System', 0, 1, 'C');
        
        // Save file
        $filename = 'member_report_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        // Return the PDF directly for download instead of URL
        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Generate Member Excel Report
     */
    private function generateMemberExcel($members, $reportType, $includePaymentHistory, $includeContactDetails)
    {
        $filename = 'member_report_' . date('Y_m_d_His') . '.csv';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $file = fopen($filepath, 'w');
        
        // Headers with complete member data
        $headers = ['S/No', 'Name', 'Role', 'Status', 'Phone', 'Home Diocese', 'Email', 'Registration Date'];
        
        if ($includePaymentHistory) {
            $headers[] = 'Total Payments';
            $headers[] = 'Total Amount';
        }
        
        fputcsv($file, $headers);
        
        // Data rows with complete member information
        $serialNumber = 1; // Start serial number from 1
        foreach ($members as $member) {
            $status = ucfirst($member->membership_status) ?? 'Pending';
            
            $row = [
                $serialNumber, // Serial number column
                $member->name,
                ucfirst($member->role),
                $status,
                $member->phone_number ?? 'N/A',
                $member->home_diocese ?? 'N/A',
                $member->email,
                $member->created_at->format('Y-m-d')
            ];
            
            if ($includePaymentHistory) {
                $totalPayments = $member->payments->count();
                $totalAmount = $member->payments->sum('amount');
                $row[] = $totalPayments;
                $row[] = number_format($totalAmount, 2);
            }
            
            fputcsv($file, $row);
            $serialNumber++; // Increment serial number
        }
        
        fclose($file);
        
        // Return the CSV directly for download
        return response()->download($filepath, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Generate Member CSV Report
     */
    private function generateMemberCSV($members, $reportType, $includePaymentHistory, $includeContactDetails)
    {
        return $this->generateMemberExcel($members, $reportType, $includePaymentHistory, $includeContactDetails);
    }

    /**
     * Generate System Overview Report
     */
    private function generateSystemOverview($format, $includeSummary)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Title
        $pdf->Cell(0, 10, 'System Overview Report', 0, 1, 'C');
        $pdf->Ln(10);
        
        if ($includeSummary) {
            // Summary statistics
            $totalUsers = User::count();
            $totalPayments = Payment::count();
            $totalRevenue = Payment::sum('amount');
            $pendingPayments = Payment::where('status', 'pending')->count();
            
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 10, 'Summary Statistics', 0, 1);
            $pdf->Ln(5);
            
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(0, 8, 'Total Users: ' . $totalUsers, 0, 1);
            $pdf->Cell(0, 8, 'Total Payments: ' . $totalPayments, 0, 1);
            $pdf->Cell(0, 8, 'Total Revenue: TZS ' . number_format($totalRevenue, 2), 0, 1);
            $pdf->Cell(0, 8, 'Pending Payments: ' . $pendingPayments, 0, 1);
            $pdf->Ln(10);
        }
        
        // User breakdown by role
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10, 'User Breakdown by Role', 0, 1);
        $pdf->Ln(5);
        
        $userRoles = User::select('role', DB::raw('count(*) as count'))
                    ->groupBy('role')
                    ->get();
        
        $pdf->SetFont('Times', '', 12);
        foreach ($userRoles as $role) {
            $pdf->Cell(0, 8, ucfirst($role->role) . ': ' . $role->count, 0, 1);
        }
        
        // Save file
        $filename = 'system_overview_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        return response()->json([
            'success' => true,
            'message' => 'System overview report generated successfully',
            'download_url' => url('/storage/reports/' . $filename)
        ]);
    }

    /**
     * Generate User Statistics Report
     */
    private function generateUserStatistics($format, $fromDate, $toDate, $includeSummary)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Title
        $pdf->Cell(0, 10, 'User Statistics Report', 0, 1, 'C');
        $pdf->Ln(10);
        
        // Apply date filters
        $query = User::query();
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
        
        $users = $query->get();
        
        if ($includeSummary) {
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 10, 'Summary', 0, 1);
            $pdf->Ln(5);
            
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(0, 8, 'Total Users: ' . $users->count(), 0, 1);
            $pdf->Ln(10);
        }
        
        // User details table
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(15, 10, 'S/No', 1, 0, 'C'); // Added S/No column
        $pdf->Cell(35, 10, 'Name', 1); // Reduced from 40 to 35
        $pdf->Cell(30, 10, 'Role', 1);
        $pdf->Cell(30, 10, 'Status', 1);
        $pdf->Cell(40, 10, 'Registration Date', 1);
        $pdf->Ln();
        
        $pdf->SetFont('Times', '', 10);
        $serialNumber = 1; // Start serial number from 1
        foreach ($users as $user) {
            $pdf->Cell(15, 10, $serialNumber, 1, 0, 'C'); // Added S/No data
            $pdf->Cell(35, 10, $user->name, 1); // Reduced from 40 to 35
            $pdf->Cell(30, 10, ucfirst($user->role), 1);
            $pdf->Cell(30, 10, ucfirst($user->status), 1);
            $pdf->Cell(40, 10, $user->created_at->format('Y-m-d'), 1);
            $pdf->Ln();
            $serialNumber++; // Increment serial number
        }
        
        // Save file
        $filename = 'user_statistics_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        return response()->json([
            'success' => true,
            'message' => 'User statistics report generated successfully',
            'download_url' => url('/storage/reports/' . $filename)
        ]);
    }

    /**
     * Generate Payment Summary Report
     */
    private function generatePaymentSummary($format, $fromDate, $toDate, $includeSummary)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Title
        $pdf->Cell(0, 10, 'Payment Summary Report', 0, 1, 'C');
        $pdf->Ln(10);
        
        // Apply date filters
        $query = Payment::with('user');
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
        
        $payments = $query->get();
        
        if ($includeSummary) {
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 10, 'Summary', 0, 1);
            $pdf->Ln(5);
            
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(0, 8, 'Total Payments: ' . $payments->count(), 0, 1);
            $pdf->Cell(0, 8, 'Total Revenue: TZS ' . number_format($payments->sum('amount'), 2), 0, 1);
            $pdf->Cell(0, 8, 'Average Payment: TZS ' . number_format($payments->avg('amount'), 2), 0, 1);
            $pdf->Ln(10);
        }
        
        // Payment breakdown by type
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10, 'Payment Breakdown by Type', 0, 1);
        $pdf->Ln(5);
        
        $paymentTypes = Payment::select('payment_type', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
                           ->groupBy('payment_type')
                           ->get();
        
        $pdf->SetFont('Times', '', 12);
        foreach ($paymentTypes as $type) {
            $pdf->Cell(0, 8, ucfirst($type->payment_type) . ': ' . $type->count . ' payments, TZS ' . number_format($type->total, 2), 0, 1);
        }
        
        // Save file
        $filename = 'payment_summary_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        return response()->json([
            'success' => true,
            'message' => 'Payment summary report generated successfully',
            'download_url' => url('/storage/reports/' . $filename)
        ]);
    }

    /**
     * Generate Financial Analytics Report
     */
    private function generateFinancialAnalytics($format, $fromDate, $toDate, $includeSummary)
    {
        return $this->generatePaymentSummary($format, $fromDate, $toDate, $includeSummary);
    }

    /**
     * Generate Activity Log Report
     */
    private function generateActivityLog($format, $fromDate, $toDate)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Title
        $pdf->Cell(0, 10, 'Activity Log Report', 0, 1, 'C');
        $pdf->Ln(10);
        
        // Recent activities
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10, 'Recent Activities', 0, 1);
        $pdf->Ln(5);
        
        $pdf->SetFont('Times', '', 12);
        
        // Get recent payments
        $payments = Payment::with('user')
                          ->orderBy('user_id')->orderBy('created_at', 'desc')
                          ->limit(20)
                          ->get();
        
        foreach ($payments as $payment) {
            $pdf->Cell(0, 8, $payment->created_at->format('Y-m-d H:i') . ' - ' . 
                      $payment->user->name . ' made a ' . $payment->payment_type . 
                      ' payment of TZS ' . number_format($payment->amount, 2), 0, 1);
        }
        
        // Save file
        $filename = 'activity_log_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        return response()->json([
            'success' => true,
            'message' => 'Activity log report generated successfully',
            'download_url' => url('/storage/reports/' . $filename)
        ]);
    }

    /**
     * Generate Monthly Summary Report
     */
    private function generateMonthlySummary($format, $fromDate, $toDate, $includeSummary)
    {
        return $this->generatePaymentSummary($format, $fromDate, $toDate, $includeSummary);
    }

    /**
     * Generate All Payments List Report
     */
    private function generateAllPaymentsList($format, $includeSummary, $paymentType = null, $specificDate = null)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Modern header section
        $pdf->SetFillColor(52, 152, 219); // Modern blue
        $pdf->Rect(0, 0, 210, 40, 'F'); // Header background
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('Times', 'B', 20);
        $pdf->Cell(0, 30, 'PAYMENT REPORTS', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 14);
        
        // Title with filters
        $title = 'All Payments List Report';
        if ($paymentType) {
            $title .= ' - ' . ucfirst($paymentType) . ' Payments';
        }
        if ($specificDate) {
            $title .= ' (' . $specificDate . ')';
        }
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        
        // Reset for content
        $pdf->SetTextColor(0, 0, 0); // Black text
        $pdf->Ln(10);
        
        // Build query - ONLY COMPLETED PAYMENTS
        $query = Payment::with('user')->where('status', 'completed');
        
        if ($paymentType) {
            $query->where('payment_type', $paymentType);
        }
        if ($specificDate) {
            $query->whereDate('created_at', $specificDate);
        }
        
        $payments = $query->orderBy('user_id')->orderBy('created_at', 'desc')->get();
        
        // Group payments by user
        $groupedPayments = [];
        foreach ($payments as $payment) {
            $userId = $payment->user_id;
            if (!isset($groupedPayments[$userId])) {
                $groupedPayments[$userId] = [
                    'user' => $payment->user,
                    'payments' => [],
                    'total_amount' => 0
                ];
            }
            $groupedPayments[$userId]['payments'][] = $payment;
            $groupedPayments[$userId]['total_amount'] += $payment->amount;
        }
        
        if ($includeSummary) {
            // Modern summary section
            $pdf->SetFillColor(241, 196, 15); // Gold/yellow background
            $pdf->Rect(10, $pdf->GetY() - 5, 190, 10, 'F');
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 15, 'SUMMARY STATISTICS', 0, 1, 'C');
            $pdf->Ln(5);
            
            // Summary box
            $pdf->SetFillColor(248, 248, 248); // Light gray background
            $pdf->Rect(10, $pdf->GetY(), 190, 50, 'F');
            $pdf->SetFillColor(52, 152, 219); // Blue accent
            $pdf->Rect(10, $pdf->GetY(), 5, 50, 'F');
            
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
            $pdf->Cell(0, 10, 'Total Payments: ' . $payments->count(), 0, 1);
            $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
            $pdf->Cell(0, 10, 'Total Amount: TZS ' . number_format($payments->sum('amount'), 2), 0, 1);
            $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
            $pdf->Cell(0, 10, 'Average Amount: TZS ' . number_format($payments->avg('amount'), 2), 0, 1);
            
            if ($paymentType) {
                $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
                $pdf->Cell(0, 10, 'Payment Type: ' . ucfirst($paymentType), 0, 1);
            }
            if ($specificDate) {
                $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
                $pdf->Cell(0, 10, 'Date: ' . $specificDate, 0, 1);
            }
            $pdf->Ln(25); // Increased spacing from 15 to 25
        }
        
        // Modern table headers for user-grouped display
        $pdf->SetFillColor(52, 152, 219); // Modern blue
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30, 12, 'Date', 1, 0, 'C', true);
        $pdf->Cell(30, 12, 'Type', 1, 0, 'C', true);
        $pdf->Cell(30, 12, 'Amount', 1, 0, 'C', true);
        $pdf->Cell(35, 12, 'Status', 1, 1, 'C', true);
        
        // Display payments grouped by user
        $pdf->SetTextColor(0, 0, 0); // Black text
        $userCount = 0;
        
        foreach ($groupedPayments as $userId => $userData) {
            $userCount++;
            $user = $userData['user'];
            $userPayments = $userData['payments'];
            $totalAmount = $userData['total_amount'];
            
            // User header with total
            $pdf->SetFont('Times', 'B', 11);
            $pdf->SetFillColor(230, 230, 250);
            $pdf->Cell(0, 12, 'User ' . $userCount . ': ' . $user->name . ' (' . count($userPayments) . ' payments, Total: TZS ' . number_format($totalAmount, 2) . ')', 1, 1, 'L', true);
            
            // User's payments
            $pdf->SetFont('Times', '', 10);
            $paymentSerial = 1;
            $rowCount = 0;
            
            foreach ($userPayments as $payment) {
                // Alternating row colors
                if ($rowCount % 2 == 0) {
                    $pdf->SetFillColor(248, 248, 248); // Light gray
                } else {
                    $pdf->SetFillColor(255, 255, 255); // White
                }
                
                $pdf->Cell(30, 10, $payment->created_at->format('Y-m-d'), 1, 0, 'C', true);
                $pdf->Cell(30, 10, ucfirst($payment->payment_type), 1, 0, 'C', true);
                $pdf->Cell(30, 10, number_format($payment->amount, 2), 1, 0, 'R', true);
                
                // Status with color coding
                $status = ucfirst($payment->status);
                if ($status === 'Approved') {
                    $pdf->SetTextColor(0, 128, 0); // Green
                    $pdf->SetFont('Times', 'B', 10); // Bold
                } elseif ($status === 'Rejected') {
                    $pdf->SetTextColor(255, 0, 0); // Red
                    $pdf->SetFont('Times', 'B', 10); // Bold
                } else { // Pending
                    $pdf->SetTextColor(255, 165, 0); // Orange
                    $pdf->SetFont('Times', 'B', 10); // Bold
                }
                
                $pdf->Cell(35, 10, $status, 1, 0, 'C', true);
                
                // Reset to normal
                $pdf->SetTextColor(0, 0, 0); // Black
                $pdf->SetFont('Times', '', 10); // Normal
                
                $pdf->Ln();
                $rowCount++;
                $paymentSerial++;
            }
            
            // Add spacing between users
            $pdf->Ln(3);
        }
        
        // Minimal footer
        $pdf->SetY(-15);
        $pdf->SetTextColor(128, 128, 128); // Light gray text
        $pdf->SetFont('Times', 'I', 7);
        $pdf->Cell(0, 8, 'Generated on ' . date('Y-m-d H:i:s') . ' | TMCS System', 0, 1, 'C');
        
        // Save file
        $filename = 'all_payments_list_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        // Return the PDF directly for download instead of URL
        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Generate Payments by Date Range Report
     */
    private function generatePaymentsByDateRange($format, $fromDate, $toDate, $includeSummary, $paymentType = null)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Modern header section
        $pdf->SetFillColor(52, 152, 219); // Modern blue
        $pdf->Rect(0, 0, 210, 40, 'F'); // Header background
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('Times', 'B', 20);
        $pdf->Cell(0, 30, 'PAYMENT REPORTS', 0, 1, 'C');
        $pdf->SetFont('Times', 'B', 14);
        
        // Title with filters
        $title = 'Payments by Date Range Report';
        if ($fromDate && $toDate) {
            $title .= ' (' . $fromDate . ' to ' . $toDate . ')';
        }
        if ($paymentType) {
            $title .= ' - ' . ucfirst($paymentType) . ' Payments';
        }
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        
        // Reset for content
        $pdf->SetTextColor(0, 0, 0); // Black text
        $pdf->Ln(25); // Increased spacing from 15 to 25
        
        // Build query - ONLY COMPLETED PAYMENTS
        $query = Payment::with('user')->where('status', 'completed');
        
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
        if ($paymentType) {
            $query->where('payment_type', $paymentType);
        }
        
        $payments = $query->orderBy('user_id')->orderBy('created_at', 'desc')->get();
        
        if ($includeSummary) {
            // Modern summary section
            $pdf->SetFillColor(241, 196, 15); // Gold/yellow background
            $pdf->Rect(10, $pdf->GetY() - 5, 190, 10, 'F');
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 15, 'SUMMARY STATISTICS', 0, 1, 'C');
            $pdf->Ln(5);
            
            // Summary box
            $pdf->SetFillColor(248, 248, 248); // Light gray background
            $pdf->Rect(10, $pdf->GetY(), 190, 50, 'F');
            $pdf->SetFillColor(52, 152, 219); // Blue accent
            $pdf->Rect(10, $pdf->GetY(), 5, 50, 'F');
            
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
            $pdf->Cell(0, 10, 'Total Payments: ' . $payments->count(), 0, 1);
            $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
            $pdf->Cell(0, 10, 'Total Amount: TZS ' . number_format($payments->sum('amount'), 2), 0, 1);
            $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
            $pdf->Cell(0, 10, 'Average Amount: TZS ' . number_format($payments->avg('amount'), 2), 0, 1);
            
            if ($paymentType) {
                $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
                $pdf->Cell(0, 10, 'Payment Type: ' . ucfirst($paymentType), 0, 1);
            }
            if ($fromDate && $toDate) {
                $pdf->Cell(15, 10, '', 0, 0); // Spacer for blue accent
                $pdf->Cell(0, 10, 'Date Range: ' . $fromDate . ' to ' . $toDate, 0, 1);
            }
            $pdf->Ln(25); // Increased spacing from 15 to 25
        }
        
        // Modern table headers
        $pdf->SetFillColor(52, 152, 219); // Modern blue
        $pdf->SetTextColor(255, 255, 255); // White text
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30, 12, 'Date', 1, 0, 'C', true);
        $pdf->Cell(50, 12, 'Member', 1, 0, 'C', true);
        $pdf->Cell(30, 12, 'Type', 1, 0, 'C', true);
        $pdf->Cell(30, 12, 'Amount', 1, 0, 'C', true);
        $pdf->Cell(35, 12, 'Status', 1, 0, 'C', true);
        $pdf->Ln();
        
        // Table data with alternating row colors
        $pdf->SetTextColor(0, 0, 0); // Black text
        $rowCount = 0;
        foreach ($payments as $payment) {
            // Alternating row colors
            if ($rowCount % 2 == 0) {
                $pdf->SetFillColor(248, 248, 248); // Light gray
            } else {
                $pdf->SetFillColor(255, 255, 255); // White
            }
            
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(30, 10, $payment->created_at->format('Y-m-d'), 1, 0, 'C', true);
            $pdf->Cell(50, 10, $payment->user->name ?? 'Unknown', 1, 0, 'L', true);
            $pdf->Cell(30, 10, ucfirst($payment->payment_type), 1, 0, 'C', true);
            $pdf->Cell(30, 10, number_format($payment->amount, 2), 1, 0, 'R', true);
            
            // Status with color coding
            $status = ucfirst($payment->status);
            if ($status === 'Approved') {
                $pdf->SetTextColor(0, 128, 0); // Green
                $pdf->SetFont('Times', 'B', 10); // Bold
            } elseif ($status === 'Rejected') {
                $pdf->SetTextColor(255, 0, 0); // Red
                $pdf->SetFont('Times', 'B', 10); // Bold
            } else { // Pending
                $pdf->SetTextColor(255, 165, 0); // Orange
                $pdf->SetFont('Times', 'B', 10); // Bold
            }
            
            $pdf->Cell(35, 10, $status, 1, 0, 'C', true);
            
            // Reset to normal
            $pdf->SetTextColor(0, 0, 0); // Black
            $pdf->SetFont('Times', '', 10); // Normal
            
            $pdf->Ln();
            $rowCount++;
        }
        
        // Minimal footer
        $pdf->SetY(-15);
        $pdf->SetTextColor(128, 128, 128); // Light gray text
        $pdf->SetFont('Times', 'I', 7);
        $pdf->Cell(0, 8, 'Generated on ' . date('Y-m-d H:i:s') . ' | TMCS System', 0, 1, 'C');
        
        // Save file
        $filename = 'payments_by_date_range_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        // Return the PDF directly for download instead of URL
        return response()->download($filepath, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }

    /**
     * Generate Payments per Member Report
     */
    private function generatePaymentsPerMember($format, $includeSummary)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Title
        $pdf->Cell(0, 10, 'Payments per Member Report', 0, 1, 'C');
        $pdf->Ln(10);
        
        // Get users with their payments
        $users = User::with(['payments' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        
        if ($includeSummary) {
            // Summary statistics
            $totalUsers = $users->count();
            $totalPayments = $users->sum(function($user) {
                return $user->payments->count();
            });
            $totalAmount = $users->sum(function($user) {
                return $user->payments->sum('amount');
            });
            
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 10, 'Summary Statistics', 0, 1);
            $pdf->Ln(5);
            
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(0, 8, 'Total Members: ' . $totalUsers, 0, 1);
            $pdf->Cell(0, 8, 'Total Payments: ' . $totalPayments, 0, 1);
            $pdf->Cell(0, 8, 'Total Amount: TZS ' . number_format($totalAmount, 2), 0, 1);
            $pdf->Ln(10);
        }
        
        // Table headers
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(50, 10, 'Member Name', 1);
        $pdf->Cell(30, 10, 'Role', 1);
        $pdf->Cell(30, 10, 'Payments', 1);
        $pdf->Cell(40, 10, 'Total Amount', 1);
        $pdf->Cell(40, 10, 'Last Payment', 1);
        $pdf->Ln();
        
        // Table data
        $pdf->SetFont('Times', '', 10);
        foreach ($users as $user) {
            $paymentCount = $user->payments->count();
            $totalAmount = $user->payments->sum('amount');
            $lastPayment = $user->payments->first();
            
            $pdf->Cell(50, 10, $user->name, 1);
            $pdf->Cell(30, 10, ucfirst($user->role), 1);
            $pdf->Cell(30, 10, $paymentCount, 1);
            $pdf->Cell(40, 10, number_format($totalAmount, 2), 1);
            $pdf->Cell(40, 10, $lastPayment ? $lastPayment->created_at->format('Y-m-d') : 'N/A', 1);
            $pdf->Ln();
        }
        
        // Save file
        $filename = 'payments_per_member_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        return response()->json([
            'success' => true,
            'message' => 'Payments per member report generated successfully',
            'download_url' => asset('storage/reports/' . $filename)
        ]);
    }

    /**
     * Generate Monthly Collection Report
     */
    private function generateMonthlyCollection($format, $fromDate, $toDate, $includeSummary, $paymentType = null)
    {
        require_once base_path('fpdf186/fpdf.php');
        
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        
        // Title
        $title = 'Monthly Collection Report';
        if ($fromDate && $toDate) {
            $title .= ' (' . $fromDate . ' to ' . $toDate . ')';
        }
        if ($paymentType) {
            $title .= ' - ' . ucfirst($paymentType) . ' Payments';
        }
        $pdf->Cell(0, 10, $title, 0, 1, 'C');
        $pdf->Ln(10);
        
        // Build query - ONLY COMPLETED PAYMENTS
        $query = Payment::with('user')->where('status', 'completed');
        
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }
        if ($paymentType) {
            $query->where('payment_type', $paymentType);
        }
        
        $payments = $query->orderBy('user_id')->orderBy('created_at', 'desc')->get();
        
        // Group by month
        $monthlyData = $payments->groupBy(function($payment) {
            return $payment->created_at->format('Y-m');
        });
        
        if ($includeSummary) {
            // Summary statistics
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(0, 10, 'Summary Statistics', 0, 1);
            $pdf->Ln(5);
            
            $pdf->SetFont('Times', '', 12);
            $pdf->Cell(0, 8, 'Total Months: ' . $monthlyData->count(), 0, 1);
            $pdf->Cell(0, 8, 'Total Payments: ' . $payments->count(), 0, 1);
            $pdf->Cell(0, 8, 'Total Amount: TZS ' . number_format($payments->sum('amount'), 2), 0, 1);
            if ($paymentType) {
                $pdf->Cell(0, 8, 'Payment Type: ' . ucfirst($paymentType), 0, 1);
            }
            if ($fromDate && $toDate) {
                $pdf->Cell(0, 8, 'Date Range: ' . $fromDate . ' to ' . $toDate, 0, 1);
            }
            $pdf->Ln(10);
        }
        
        // Table headers
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30, 10, 'Month', 1);
        $pdf->Cell(25, 10, 'Payments', 1);
        $pdf->Cell(40, 10, 'Total Amount', 1);
        $pdf->Cell(40, 10, 'Average Amount', 1);
        $pdf->Cell(60, 10, 'Payment Types', 1);
        $pdf->Ln();
        
        // Table data
        $pdf->SetFont('Times', '', 10);
        foreach ($monthlyData as $month => $monthPayments) {
            $totalAmount = $monthPayments->sum('amount');
            $paymentCount = $monthPayments->count();
            $averageAmount = $paymentCount > 0 ? $totalAmount / $paymentCount : 0;
            
            // Get payment types for this month
            $paymentTypes = $monthPayments->pluck('payment_type')->unique()->implode(', ');
            
            $pdf->Cell(30, 10, $month, 1);
            $pdf->Cell(25, 10, $paymentCount, 1);
            $pdf->Cell(40, 10, number_format($totalAmount, 2), 1);
            $pdf->Cell(40, 10, number_format($averageAmount, 2), 1);
            $pdf->Cell(60, 10, $paymentTypes, 1);
            $pdf->Ln();
        }
        
        // Save file
        $filename = 'monthly_collection_' . date('Y_m_d_His') . '.pdf';
        $filepath = storage_path('app/public/reports/' . $filename);
        
        // Create directory if it doesn't exist
        if (!is_dir(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }
        
        $pdf->Output('F', $filepath);
        
        return response()->json([
            'success' => true,
            'message' => 'Monthly collection report generated successfully',
            'download_url' => asset('storage/reports/' . $filename)
        ]);
    }
}
