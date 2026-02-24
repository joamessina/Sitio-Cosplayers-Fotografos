<?php

if (!function_exists('storage_url')) {
    function storage_url(?string $path): string
    {
        if (!$path) return '';
        return \Illuminate\Support\Facades\Storage::disk('s3')->url($path);
    }
}
