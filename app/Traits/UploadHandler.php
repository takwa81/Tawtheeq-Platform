<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadHandler
{
    public function storeFile(UploadedFile $file, string $folder, ?string $lastName = '_attachment'): string
    {
        $imagePath = (string)Str::uuid() . $lastName . '.' . $file->getClientOriginalExtension();
        $file->storeAs($folder, $imagePath, 'private');

        return $imagePath;
    }

    public function storeMultipleFiles(array $files, string $folder): array
    {
        $filePaths = [];

        foreach ($files as $file) {
            $filePaths[] = $this->storeFile($file, $folder);
        }

        return $filePaths;
    }

    public function updateFile(UploadedFile $file, ?string $oldFilePath, string $folder): string
    {
        if (!empty($oldFilePath) && Storage::disk('private')->exists($folder . '/' . $oldFilePath)) {
            Storage::disk('private')->delete($folder . '/' . $oldFilePath);
        }
        return $this->storeFile($file, $folder);
    }

    public function deleteFile(string $filePath, string $folder)
    {
        if (!empty($oldFilePath) && Storage::disk('private')->exists($folder . '/' . $oldFilePath)) {
            Storage::disk('private')->delete($folder . '/' . $filePath);
        }
    }
}
