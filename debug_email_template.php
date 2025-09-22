<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Auto Reply Email Template - Full Debug...\n";

try {
    // Test rendering the email template
    $view = view('emails.auto-reply', [
        'senderName' => 'Test User',
        'senderEmail' => 'test@example.com', 
        'originalSubject' => 'Test Subject'
    ])->render();

    echo "✅ Template rendered successfully\n";
    
    // Show first 500 characters
    echo "\n📄 First 500 characters:\n";
    echo "=" . str_repeat("=", 50) . "\n";
    echo substr($view, 0, 500) . "\n";
    echo "=" . str_repeat("=", 50) . "\n";
    
    // Check various HTML elements
    echo "\n🔍 HTML Element Check:\n";
    echo "<!DOCTYPE html>: " . (strpos($view, '<!DOCTYPE html>') !== false ? 'YES' : 'NO') . "\n";
    echo "<html: " . (strpos($view, '<html') !== false ? 'YES' : 'NO') . "\n";
    echo "<body>: " . (strpos($view, '<body>') !== false ? 'YES' : 'NO') . "\n";
    echo "soosan_logo_en.svg: " . (strpos($view, 'soosan_logo_en.svg') !== false ? 'YES' : 'NO') . "\n";
    
    // Look for the logo image tag
    if (preg_match('/<img[^>]*src="([^"]*)"[^>]*alt="SOOSAN Egypt"/', $view, $matches)) {
        echo "🖼️ Logo image found with src: " . $matches[1] . "\n";
    } else {
        echo "❌ Logo image not found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\nDone!\n";