<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Show the member dashboard
     */
    public function index()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access the dashboard.');
        }
        
        // Check if user has member role
        if (Auth::user()->role !== 'member') {
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized access. Please login with correct credentials.');
        }
        
        return view('member.dashboard');
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

    /**
     * Get available PDF reports for member
     */
    public function getPdfReports()
    {
        try {
            $reports = [
                [
                    'id' => 'my-payments',
                    'title' => 'My Payment Records',
                    'description' => 'Complete payment history of your account',
                    'created_at' => now(),
                    'filename' => 'my_payment_records.pdf'
                ]
            ];

            return response()->json([
                'success' => true,
                'reports' => $reports
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching PDF reports: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate PDF for current user's payment records
     */
    public function generateMyPaymentsPdf()
    {
        try {
            // Get current user's payment records only
            $payments = Payment::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            // Create PDF using FPDF
            require_once base_path('fpdf186/fpdf.php');
            
            $pdf = new \FPDF();
            $pdf->AddPage();
            
            // Set font for header
            $pdf->SetFont('Times', 'B', 16);
            $pdf->SetTextColor(0, 0, 0);
            
            // Main title
            $pdf->Cell(0, 10, 'Tanzania Movements of Catholic Students - MY PAYMENT RECORDS', 0, 1, 'C');
            $pdf->Ln(5);
            
            // Report metadata
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(0, 6, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'L');
            $pdf->Cell(0, 6, 'Generated for: ' . Auth::user()->name, 0, 1, 'R');
            $pdf->Cell(0, 6, 'Report ID: TMCS-MP-' . date('YmdHis'), 0, 1, 'L');
            $pdf->Ln(10);
            
            // Personal Information
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'PERSONAL INFORMATION', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 10);
            
            $pdf->Cell(35, 6, 'User ID:', 0, 0, 'L');
            $pdf->Cell(65, 6, 'TMCS-' . str_pad(Auth::user()->id, 4, '0', STR_PAD_LEFT), 0, 0, 'L');
            $pdf->Cell(35, 6, 'Full Name:', 0, 0, 'L');
            $pdf->Cell(55, 6, Auth::user()->name, 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Email:', 0, 0, 'L');
            $pdf->Cell(65, 6, Auth::user()->email, 0, 0, 'L');
            $pdf->Cell(35, 6, 'Phone:', 0, 0, 'L');
            $pdf->Cell(55, 6, Auth::user()->phone_number ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Gender:', 0, 0, 'L');
            $pdf->Cell(65, 6, Auth::user()->gender ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Reg. No:', 0, 0, 'L');
            $pdf->Cell(65, 6, Auth::user()->registration_number ?? 'N/A', 0, 0, 'L');
            $pdf->Cell(35, 6, 'Diocese:', 0, 0, 'L');
            $pdf->Cell(55, 6, Auth::user()->home_diocese ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Year Study:', 0, 0, 'L');
            $pdf->Cell(65, 6, Auth::user()->year_of_study ?? 'N/A', 0, 0, 'L');
            $pdf->Ln(10);
            
            // Account Information
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'ACCOUNT INFORMATION', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 10);
            
            $pdf->Cell(35, 6, 'Role:', 0, 0, 'L');
            $pdf->Cell(65, 6, ucfirst(Auth::user()->role), 0, 0, 'L');
            $pdf->Cell(35, 6, 'Status:', 0, 0, 'L');
            $pdf->Cell(55, 6, Auth::user()->membership_status ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Joined:', 0, 0, 'L');
            $pdf->Cell(65, 6, Auth::user()->registration_date ? date('Y-m-d', strtotime(Auth::user()->registration_date)) : date('Y-m-d', strtotime(Auth::user()->created_at)), 0, 0, 'L');
            $pdf->Cell(35, 6, 'Updated:', 0, 0, 'L');
            $pdf->Cell(55, 6, date('Y-m-d', strtotime(Auth::user()->updated_at)), 0, 1, 'L');
            $pdf->Ln(10);
            
            // Payment Summary
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'PAYMENT SUMMARY', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 10);
            
            $totalAmount = $payments->where('status', 'completed')->sum('amount');
            $completedPayments = $payments->where('status', 'completed')->count();
            $pendingPayments = $payments->where('status', 'pending')->count();
            $rejectedPayments = $payments->where('status', 'rejected')->count();
            
            $pdf->Cell(40, 6, 'Total Payments:', 0, 0, 'L');
            $pdf->Cell(60, 6, $payments->count(), 0, 0, 'L');
            $pdf->Cell(40, 6, 'Total Amount:', 0, 0, 'L');
            $pdf->Cell(50, 6, 'TZS ' . number_format($totalAmount, 2), 0, 1, 'L');
            
            $pdf->Cell(40, 6, 'Completed:', 0, 0, 'L');
            $pdf->Cell(60, 6, $completedPayments, 0, 0, 'L');
            $pdf->Cell(40, 6, 'Pending:', 0, 0, 'L');
            $pdf->Cell(50, 6, $pendingPayments, 0, 1, 'L');
            
            $pdf->Cell(40, 6, 'Rejected:', 0, 0, 'L');
            $pdf->Cell(60, 6, $rejectedPayments, 0, 1, 'L');
            $pdf->Ln(10);
            
            // Payment Details Table
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'PAYMENT DETAILS', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            // Table headers
            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(40, 7, 'Date', 1, 0, 'C', true);
            $pdf->Cell(50, 7, 'Type', 1, 0, 'C', true);
            $pdf->Cell(60, 7, 'Amount', 1, 0, 'C', true);
            $pdf->Cell(40, 7, 'Status', 1, 1, 'C', true);
            
            // Table data
            $pdf->SetFont('Times', '', 9);
            $pdf->SetTextColor(0, 0, 0);
            
            foreach ($payments as $payment) {
                $pdf->Cell(40, 6, date('Y-m-d', strtotime($payment->created_at)), 1, 0, 'C');
                $pdf->Cell(50, 6, $payment->payment_type ?? 'N/A', 1, 0, 'C');
                $pdf->Cell(60, 6, 'TZS ' . number_format($payment->amount ?? 0, 2), 1, 0, 'R');
                $pdf->Cell(40, 6, ucfirst($payment->status ?? 'N/A'), 1, 1, 'C');
            }
            
            // Output PDF
            $filename = 'my_payment_records_' . date('YmdHis') . '.pdf';
            $filepath = public_path('reports/' . $filename);
            
            // Create reports directory if it doesn't exist
            if (!is_dir(public_path('reports'))) {
                mkdir(public_path('reports'), 0777, true);
            }
            
            $pdf->Output($filepath, 'F');
            
            return response()->json([
                'success' => true,
                'message' => 'PDF generated successfully',
                'filename' => $filename,
                'report_url' => url('reports/' . $filename)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate PDF for current user's information
     */
    public function generateMyInfoPdf()
    {
        try {
            // Get current user
            $user = Auth::user();
            
            // Get user's payment records for summary
            $payments = Payment::where('user_id', Auth::id())->get();

            // Create PDF using FPDF
            require_once base_path('fpdf186/fpdf.php');
            
            $pdf = new \FPDF();
            $pdf->AddPage();
            
            // Set font for header
            $pdf->SetFont('Times', 'B', 16);
            $pdf->SetTextColor(0, 0, 0);
            
            // Main title
            $pdf->Cell(0, 10, 'Tanzania Movements of Catholic Students - MY INFORMATION', 0, 1, 'C');
            $pdf->Ln(5);
            
            // Report metadata
            $pdf->SetFont('Times', '', 10);
            $pdf->Cell(0, 6, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'L');
            $pdf->Cell(0, 6, 'Generated for: ' . $user->name, 0, 1, 'R');
            $pdf->Cell(0, 6, 'Report ID: TMCS-MI-' . date('YmdHis'), 0, 1, 'L');
            $pdf->Ln(10);
            
            // Personal Information
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'PERSONAL INFORMATION', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 10);
            
            $pdf->Cell(35, 6, 'User ID:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->id, 0, 0, 'L');
            $pdf->Cell(35, 6, 'Full Name:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->name, 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Email:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->email, 0, 0, 'L');
            $pdf->Cell(35, 6, 'Phone:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->phone_number ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Gender:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->gender ?? 'N/A', 0, 0, 'L');
            $pdf->Cell(35, 6, 'Age:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->age ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Address:', 0, 0, 'L');
            $pdf->Cell(155, 6, $user->address ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'City:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->city ?? 'N/A', 0, 0, 'L');
            $pdf->Cell(35, 6, 'Country:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->country ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Reg. No:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->registration_number ?? 'N/A', 0, 0, 'L');
            $pdf->Cell(35, 6, 'Diocese:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->home_diocese ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Year Study:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->year_of_study ?? 'N/A', 0, 0, 'L');
            $pdf->Cell(35, 6, 'Age:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->age ?? 'N/A', 0, 1, 'L');
            $pdf->Ln(10);
            
            // Account Information
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'ACCOUNT INFORMATION', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 10);
            
            $pdf->Cell(35, 6, 'Role:', 0, 0, 'L');
            $pdf->Cell(65, 6, ucfirst($user->role), 0, 0, 'L');
            $pdf->Cell(35, 6, 'Status:', 0, 0, 'L');
            $pdf->Cell(55, 6, $user->membership_status ?? 'N/A', 0, 1, 'L');
            
            $pdf->Cell(35, 6, 'Joined:', 0, 0, 'L');
            $pdf->Cell(65, 6, $user->registration_date ? date('Y-m-d', strtotime($user->registration_date)) : date('Y-m-d', strtotime($user->created_at)), 0, 0, 'L');
            $pdf->Cell(35, 6, 'Updated:', 0, 0, 'L');
            $pdf->Cell(55, 6, date('Y-m-d', strtotime($user->updated_at)), 0, 1, 'L');
            $pdf->Ln(10);
            
            // Payment Summary
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'PAYMENT SUMMARY', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Times', '', 10);
            
            $totalAmount = $payments->where('status', 'completed')->sum('amount');
            $completedPayments = $payments->where('status', 'completed')->count();
            $pendingPayments = $payments->where('status', 'pending')->count();
            $rejectedPayments = $payments->where('status', 'rejected')->count();
            
            $pdf->Cell(40, 6, 'Total Payments:', 0, 0, 'L');
            $pdf->Cell(60, 6, $payments->count(), 0, 0, 'L');
            $pdf->Cell(40, 6, 'Total Amount:', 0, 0, 'L');
            $pdf->Cell(50, 6, 'TZS ' . number_format($totalAmount, 2), 0, 1, 'L');
            
            $pdf->Cell(40, 6, 'Completed:', 0, 0, 'L');
            $pdf->Cell(60, 6, $completedPayments, 0, 0, 'L');
            $pdf->Cell(40, 6, 'Pending:', 0, 0, 'L');
            $pdf->Cell(50, 6, $pendingPayments, 0, 1, 'L');
            
            $pdf->Cell(40, 6, 'Rejected:', 0, 0, 'L');
            $pdf->Cell(60, 6, $rejectedPayments, 0, 1, 'L');
            $pdf->Ln(10);
            
            // Recent Payment History (Last 10)
            $recentPayments = $payments->take(10);
            
            $pdf->SetFont('Times', 'B', 12);
            $pdf->SetFillColor(52, 152, 219);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(0, 8, 'RECENT PAYMENT HISTORY (Last 10)', 0, 1, 'L', true);
            $pdf->Ln(5);
            
            // Table headers
            $pdf->SetFont('Times', 'B', 10);
            $pdf->SetFillColor(200, 200, 200);
            $pdf->Cell(40, 7, 'Date', 1, 0, 'C', true);
            $pdf->Cell(50, 7, 'Type', 1, 0, 'C', true);
            $pdf->Cell(60, 7, 'Amount', 1, 0, 'C', true);
            $pdf->Cell(40, 7, 'Status', 1, 1, 'C', true);
            
            // Table data
            $pdf->SetFont('Times', '', 9);
            $pdf->SetTextColor(0, 0, 0);
            
            foreach ($recentPayments as $payment) {
                $pdf->Cell(40, 6, date('Y-m-d', strtotime($payment->created_at)), 1, 0, 'C');
                $pdf->Cell(50, 6, $payment->payment_type ?? 'N/A', 1, 0, 'C');
                $pdf->Cell(60, 6, 'TZS ' . number_format($payment->amount ?? 0, 2), 1, 0, 'R');
                $pdf->Cell(40, 6, ucfirst($payment->status ?? 'N/A'), 1, 1, 'C');
            }
            
            // Output PDF
            $filename = 'my_information_' . date('YmdHis') . '.pdf';
            $filepath = public_path('reports/' . $filename);
            
            // Create reports directory if it doesn't exist
            if (!is_dir(public_path('reports'))) {
                mkdir(public_path('reports'), 0777, true);
            }
            
            $pdf->Output($filepath, 'F');
            
            return response()->json([
                'success' => true,
                'message' => 'PDF generated successfully',
                'filename' => $filename,
                'report_url' => url('reports/' . $filename)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download PDF report
     */
    public function downloadPdfReport($reportId)
    {
        try {
            switch ($reportId) {
                case 'my-payments':
                    return $this->generateMyPaymentsPdf();
                case 'my-info':
                    return $this->generateMyInfoPdf();
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid report ID'
                    ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error downloading report: ' . $e->getMessage()
            ], 500);
        }
    }
}
