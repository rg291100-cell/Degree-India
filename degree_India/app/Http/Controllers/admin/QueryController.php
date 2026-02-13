<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    /**
     * Display a listing of queries.
     */
    public function index()
    {
        // Static data for demonstration
        $queries = [
            [
                'id' => 1,
                'name' => 'Rahul Sharma',
                'email' => 'rahul@example.com',
                'phone' => '9876543210',
                'course' => 'B.Tech Computer Science',
                'college' => 'Engineering College',
                'query_type' => 'Admission',
                'message' => 'What is the admission process for B.Tech?',
                'status' => 'Pending',
                'created_at' => '2024-01-15 10:30:00'
            ],
            [
                'id' => 2,
                'name' => 'Priya Patel',
                'email' => 'priya@example.com',
                'phone' => '9876543211',
                'course' => 'MBA Finance',
                'college' => 'Business School',
                'query_type' => 'Fees',
                'message' => 'What is the fee structure for MBA?',
                'status' => 'Resolved',
                'created_at' => '2024-01-14 14:20:00'
            ],
            [
                'id' => 3,
                'name' => 'Amit Kumar',
                'email' => 'amit@example.com',
                'phone' => '9876543212',
                'course' => 'B.Sc Physics',
                'college' => 'Science College',
                'query_type' => 'Course',
                'message' => 'What are the elective subjects available?',
                'status' => 'In Progress',
                'created_at' => '2024-01-13 11:45:00'
            ],
        ];

        return view('admin.query.index', compact('queries'));
    }

    /**
     * Show the form for creating a new query.
     */
    public function create()
    {
        return view('admin.query.create');
    }

    /**
     * Display the specified query.
     */
    public function show($id)
    {
        // Static data for demonstration
        $query = [
            'id' => $id,
            'name' => 'Rahul Sharma',
            'email' => 'rahul@example.com',
            'phone' => '9876543210',
            'course' => 'B.Tech Computer Science',
            'college' => 'Engineering College',
            'query_type' => 'Admission',
            'message' => 'What is the admission process for B.Tech? I would like to know the step-by-step procedure and required documents.',
            'status' => 'Pending',
            'created_at' => '2024-01-15 10:30:00',
            'response' => null
        ];

        return view('admin.query.show', compact('query'));
    }

    /**
     * Show the form for editing the specified query.
     */
    public function edit($id)
    {
        $query = [
            'id' => $id,
            'name' => 'Rahul Sharma',
            'email' => 'rahul@example.com',
            'phone' => '9876543210',
            'course' => 'B.Tech Computer Science',
            'college' => 'Engineering College',
            'query_type' => 'Admission',
            'message' => 'What is the admission process for B.Tech?',
            'status' => 'Pending'
        ];

        return view('admin.query.edit', compact('query'));
    }
}