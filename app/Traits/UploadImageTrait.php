<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait UploadImageTrait
{
    public function uploadImage(Request $request, string $fieldName, string $folder = 'uploads'): ?string
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($folder, $filename, 'public');
            return $filename;
        }

        return null;
    }
}
