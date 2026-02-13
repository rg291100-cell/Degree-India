<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\College;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 

class UserController extends Controller
{
    // public function index()
    // {
    //     $users = User::with('role')->latest()->paginate(10);
    //     return view('admin.users.index', compact('users'));
    // }

   public function index()
    {
        $users = User::where('role_id', '!=', 2)
                    ->with('role')
                    ->latest()
                    ->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::where('slug', '!=', 'student')->get();
       
        return view('admin.users.create', compact('roles'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'career_interest' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        // Debug: Check if file is uploaded
        if ($request->hasFile('profile_picture')) {
            Log::info('File uploaded: ' . $request->file('profile_picture')->getClientOriginalName());
            Log::info('File size: ' . $request->file('profile_picture')->getSize());
            Log::info('File mime: ' . $request->file('profile_picture')->getMimeType());
        } else {
            Log::info('No file uploaded');
        }

        // Generate random password
        $password = Str::random(8);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'phone' => $request->phone,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'city' => $request->city,
            'state' => $request->state,
            'education_level' => $request->education_level,
            'career_interest' => $request->career_interest,
            'role_id' => $request->role_id,
            'status' => true,
            'is_admin' => 0,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            try {
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $userData['profile_picture'] = $path;
                Log::info('File stored at: ' . $path);
            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
            }
        }

        $user = User::create($userData);

        // Send email notification
        $user->notify(new NewUserNotification($user, $password));

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully. Login credentials sent to email.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'dob' => 'nullable|date',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'career_interest' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'boolean',
        ]);

        $userData = $request->except('_token', '_method');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $userData['profile_picture'] = $path;
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Delete profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function updateStatus(User $user)
    {
        $user->update(['status' => !$user->status]);
        return response()->json(['success' => true, 'status' => $user->status]);
    }
}