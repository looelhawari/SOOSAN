<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validatedData = $request->validated();
        Log::info('Profile update request', ['user_id' => $user->id, 'data' => $validatedData]);

        try {
            // Handle image upload with Cloudinary
            if ($request->hasFile('profile_image')) {
                // Delete old image first
                if ($user->cloudinary_public_id) {
                    $this->cloudinaryService->deleteImage($user->cloudinary_public_id);
                } elseif ($user->image_url && file_exists(public_path($user->image_url))) {
                    @unlink(public_path($user->image_url));
                }

                try {
                    $uploadResult = $this->cloudinaryService->uploadImage($request->file('profile_image'), 'users');
                    if ($uploadResult) {
                        $validatedData['image_url'] = $uploadResult['url'];
                        $validatedData['cloudinary_public_id'] = $uploadResult['public_id'];
                    }
                } catch (\Exception $e) {
                    // If Cloudinary fails, fall back to local storage
                    $image = $request->file('profile_image');
                    $imageName = 'user_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('user_images'), $imageName);
                    $validatedData['image_url'] = 'user_images/' . $imageName;
                    $validatedData['cloudinary_public_id'] = null;
                }
            }

            // Fill user with validated data
            $user->fill($validatedData);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();
            Log::info('Profile updated successfully', ['user_id' => $user->id]);
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            Log::error('Profile update failed', ['error' => $e->getMessage()]);
            return Redirect::route('profile.edit')->withErrors(['profile_error' => 'Profile update failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete user's profile image from Cloudinary if it exists
        if ($user->cloudinary_public_id) {
            $this->cloudinaryService->deleteImage($user->cloudinary_public_id);
        } elseif ($user->image_url && file_exists(public_path($user->image_url))) {
            @unlink(public_path($user->image_url));
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's password securely.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        // Check current password
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }

        // Prevent using the same password
        if (Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => 'The new password must be different from the current password.'])->withInput();
        }

        // Update password
        $user->password = $request->input('password');
        $user->save();

        return back()->with('status', 'password-updated');
    }

    /**
     * AJAX endpoint to check if the given password matches the authenticated user's password.
     */
    public function checkPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = $request->user();
        if (\Hash::check($request->input('password'), $user->password)) {
            return response()->json(['valid' => true]);
        } else {
            return response()->json(['valid' => false, 'message' => 'Incorrect password'], 200);
        }
    }

    /**
     * Remove the user's profile image.
     */
    public function removeImage(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Delete image from Cloudinary if it exists
        if ($user->cloudinary_public_id) {
            $this->cloudinaryService->deleteImage($user->cloudinary_public_id);
        } elseif ($user->image_url && file_exists(public_path($user->image_url))) {
            // Delete local image file if it exists
            @unlink(public_path($user->image_url));
        }

        // Remove image references from database
        $user->image_url = null;
        $user->cloudinary_public_id = null;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'image-removed');
    }
}
