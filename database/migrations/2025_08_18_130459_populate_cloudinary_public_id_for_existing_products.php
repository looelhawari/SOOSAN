<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Services\CloudinaryService;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing products that have Cloudinary URLs to extract and store public_id
        $cloudinaryService = new CloudinaryService();

        Product::whereNotNull('image_url')
            ->whereNull('cloudinary_public_id')
            ->chunk(100, function ($products) use ($cloudinaryService) {
                foreach ($products as $product) {
                    if ($cloudinaryService->isCloudinaryUrl($product->image_url)) {
                        $publicId = $cloudinaryService->extractPublicId($product->image_url);
                        if ($publicId) {
                            $product->update(['cloudinary_public_id' => $publicId]);
                        }
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear cloudinary_public_id for rollback
        Product::whereNotNull('cloudinary_public_id')
            ->update(['cloudinary_public_id' => null]);
    }
};
