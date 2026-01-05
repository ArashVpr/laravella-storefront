<?php

use App\Models\Car;
use Illuminate\Support\Facades\Storage;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🖼️  Testing Image Optimization Pipeline\n";
echo "=======================================\n\n";

// Get a test car
$car = Car::first();
if (!$car) {
    echo "❌ No cars found in database. Please create a car first.\n";
    exit(1);
}

echo "✓ Test Car: {$car->getTitle()} (ID: {$car->id})\n\n";

// Create a test image
echo "📸 Creating test image...\n";
$testImagePath = storage_path('app/test-car-image.jpg');

// Create a simple test image using GD
$width = 1920;
$height = 1080;
$image = imagecreatetruecolor($width, $height);

// Fill with blue background
$blue = imagecolorallocate($image, 30, 144, 255);
imagefill($image, 0, 0, $blue);

// Add some text
$white = imagecolorallocate($image, 255, 255, 255);
$text = "Test Car Image - {$car->getTitle()}";
imagestring($image, 5, 50, 50, $text, $white);
imagestring($image, 3, 50, 100, "Original: {$width}x{$height}", $white);

// Save the image
imagejpeg($image, $testImagePath, 90);
imagedestroy($image);

echo "✓ Test image created: " . round(filesize($testImagePath) / 1024, 2) . " KB\n\n";

// Add media to car
echo "📤 Uploading image to car...\n";
try {
    $media = $car->addMedia($testImagePath)
        ->preservingOriginal()
        ->toMediaCollection('images');
    
    echo "✓ Image uploaded successfully (Media ID: {$media->id})\n\n";
} catch (Exception $e) {
    echo "❌ Error uploading image: {$e->getMessage()}\n";
    exit(1);
}

// Check generated conversions
echo "🔄 Generated Conversions:\n";
echo "------------------------\n";

$conversions = ['thumbnail', 'medium', 'large', 'thumbnail-webp', 'medium-webp', 'large-webp'];
$totalSavings = 0;
$originalSize = filesize($testImagePath);

foreach ($conversions as $conversion) {
    try {
        $url = $media->getUrl($conversion);
        $path = $media->getPath($conversion);
        
        if (file_exists($path)) {
            $size = filesize($path);
            $dimensions = @getimagesize($path);
            $dimensionStr = $dimensions ? "{$dimensions[0]}x{$dimensions[1]}" : 'N/A';
            $sizeKB = round($size / 1024, 2);
            $savings = $originalSize - $size;
            $savingsPercent = round(($savings / $originalSize) * 100, 1);
            $totalSavings += $savings;
            
            echo "  ✅ {$conversion}:\n";
            echo "     Size: {$sizeKB} KB (saved {$savingsPercent}%)\n";
            echo "     Dimensions: {$dimensionStr}\n";
            echo "     URL: {$url}\n\n";
        } else {
            echo "  ⏳ {$conversion}: Queued for generation\n\n";
        }
    } catch (Exception $e) {
        echo "  ❌ {$conversion}: Error - {$e->getMessage()}\n\n";
    }
}

// Summary
echo "📊 Summary:\n";
echo "===========\n";
echo "Original Image: " . round($originalSize / 1024, 2) . " KB\n";
echo "Total Space Saved: " . round($totalSavings / 1024, 2) . " KB\n";
echo "Conversions Generated: " . count($conversions) . "\n";
echo "Media Collection: {$media->collection_name}\n";
echo "Media MIME Type: {$media->mime_type}\n\n";

// Test getting media
echo "📁 All Car Images:\n";
echo "------------------\n";
$allMedia = $car->getMedia('images');
echo "Total images in collection: {$allMedia->count()}\n";
foreach ($allMedia as $idx => $mediaItem) {
    echo "  " . ($idx + 1) . ". {$mediaItem->file_name} ({$mediaItem->human_readable_size})\n";
}

echo "\n✅ Image Optimization Test Complete!\n\n";

echo "🧹 Cleanup:\n";
echo "To remove test media, run:\n";
echo "  php artisan tinker --execute=\"App\\Models\\Car::find({$car->id})->clearMediaCollection('images');\"\n\n";

echo "🔍 To view conversions, check:\n";
echo "  storage/app/public/media/\n";
