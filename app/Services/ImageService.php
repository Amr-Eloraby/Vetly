<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public static function upload($image, $folder)
    {
        return $image->store($folder, 'public');
    }

    public static function delete($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public static function url($path)
    {
        return $path ? url('storage/' . $path) : null;
    }
}