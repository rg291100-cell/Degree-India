<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WhyJoinFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhyJoinFeatureController extends Controller
{
    
    public function index()
    {
        $features = WhyJoinFeature::orderBy('order', 'asc')->get();
        return view('admin.why-join-features.index', compact('features'));
    }

   
    public function create()
    {
        return view('admin.why-join-features.create');
    }

   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        WhyJoinFeature::create([
            'title' => $request->title,
            'icon' => $request->icon,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.why-join-features.index')
            ->with('success', 'Feature created successfully!');
    }

    public function show(WhyJoinFeature $whyJoinFeature)
    {
        return view('admin.why-join-features.show', compact('whyJoinFeature'));
    }

    public function edit(WhyJoinFeature $whyJoinFeature)
    {
        return view('admin.why-join-features.edit', compact('whyJoinFeature'));
    }

    public function update(Request $request, WhyJoinFeature $whyJoinFeature)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:100',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $whyJoinFeature->update([
            'title' => $request->title,
            'icon' => $request->icon,
            'description' => $request->description,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.why-join-features.index')
            ->with('success', 'Feature updated successfully!');
    }

    public function destroy(WhyJoinFeature $whyJoinFeature)
    {
        $whyJoinFeature->delete();
        
        return redirect()->route('admin.why-join-features.index')
            ->with('success', 'Feature deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array'
        ]);

        foreach ($request->order as $index => $id) {
            WhyJoinFeature::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}