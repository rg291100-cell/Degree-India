<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Get all blogs
     */
    public function getBlogs()
    {
        $blogs = Blog::with(['user:id,name,email', 'category:id,name'])
                     ->latest()
                     ->get();

        return response()->json([
            'status' => true,
            'count'  => $blogs->count(),
            'data'   => $blogs,
        ]);
    }

    /**
     * Get single blog detail
     */
    public function getBlogDetail($blog_id = null)
    {
        // Validate blog_id
        $validator = Validator::make(
            ['blog_id' => $blog_id],
            ['blog_id' => 'required|exists:blogs,id']
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Fetch blog with user and category
        $blog = Blog::with(['user:id,name,email', 'category:id,name'])
                    ->find($blog_id);

        return response()->json([
            'status' => true,
            'data'   => $blog,
        ]);
    }
}
