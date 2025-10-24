# Image Resize with Intervention Image

## Installation

1. Install the package:
   ```bash
   composer require intervention/image:^2.7
   ```

2. Publish the configuration:
   ```bash
   php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"
   ```

## Configuration

Add the service provider and facade to `config/app.php`:

```php
'providers' => [
    // Other Service Providers...
    Intervention\Image\ImageServiceProvider::class,
],

'aliases' => [
    // Other Aliases...
    'Image' => Intervention\Image\Facades\Image::class,
],
```

## Usage

### Image Handler Trait

Create a new trait `app/Traits/ImageHandler.php`:

```php
<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ImageHandler
{
    /**
     * Store an uploaded image
     */
    public function storeImage(UploadedFile $image, string $folder): string
    {
        $imagePath = (string) Str::uuid() . '.' . $image->getClientOriginalExtension();
        $image->storeAs($folder, $imagePath, 'private');
        return $imagePath;
    }

    /**
     * Store and resize an image
     */
    public function storeImageWithResize(UploadedFile $image, string $folder, int $width = 330): string
    {
        $extension = $image->getClientOriginalExtension();
        $tempPath = tempnam(sys_get_temp_dir(), 'img_') . '.' . $extension;
        
        try {
            // Process the image
            $img = Image::make($image->getRealPath())
                ->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            
            // Save with the correct format and quality
            $img->save($tempPath, 90);

            // Create a new UploadedFile instance for the processed image
            $resizedImage = new UploadedFile(
                $tempPath,
                pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . "_thumb.{$extension}",
                $image->getClientMimeType(),
                null,
                true // Mark as test to prevent moving the file
            );

            return $this->storeImage($resizedImage, $folder);
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to process image: " . $e->getMessage());
        } finally {
            // Clean up the temporary file
            if (file_exists($tempPath)) {
                @unlink($tempPath);
            }
        }
    }
}
```

### How to Use in a Controller

```php
use App\Traits\ImageHandler;

class YourController extends Controller
{
    use ImageHandler;

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // Max 5MB
        ]);

        try {
            // Store original image
            $imagePath = $this->storeImage(
                $request->file('image'),
                'your-folder-name'
            );

            // Store resized thumbnail
            $thumbnailPath = $this->storeImageWithResize(
                $request->file('image'),
                'your-folder-name/thumbnails',
                330 // Optional: custom width, defaults to 330px
            );

            return response()->json([
                'success' => true,
                'image_path' => $imagePath,
                'thumbnail_path' => $thumbnailPath
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
```

### Features

1. **Image Upload**
   - Stores original image with a unique UUID filename
   - Saves to private storage by default

2. **Image Resizing**
   - Maintains aspect ratio
   - Prevents upsizing smaller images
   - Saves with 90% quality
   - Creates thumbnails with "_thumb" suffix

3. **Error Handling**
   - Proper cleanup of temporary files
   - Detailed error messages
   - File existence checks

4. **Flexible**
   - Customizable output folder
   - Configurable width (height auto-calculated)
   - Works with any image type supported by Intervention Image
