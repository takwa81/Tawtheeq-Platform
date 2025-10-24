<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

trait ImageHandler
{
    public function storeImage(UploadedFile $image, string $folder, string $lastName = null): string
    {
        $imagePath = (string)Str::uuid() . $lastName . '.' . $image->getClientOriginalExtension();
        $image->storeAs($folder, $imagePath, 'private');

        return $imagePath;
    }

    public function storeMultipleImages(array $images, string $folder): array
    {
        $imagePaths = [];

        foreach ($images as $image) {
            $imagePaths[] = $this->storeImage($image, $folder);
        }

        return $imagePaths;
    }


    public function updateImage(UploadedFile $image, ?string $oldImagePath, string $folder): string
    {
        if (!empty($oldImagePath) && Storage::disk('private')->exists($folder . '/' . $oldImagePath)) {
            Storage::disk('private')->delete($folder . '/' . $oldImagePath);
        }

        return $this->storeImage($image, $folder);
    }

    public function updateImageWithResize(UploadedFile $image, ?string $oldImagePath, string $folder): string
    {
        if (!empty($oldImagePath) && Storage::disk('private')->exists($folder . '/' . $oldImagePath)) {
            Storage::disk('private')->delete($folder . '/' . $oldImagePath);
        }

        return $this->storeImageWithResize($image, $folder);
    }

    /**
     * Store and resize an uploaded image
     *
     * @param UploadedFile $image The image file to process
     * @param string $folder The target storage folder
     * @param int $width The target width (height will maintain aspect ratio)
     * @return string The path to the stored image
     * @throws \Exception If image processing fails
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
                pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . ".{$extension}",
                $image->getClientMimeType(),
                null,
                true // Mark as test to prevent moving the file
            );
            $lastName = "_thumb";
            return $this->storeImage($resizedImage, $folder, $lastName);

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
