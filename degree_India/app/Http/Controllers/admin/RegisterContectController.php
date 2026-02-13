<?php
// app/Http\Controllers\Admin\RegisterContectController.php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RegisterContect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterContectController extends Controller
{
    // Show main page (always shows record with id=1)
    public function index()
    {
        $content = RegisterContect::where('id', 1)->first();
        
        return view('admin.register-contect.index', compact('content'));
    }

    // Create/Edit page
    public function create(Request $request)
    {
        $entries = RegisterContect::latest()->get();
        $editEntry = null;
        
        if ($request->has('edit')) {
            $editEntry = RegisterContect::find($request->edit);
        }
        
        return view('admin.register-contect.create', compact('entries', 'editEntry'));
    }

    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'location_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'name_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'phone_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'email_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'otp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    $data = ['date' => $request->date];

    // Handle image uploads
    $imageFields = ['location_image', 'name_image', 'phone_image', 'email_image', 'otp_image'];
    
    foreach ($imageFields as $field) {
        if ($request->hasFile($field)) {
            $data[$field] = $request->file($field)->store('register-contect', 'public');
        }
    }

    // Always update/create record with id=1
    RegisterContect::updateOrCreate(
        ['id' => 1],
        $data
    );

    return redirect()->route('admin.register-contect.create')
                     ->with('success', 'Contact information with images saved successfully!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'date' => 'required|date',
        'location_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'name_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'phone_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'email_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'otp_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    $entry = RegisterContect::findOrFail($id);
    $data = ['date' => $request->date];

    // Handle image uploads (only if new image is provided)
    $imageFields = ['location_image', 'name_image', 'phone_image', 'email_image', 'otp_image'];
    
    foreach ($imageFields as $field) {
        if ($request->hasFile($field)) {
            // Delete old image if exists
            if ($entry->$field && Storage::disk('public')->exists($entry->$field)) {
                Storage::disk('public')->delete($entry->$field);
            }
            // Store new image
            $data[$field] = $request->file($field)->store('register-contect', 'public');
        }
    }

    $entry->update($data);

    return redirect()->route('admin.register-contect.create')
                    ->with('success', 'Contact information updated successfully!');
}

}