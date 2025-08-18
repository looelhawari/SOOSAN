<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    /**
     * Upload image to Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $publicId
     * @return array|null
     */
    public function uploadImage(UploadedFile $file, string $folder = 'products', string $publicId = null): ?array
    {
        try {
            // Log upload attempt
            Log::info('Cloudinary upload attempt', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_mime' => $file->getMimeType(),
                'folder' => $folder
            ]);

            $options = [
                'folder' => $folder,
                'resource_type' => 'image',
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto'
                ]
            ];

            if ($publicId) {
                $options['public_id'] = $publicId;
                $options['overwrite'] = true;
            }

            $uploadedFileUrl = Cloudinary::uploadApi()->upload($file->getRealPath(), $options);

            Log::info('Cloudinary upload successful', [
                'public_id' => $uploadedFileUrl['public_id'],
                'url' => $uploadedFileUrl['secure_url']
            ]);

            return [
                'url' => $uploadedFileUrl['secure_url'],
                'public_id' => $uploadedFileUrl['public_id'],
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Delete image from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function deleteImage(string $publicId): bool
    {
        try {
            $result = Cloudinary::uploadApi()->destroy($publicId);
            return $result['result'] === 'ok';
        } catch (\Exception $e) {
            Log::error('Cloudinary deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Extract public ID from Cloudinary URL
     *
     * @param string $url
     * @return string|null
     */
    public function extractPublicId(string $url): ?string
    {
        // Extract public ID from Cloudinary URL
        // Example: https://res.cloudinary.com/your-cloud/image/upload/v1234567890/products/image.jpg
        if (preg_match('/\/(?:v\d+\/)?(.+?)\.[^.]+$/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Check if URL is a Cloudinary URL
     *
     * @param string $url
     * @return bool
     */
    public function isCloudinaryUrl(string $url): bool
    {
        return str_contains($url, 'cloudinary.com');
    }
}
