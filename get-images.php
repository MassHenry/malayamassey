<?php
/**
 * get-images.php
 * Dynamically reads images from the weekly-images folder
 * and returns them as a JSON array
 */

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

// Define the folder path where weekly images are stored
$imageFolder = 'weekly-images';

// Supported image extensions
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'JPG', 'JPEG', 'PNG', 'GIF', 'WEBP'];

// Initialize array to store image paths
$images = [];

// Check if the folder exists
if (!is_dir($imageFolder)) {
    // Return empty array if folder doesn't exist
    echo json_encode([]);
    exit;
}

// Open the directory
if ($handle = opendir($imageFolder)) {
    // Read all files in the directory
    while (false !== ($file = readdir($handle))) {
        // Skip . and .. directories
        if ($file != "." && $file != "..") {
            // Get file extension
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            
            // Check if file has an allowed image extension
            if (in_array($extension, $allowedExtensions)) {
                // Add the image path to array
                $images[] = $imageFolder . '/' . $file;
            }
        }
    }
    closedir($handle);
}

// Sort images by filename (newest first if named with dates)
rsort($images);

// Return JSON array of image paths
echo json_encode($images);
?>
