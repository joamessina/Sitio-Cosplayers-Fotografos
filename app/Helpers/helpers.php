<?php

if (!function_exists('storage_url')) {
    function storage_url(?string $path): string
    {
        if (!$path) return '';

        // Local: usar disco 'public', Producción: usar disco 's3'
        $disk = config('app.env') === 'production' ? 's3' : 'public';

        return \Illuminate\Support\Facades\Storage::disk($disk)->url($path);
    }
}
