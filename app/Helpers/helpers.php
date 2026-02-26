<?php

if (!function_exists('storage_disk')) {
    function storage_disk(): string
    {
        return config('app.env') === 'production' ? 's3' : 'public';
    }
}

if (!function_exists('storage_url')) {
    function storage_url(?string $path): string
    {
        if (!$path) return '';

        return \Illuminate\Support\Facades\Storage::disk(storage_disk())->url($path);
    }
}
