<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class StudentController extends Controller
{
    public function index()
    {
        $students = User::where('role_id', 2)  
                        ->withCount('bookings')
                        ->latest()
                        ->get();
        
        return view('admin.students.index', compact('students'));  
    }

    public function show($id)
    {
        try {
            Log::info('Showing student with ID: ' . $id);
            
            $student = User::where('role_id', 2)
                           ->with(['bookings'])
                           ->findOrFail($id);
            
            Log::info('Student found: ' . $student->name);
            
            return view('admin.students.show', compact('student'));
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Student not found: ' . $id);
            
            return redirect()->route('admin.students.index')
                ->with('error', 'Student not found.');
        }
    }

    public function destroy($id)
    {
        try {
            $student = User::where('role_id', 2)->findOrFail($id);
            
            if ($student->bookings()->exists()) {
                return redirect()->route('admin.students.index')
                    ->with('error', 'Cannot delete student with existing bookings. Delete bookings first.');
            }
            
            $student->delete();
            
            return redirect()->route('admin.students.index')
                ->with('success', 'Student deleted successfully.');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Student not found.');
        }
    }
}