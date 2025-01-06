<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('fileUrl')) {
    function fileUrl(?string $path): ?string
    {
        if (is_null($path)) return null;

        return Storage::disk('public')->url($path);
    }
}
