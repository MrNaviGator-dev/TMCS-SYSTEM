<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access the dashboard.');
        }
        
        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized access. Please login with correct credentials.');
        }
        
        return view('admin.dashboard');
    }

    /**
     * Generate PDF report for user payments
     */
    public function generatePaymentPDF(Request $request)
    {
        // Check if user is authenticated and is admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            // Get data from request
            $userId = $request->input('user_id');
            $userName = $request->input('user_name');
            $userEmail = $request->input('user_email');
            $userPhone = $request->input('user_phone');
            $userRole = $request->input('user_role');
            $payments = json_decode($request->input('payments'), true);

            // Include FPDF library
            require_once base_path('fpdf186/fpdf.php');

            // Create new PDF
            $pdf = new \FPDF();
            $pdf->AddPage();
            
            // Set font
            $pdf->SetFont('Arial', 'B', 16);
            
            // Modern Header with Background
            $pdf->SetFillColor(30, 58, 138); // Dark blue
            $pdf->Rect(0, 0, 210, 40, 'F');
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 20);
            $pdf->Cell(0, 15, 'TMCS PAYMENT REPORT', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, 'Generated on: ' . date('F j, Y H:i:s'), 0, 1, 'C');
            
            // Reset colors
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Ln(10);
            
            // Profile Picture and User Information
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 8, 'Member Information', 0, 1, 'L');
            $pdf->Ln(5);
            
            // Check if user has profile picture
            $profilePicturePath = null;
            if (isset($payments[0]['user_id'])) {
                $profileUserId = $payments[0]['user_id'];
                $profilePicturePath = public_path("uploads/profiles/user_{$profileUserId}.jpg");
                if (!file_exists($profilePicturePath)) {
                    $profilePicturePath = public_path("uploads/profiles/default-avatar.png");
                }
            }
            
            // Add profile picture if exists
            if ($profilePicturePath && file_exists($profilePicturePath)) {
                $pdf->Cell(30, 40, '', 1, 0, 'C');
                $pdf->Image($profilePicturePath, 15, 75, 30, 40);
                $pdf->Cell(0, 40, '', 0, 1, 'C');
                $pdf->Ln(5);
                
                // User info beside profile picture
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(40, 6, 'User ID:', 0, 0, 'L');
                $pdf->Cell(0, 6, 'TMCS-' . str_pad($profileUserId, 4, '0', STR_PAD_LEFT), 0, 1, 'L');
                
                $pdf->Cell(40, 6, 'Name:', 0, 0, 'L');
                $pdf->Cell(0, 6, $userName, 0, 1, 'L');
                
                $pdf->Cell(40, 6, 'Email:', 0, 0, 'L');
                $pdf->Cell(0, 6, $userEmail, 0, 1, 'L');
                
                $pdf->Cell(40, 6, 'Phone:', 0, 0, 'L');
                $pdf->Cell(0, 6, $userPhone ?: 'Not provided', 0, 1, 'L');
                
                $pdf->Cell(40, 6, 'Role:', 0, 0, 'L');
                $pdf->Cell(0, 6, ucfirst($userRole), 0, 1, 'L');
            } else {
                // No profile picture - just text info
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(30, 6, 'User ID:', 0, 0, 'L');
                $pdf->Cell(0, 6, 'TMCS-' . str_pad($userId, 4, '0', STR_PAD_LEFT), 0, 1, 'L');
                
                $pdf->Cell(30, 6, 'Name:', 0, 0, 'L');
                $pdf->Cell(0, 6, $userName, 0, 1, 'L');
                
                $pdf->Cell(30, 6, 'Email:', 0, 0, 'L');
                $pdf->Cell(0, 6, $userEmail, 0, 1, 'L');
                
                $pdf->Cell(30, 6, 'Phone:', 0, 0, 'L');
                $pdf->Cell(0, 6, $userPhone ?: 'Not provided', 0, 1, 'L');
                
                $pdf->Cell(30, 6, 'Role:', 0, 0, 'L');
                $pdf->Cell(0, 6, ucfirst($userRole), 0, 1, 'L');
            }
            
            $pdf->Ln(10);
            
            // Calculate payment statistics
            $totalPayments = count($payments);
            $completedPayments = count(array_filter($payments, function($p) { return $p['status'] === 'completed'; }));
            $pendingPayments = count(array_filter($payments, function($p) { return $p['status'] === 'pending'; }));
            $rejectedPayments = count(array_filter($payments, function($p) { return $p['status'] === 'rejected'; }));
            $totalAmount = array_sum(array_column(array_filter($payments, function($p) { return $p['status'] === 'completed'; }), 'amount'));
            
            // Modern Payment Summary Box
            $pdf->SetFillColor(240, 240, 240);
            $pdf->Rect(10, $pdf->GetY(), 190, 50, 'DF'); // Increased height to 50
            $pdf->Ln(8); // Move inside the frame
            
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, 'Payment Summary', 0, 1, 'C');
            $pdf->Ln(5);
            
            $pdf->SetFont('Arial', '', 10);
            
            // Two-column layout for better organization
            $pdf->Cell(95, 6, 'Total Payments:', 0, 0, 'L');
            $pdf->Cell(95, 6, $totalPayments, 0, 1, 'R');
            
            $pdf->Cell(95, 6, 'Completed:', 0, 0, 'L');
            $pdf->Cell(95, 6, $completedPayments, 0, 1, 'R');
            
            $pdf->Cell(95, 6, 'Pending:', 0, 0, 'L');
            $pdf->Cell(95, 6, $pendingPayments, 0, 1, 'R');
            
            $pdf->Cell(95, 6, 'Rejected:', 0, 0, 'L');
            $pdf->Cell(95, 6, $rejectedPayments, 0, 1, 'R');
            
            $pdf->Ln(8); // Space before total amount
            
            // Total Amount with emphasis
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(95, 8, 'Total Amount:', 0, 0, 'L');
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(95, 8, 'TZS ' . number_format($totalAmount, 0), 0, 1, 'R');
            $pdf->SetFont('Arial', '', 10);
            
            $pdf->Ln(10); // Exit the frame properly
            
            // Payment Details
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 8, 'Payment Details', 0, 1, 'L');
            $pdf->Ln(5);
            
            // Table headers
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(20, 6, 'S/NO', 1, 0, 'C');
            $pdf->Cell(40, 6, 'Type', 1, 0, 'C');
            $pdf->Cell(30, 6, 'Amount', 1, 0, 'C');
            $pdf->Cell(25, 6, 'Status', 1, 0, 'C');
            $pdf->Cell(35, 6, 'Date', 1, 0, 'C');
            $pdf->Cell(40, 6, 'Method', 1, 1, 'C');
            
            // Payment rows
            $pdf->SetFont('Arial', '', 9);
            $serialNumber = 1;
            foreach ($payments as $payment) {
                $statusLabel = ucfirst($payment['status']);
                $statusColor = $payment['status'] === 'completed' ? '0,128,0' : 
                              ($payment['status'] === 'pending' ? '255,165,0' : '255,0,0');
                
                $pdf->Cell(20, 6, $serialNumber, 1, 0, 'C');
                $pdf->Cell(40, 6, $this->getPaymentTypeLabel($payment['payment_type']), 1, 0, 'L');
                $pdf->Cell(30, 6, 'TZS ' . number_format($payment['amount'], 0), 1, 0, 'R');
                $pdf->Cell(25, 6, $statusLabel, 1, 0, 'C');
                $pdf->Cell(35, 6, date('M j, Y', strtotime($payment['created_at'])), 1, 0, 'C');
                $pdf->Cell(40, 6, $payment['payment_method'] ?: 'N/A', 1, 1, 'C');
                $serialNumber++;
            }
            
            // Footer
            $pdf->Ln(15);
            
            // Modern Footer Box
            $pdf->SetFillColor(30, 58, 138); // Dark blue
            $pdf->Rect(0, $pdf->GetY(), 210, 30, 'F');
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->Cell(0, 8, 'Generated on: ' . date('F j, Y H:i:s'), 0, 1, 'C');
            $pdf->Cell(0, 7, 'TMCS Payment Management System', 0, 1, 'C');
            $pdf->Cell(0, 7, 'www.tmcs.org | +255 716 294 801', 0, 1, 'C');
            
            // Reset colors
            $pdf->SetTextColor(0, 0, 0);
            
            // Output PDF
            $filename = 'payment_report_TMCS' . str_pad($userId, 4, '0', STR_PAD_LEFT) . '.pdf';
            
            return Response::make($pdf->Output('S'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('PDF generation error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get payment type label
     */
    private function getPaymentTypeLabel($type)
    {
        $labels = [
            'membership' => 'Membership Fee',
            'certificate' => 'Certificate Fee',
            'zaka' => 'Zaka',
            'donation' => 'Donation',
            'event' => 'Event Registration',
            'other' => 'Other'
        ];
        
        return $labels[$type] ?? $type;
    }

    /**
     * Check if user session is valid
     */
    public function checkSession()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? [
                'id' => Auth::id(),
                'name' => Auth::user()->name,
                'role' => Auth::user()->role
            ] : null
        ]);
    }
}
