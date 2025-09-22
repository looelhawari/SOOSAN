<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Auto Reply Email Template...\n";

try {
    // Test rendering the email template
    $view = view('emails.auto-reply', [
        'senderName' => 'Test User',
        'senderEmail' => 'test@example.com', 
        'originalSubject' => 'Test Subject'
    ])->render();

    echo "✅ Template rendered successfully\n";
    echo "📏 Template length: " . strlen($view) . " characters\n";
    echo "🖼️ Contains logo: " . (strpos($view, 'soosan_logo_en.svg') !== false ? 'YES' : 'NO') . "\n";
    echo "🎨 Contains HTML: " . (strpos($view, '<html>') !== false ? 'YES' : 'NO') . "\n";
    
    // Check if it's using the correct logo URL
    if (preg_match('/src="([^"]*soosan_logo_en\.svg[^"]*)"/', $view, $matches)) {
        echo "🔗 Logo URL: " . $matches[1] . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";