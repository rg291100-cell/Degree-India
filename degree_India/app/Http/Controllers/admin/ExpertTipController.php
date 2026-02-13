<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertTip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpertTipController extends Controller
{
    
    public function index()
    {
        $expertTips = ExpertTip::latest()->paginate(10);
        return view('admin.expert-tips.index', compact('expertTips'));
    }

    
    public function create()
    {
        return view('admin.expert-tips.create');
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_link' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        // Handle manual thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('expert-tips/thumbnails', 'public');
        } else {
            // Auto-generate thumbnail from video link if no manual upload
            if (!empty($validated['video_link'])) {
                $expertTip = new ExpertTip();
                $expertTip->video_link = $validated['video_link'];
                $validated['thumbnail'] = $expertTip->generateThumbnailFromVideoLink();
            }
        }

        ExpertTip::create($validated);

        return redirect()->route('admin.expert-tips.index')
            ->with('success', 'Expert tip created successfully.');
    }

    // Update method bhi update karo
    public function update(Request $request, ExpertTip $expertTip)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_link' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($expertTip->thumbnail && Storage::disk('public')->exists($expertTip->thumbnail)) {
                Storage::disk('public')->delete($expertTip->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('expert-tips/thumbnails', 'public');
        } elseif ($request->has('remove_thumbnail') && $request->remove_thumbnail) {
            // Remove thumbnail if checkbox is checked
            if ($expertTip->thumbnail && Storage::disk('public')->exists($expertTip->thumbnail)) {
                Storage::disk('public')->delete($expertTip->thumbnail);
            }
            $validated['thumbnail'] = null;
        } elseif (!empty($validated['video_link']) && $expertTip->isDirty('video_link')) {
            // Auto-generate thumbnail if video link changed
            $validated['thumbnail'] = $expertTip->generateThumbnailFromVideoLink();
        }

        $expertTip->update($validated);

        return redirect()->route('admin.expert-tips.index')
            ->with('success', 'Expert tip updated successfully.');
    }

   
    public function show(ExpertTip $expertTip)
    {
        return view('admin.expert-tips.show', compact('expertTip'));
    }

   
    public function edit(ExpertTip $expertTip)
    {
        return view('admin.expert-tips.edit', compact('expertTip'));
    }

   
    

    
    public function destroy(ExpertTip $expertTip)
    {
        // Delete thumbnail if exists
        if ($expertTip->thumbnail && Storage::disk('public')->exists($expertTip->thumbnail)) {
            Storage::disk('public')->delete($expertTip->thumbnail);
        }

        $expertTip->delete();

        return redirect()->route('admin.expert-tips.index')
            ->with('success', 'Expert tip deleted successfully.');
    }

    
    public function regenerateThumbnail(ExpertTip $expertTip)
    {
        if ($expertTip->video_link) {
            $expertTip->update([
                'thumbnail' => $expertTip->generateThumbnailFromVideoLink()
            ]);

            return back()->with('success', 'Thumbnail regenerated successfully.');
        }

        return back()->with('error', 'No video link available to regenerate thumbnail.');
    }
}