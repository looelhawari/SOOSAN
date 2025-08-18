<?php

use Illuminate\Support\Facades\Route;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/test-cloudinary', function () {
    try {
        // Test basic Cloudinary connection
        $config = config('cloudinary');

        return response()->json([
            'status' => 'success',
            'message' => 'Cloudinary configuration loaded',
            'config' => [
                'cloud_url_set' => !empty($config['cloud_url']),
                'upload_preset_set' => !empty($config['upload_preset']),
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

Route::post('/test-cloudinary-upload', function (Request $request) {
    try {
        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'No file uploaded']);
        }

        $file = $request->file('image');

        // Log the attempt
        Log::info('Testing Cloudinary upload', [
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType()
        ]);

        // Simple upload test
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
            'folder' => 'test',
            'resource_type' => 'image'
        ]);

        Log::info('Cloudinary upload successful', [
            'public_id' => $uploadedFileUrl->getPublicId(),
            'url' => $uploadedFileUrl->getSecurePath()
        ]);

        return response()->json([
            'status' => 'success',
            'url' => $uploadedFileUrl->getSecurePath(),
            'public_id' => $uploadedFileUrl->getPublicId()
        ]);

    } catch (\Exception $e) {
        Log::error('Cloudinary upload failed', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
});
