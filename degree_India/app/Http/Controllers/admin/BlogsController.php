<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    public function index(Request $request)
    {
        $adminRoles = ['super-admin', 'counselor', 'college-admin'];
        $user = Auth::user();
        
        // Role-based condition
        if (in_array($user->role->slug, ['super-admin', 'counselor'])) {
            // Show all blogs for super-admin and counselor
            $blogs = Blog::with(['user', 'category'])
                        ->latest()->get();
        } else {
            // For college-admin, show only their own blogs
            $blogs = Blog::with(['user', 'category'])
                        ->where('user_id', $user->id)
                        ->latest()->get();
        }
        
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string'
        ]);

        $seoFields = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords ? explode(',', $request->meta_keywords) : []
        ];

        $data = $request->only(['title', 'excerpt', 'content', 'category_id']);
        $data['seo_fields'] = $seoFields;
        $data['user_id'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $imagePath;
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        $this->authorizeBlogAccess($blog);
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $this->authorizeBlogAccess($blog);
        $categories = Category::where('status', 'active')->get();
        
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->authorizeBlogAccess($blog);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string'
        ]);

        $seoFields = [
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords ? explode(',', $request->meta_keywords) : []
        ];

        $data = $request->only(['title', 'excerpt', 'content', 'category_id', 'status']);
        $data['seo_fields'] = $seoFields;

        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            
            $imagePath = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = $imagePath;
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $this->authorizeBlogAccess($blog);
        
        // Delete featured image if exists
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }

    public function updateStatus(Request $request, Blog $blog)
    {
        $this->authorizeBlogAccess($blog);
        
        $request->validate([
            'status' => 'required|in:draft,published,archived'
        ]);

        $blog->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    private function authorizeBlogAccess(Blog $blog)
    {
        $user = Auth::user();

        $role = Role::find($user->role_id);

        if (
            !in_array($role->slug, ['super-admin', 'counselor', 'college-admin']) &&
            $blog->user_id !== $user->id
        ) {
            abort(403, 'Unauthorized access.');
        }
    }

}