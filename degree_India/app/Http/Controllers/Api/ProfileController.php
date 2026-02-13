<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
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

        // सभी fields nullable बनाएं (id को छोड़कर)
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'nullable|string|max:20|unique:users,phone,' . $user->id,
            'dob' => 'nullable|date|before:today',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'education_level' => 'nullable|string|max:100',
            'career_interest' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // सिर्फ provided fields लें
        $data = [];
        $fields = [
            'name', 
            'gender', 
            'phone', 
            'dob',
            'city',
            'state',
            'education_level',
            'career_interest'
        ];

        foreach ($fields as $field) {
            if ($request->has($field) && $request->input($field) !== null) {
                $data[$field] = $request->input($field);
            }
        }

        if ($request->hasFile('profile_image')) {
            Log::info('Profile image upload started for user: ' . $user->id);

            $file = $request->file('profile_image');
            Log::info('File details:', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            try {
                // Delete old image if exists
                if ($user->profile_picture) {
                    $oldImagePath = str_replace('/storage/', '', $user->profile_picture);
                    Storage::disk('public')->delete($oldImagePath);
                    Log::info('Old image deleted: ' . $oldImagePath);
                }

                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

                // 'profiles' folder में store करें
                $imagePath = $file->storeAs('profiles', $filename, 'public');
                Log::info('Image stored at: ' . $imagePath);

                if (Storage::disk('public')->exists($imagePath)) {
                    Log::info('File verified to exist in public disk');
                } else {
                    Log::error('File not found after storage: ' . $imagePath);
                }

                // ✅ यहाँ सिर्फ filename store करें, पूरा path नहीं
                // Format: profiles/profile_15_1769667823.jpg
                $data['profile_picture'] = $imagePath; // 'profiles/profile_15_1769667823.jpg'

            } catch (\Exception $e) {
                Log::error('Image upload error for user ' . $user->id . ': ' . $e->getMessage());
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to upload image: ' . $e->getMessage()
                ], 500);
            }
        }

        // सिर्फ अगर data है तो update करें
        if (!empty($data)) {
            $user->update($data);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully'
            
        ], 200);
    }

    public function getProfile()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'status' => true,
                'message' => 'Profile retrieved successfully',
                'user' => $user,
                'user_type' => (($user->role_id == 2) ? 'student' : ''),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfileImage(Request $request)
    {
        try {
            // Authenticate user via JWT
            $user = JWTAuth::parseToken()->authenticate();
            
            Log::info('Profile image update requested for user ID: ' . $user->id);

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired. Please login again.'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid. Please login again.'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Please login first to update profile.'
            ], 401);
        }

        // Validate only image
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
        ], [
            'profile_image.required' => 'Please select an image to upload',
            'profile_image.image' => 'The file must be an image',
            'profile_image.mimes' => 'Only JPEG, PNG, JPG, GIF, WEBP images are allowed',
            'profile_image.max' => 'Image size should not exceed 5MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Get the uploaded file
            $file = $request->file('profile_image');
            
            Log::info('File details:', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension()
            ]);

            // Delete old image if exists
            if ($user->profile_picture && $user->profile_picture != 'default.png') {
                $oldImagePath = str_replace('/storage/', '', $user->profile_picture);
                
                // Check different possible paths
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                    Log::info('Old image deleted: ' . $oldImagePath);
                } else {
                    Log::warning('Old image not found in storage: ' . $oldImagePath);
                }
            }

            // Generate unique filename
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store image in 'profiles' folder
            $imagePath = $file->storeAs('profiles', $filename, 'public');
            
            Log::info('Image stored at: ' . $imagePath);
            
            // Verify file was stored
            if (!Storage::disk('public')->exists($imagePath)) {
                throw new \Exception('Failed to store image on server');
            }

            // Update user's profile picture in database
            // ✅ Format: profiles/profile_15_1769667823.jpg
            $user->profile_picture = $imagePath;
            $user->save();

            Log::info('Profile image updated successfully for user: ' . $user->id);

            return response()->json([
                'status' => true,
                'message' => 'Profile image updated successfully',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_picture' => $user->profile_picture // 'profiles/profile_15_1769667823.jpg'
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Profile image update error for user ' . $user->id . ': ' . $e->getMessage());
            
            return response()->json([
                'status' => false,
                'message' => 'Failed to update profile image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}