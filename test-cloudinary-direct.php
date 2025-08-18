<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

try {
    echo "Testing Cloudinary configuration...\n";

    // Test configuration
    $config = config('filesystems.disks.cloudinary');
    echo "Config: " . json_encode($config) . "\n";

    // Test Cloudinary instance
    $cloudinary = app('Cloudinary\Cloudinary');
    echo "Cloudinary instance created successfully.\n";

    echo "Cloudinary integration should now work!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
