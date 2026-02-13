<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admission;
use App\Models\Course;
use App\Models\AdmissionFeePayment;
use App\Models\User;
use App\Models\College;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdmissionConfirmationMail;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AdmissionController extends Controller
{
    // Apply for admission
    public function applyForAdmission(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Please login first to update profile.'
            ], 401);
        }
        
            $validator = Validator::make($request->all(), [
                'course_id' => 'required|exists:courses,id',
                'payment_mode' => 'required|in:online,offline'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $course = Course::find($request->course_id);

            // Check if already applied
            $existingAdmission = Admission::where('user_id', $user->id)
                ->where('course_id', $request->course_id)
                ->whereIn('admission_status', ['pending', 'approved'])
                ->first();

            if ($existingAdmission) {
                return response()->json([
                    'status' => false,
                    'message' => 'You have already applied for this course'
                ], 400);
            }

            $admission = Admission::create([
                'user_id' => $user->id,
                'course_id' => $request->course_id,
                'total_fees' => $course->fees,
                'due_amount' => $course->fees,
                'payment_mode' => $request->payment_mode,
                'admission_date' => now(),
                'admission_status' => 'pending',
                'payment_status' => 'pending'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Admission application submitted successfully',
                'admission' => $admission
            ], 201);

       
    }

    
    public function getUserAdmissions()
    {
         try {
            $user = JWTAuth::parseToken()->authenticate();
            

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Please login first to update profile.'
            ], 401);
        }
            
            $admissions = Admission::with(['course', 'course.category', 'course.college'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $admissions = $admissions->map(function ($admission) {
                $collegeName = null;

                $collegeName = optional(optional($admission->course)->college)->name;

                if (!$collegeName && isset($admission->course->colleges) && $admission->course->colleges->isNotEmpty()) {
                    $collegeName = optional($admission->course->colleges->first())->name;
                }
                if (!$collegeName && optional($admission->course)->user_id) {
                    $owner = User::with('role')->find($admission->course->user_id);
                    if ($owner && optional($owner->role)->slug === 'college-admin') {
                        $college = College::where('user_id', $owner->id)->first();
                        $collegeName = optional($college)->name;
                    }
                }
                if (!$collegeName && optional($admission->course)->user_id) {
                    $college = College::where('user_id', $admission->course->user_id)->first();
                    $collegeName = optional($college)->name;
                }

                $admission->college_name = $collegeName;
                return $admission;
            });

            return response()->json([
                'status' => true,
                'message' => 'Admissions retrieved successfully',
                'admissions' => $admissions
            ]);

        
    }

    // Get admission details
    public function getAdmissionDetails($id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Please login first to update profile.'
            ], 401);
        }
            
            $admission = Admission::with(['course', 'course.category', 'feePayments'])
                ->where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            return response()->json([
                'status' => true,
                'message' => 'Admission details retrieved successfully',
                'admission' => $admission
            ]);

        
    }

    // Update payment (for offline payments)
    public function updateOfflinePayment(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1',
                'payment_mode' => 'required|in:cash,cheque,bank_transfer',
                'payment_date' => 'required|date',
                'receipt_number' => 'nullable|string',
                'remarks' => 'nullable|string',
                'proof_document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $admission = Admission::where('id', $id)
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Check if admission is approved
            if ($admission->admission_status !== 'approved') {
                return response()->json([
                    'status' => false,
                    'message' => 'Admission must be approved before making payment'
                ], 400);
            }

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
                'collected_by' => null // Will be set by admin
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

            return response()->json([
                'status' => true,
                'message' => 'Payment recorded successfully',
                'payment' => $payment,
                'admission' => $admission
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to record payment',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get fee payment history
    public function getFeePaymentHistory($admissionId)
    {
         try {
            $user = JWTAuth::parseToken()->authenticate();
            

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid. Please login again.'
            ], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Please login first to update profile.'
            ], 401);
        }
            
            $admission = Admission::where('id', $admissionId)
                ->where('user_id', $user->id)
                ->firstOrFail();

            $payments = AdmissionFeePayment::where('admission_id', $admissionId)
                ->orderBy('payment_date', 'desc')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Payment history retrieved successfully',
                'payments' => $payments,
                'summary' => [
                    'total_fees' => $admission->total_fees,
                    'paid_amount' => $admission->paid_amount,
                    'due_amount' => $admission->due_amount
                ]
            ]);

       
    }
}