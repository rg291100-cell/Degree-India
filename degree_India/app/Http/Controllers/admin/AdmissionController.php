<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use App\Models\AdmissionFeePayment;
use App\Models\User;
use App\Models\Notification;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdmissionConfirmationMail;
use App\Mail\AdmissionRejectionMail;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Admission::with(['user', 'course']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('admission_status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by user name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admissions = $query->orderBy('created_at', 'desc')->paginate(20);

         $stats = [
        'pending' => Admission::where('admission_status', 'pending')->count(),
        'approved' => Admission::where('admission_status', 'approved')->count(),
        'completed' => Admission::where('admission_status', 'completed')->count(),
        'rejected' => Admission::where('admission_status', 'rejected')->count(),
    ];
        return view('admin.admission.pages.index', compact('admissions', 'stats'));
    }

    public function show($id)
    {
        $admission = Admission::with(['user', 'course', 'feePayments', 'feePayments.collector'])
            ->findOrFail($id);

        return view('admin.admission.pages.show', compact('admission'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'remarks' => 'nullable|string|max:500'
        ]);

        $admission = Admission::findOrFail($id);
        $oldStatus = $admission->admission_status;
        $admission->admission_status = $request->status;
        $admission->remarks = $request->remarks ?? $admission->remarks;
        $admission->save();

        // Send email notification and create in-app notification
        if (($request->status === 'approved' && !$admission->is_notified) || $request->status === 'completed') {
            Mail::to($admission->user->email)->send(new AdmissionConfirmationMail($admission));

            // Create notification for user
            Notification::create([
                'user_id' => $admission->user->id,
                'title' => $request->status === 'approved' ? 'Admission Approved' : 'Admission Completed',
                'message' => $request->status === 'approved' ? 'Your admission has been approved.' : 'Your admission process is completed.'
            ]);

            $admission->is_notified = true;
            $admission->save();
        } elseif ($request->status === 'rejected') {
            Mail::to($admission->user->email)->send(new AdmissionRejectionMail($admission));

            Notification::create([
                'user_id' => $admission->user->id,
                'title' => 'Admission Rejected',
                'message' => 'Your admission has been rejected. ' . ($request->remarks ?? '')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Admission status updated successfully');
    }

    public function createManualPayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_mode' => 'required|in:cash,cheque,bank_transfer,online',
            'payment_date' => 'required|date',
            'receipt_number' => 'nullable|string|unique:admission_fee_payments,receipt_number',
            'remarks' => 'nullable|string',
            'proof_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $admission = Admission::findOrFail($id);

        // Handle file upload
        $proofPath = null;
        if ($request->hasFile('proof_document')) {
            $proofPath = $request->file('proof_document')->store('payment_proofs', 'public');
        }

        // Create payment record
        $payment = AdmissionFeePayment::create([
            'admission_id' => $admission->id,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'payment_date' => $request->payment_date,
            'receipt_number' => $request->receipt_number,
            'remarks' => $request->remarks,
            'proof_document' => $proofPath,
            'collected_by' => auth()->id()
        ]);

        // Update admission payment status
        $admission->paid_amount += $request->amount;
        $admission->due_amount = $admission->total_fees - $admission->paid_amount;
        
        if ($admission->due_amount <= 0) {
            $admission->payment_status = 'paid';
            $admission->admission_status = 'completed';
        } else {
            $admission->payment_status = 'partially_paid';
        }
        
        $admission->save();

        // Create notification for payment
        Notification::create([
            'user_id' => $admission->user->id,
            'title' => 'Payment Received',
            'message' => 'Payment of ' . number_format($request->amount, 2) . ' recorded for your admission.'
        ]);

        // If this payment completed the admission, notify completion as well
        if ($admission->admission_status === 'completed') {
            Notification::create([
                'user_id' => $admission->user->id,
                'title' => 'Admission Completed',
                'message' => 'Your admission is now completed. Congratulations!'
            ]);
        }

        return redirect()->back()
            ->with('success', 'Payment recorded successfully');
    }

    public function generateAdmissionLetter($id)
    {
        $admission = Admission::with(['user', 'course'])->findOrFail($id);
        
        // Here you can generate PDF or view
        return view('admin.admission.pages.admission-letter', compact('admission'));
    }

    public function downloadAdmissionLetter($id)
    {
        $admission = Admission::with(['user', 'course'])->findOrFail($id);
        
        // Generate PDF using DomPDF or similar
        $pdf = \PDF::loadView('admin.admission.pages.admission-letter', compact('admission'));
        
        return $pdf->download("admission-letter-{$admission->id}.pdf");
    }

    public function getStats()
    {
        $stats = [
            'total' => Admission::count(),
            'pending' => Admission::where('admission_status', 'pending')->count(),
            'approved' => Admission::where('admission_status', 'approved')->count(),
            'completed' => Admission::where('admission_status', 'completed')->count(),
            'rejected' => Admission::where('admission_status', 'rejected')->count(),
            'total_revenue' => Admission::sum('paid_amount'),
            'pending_revenue' => Admission::sum('due_amount')
        ];

        return response()->json($stats);
    }
}