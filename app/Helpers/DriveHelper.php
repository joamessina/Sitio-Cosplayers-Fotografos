<?php

namespace App\Helpers;

class DriveHelper
{
    /**
     * Extrae el ID de una URL de Google Drive y devuelve la URL embebible
     * 
     * Soporta URLs como:
     * - https://drive.google.com/drive/folders/FOLDER_ID
     * - https://drive.google.com/drive/u/0/folders/FOLDER_ID
     * - https://drive.google.com/file/d/FILE_ID/view
     * - https://drive.google.com/open?id=FILE_ID
     */
    public static function getEmbedUrl(?string $driveUrl): ?string
    {
        if (empty($driveUrl)) {
            return null;
        }

        // Intentar extraer ID de carpeta (folders)
        if (preg_match('/\/folders\/([a-zA-Z0-9_-]+)/', $driveUrl, $matches)) {
            $folderId = $matches[1];
            return "https://drive.google.com/embeddedfolderview?id={$folderId}#grid";
        }

        // Intentar extraer ID de archivo (file/d/)
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $driveUrl, $matches)) {
            $fileId = $matches[1];
            return "https://drive.google.com/file/d/{$fileId}/preview";
        }

        // Intentar extraer ID de open?id=
        if (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $driveUrl, $matches)) {
            $id = $matches[1];
            // Asumimos que es una carpeta por defecto
            return "https://drive.google.com/embeddedfolderview?id={$id}#grid";
        }

        // Si no pudo extraer nada, devolver null
        return null;
    }

    /**
     * Verifica si una URL es de Google Drive
     */
    public static function isDriveUrl(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return str_contains($url, 'drive.google.com');
    }
}