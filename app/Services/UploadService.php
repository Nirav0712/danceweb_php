<?php
namespace App\Services;

use App\Core\Logger;

class UploadService
{
    protected static array $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
        'image/svg+xml' => 'svg',
    ];

    protected static int $maxSizeBytes = 5242880; // 5MB

    public static function handleUpload(array $file, string $folder = 'uploads'): array
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'error' => 'Invalid file upload parameters.'];
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['success' => false, 'error' => 'No file was uploaded.'];
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['success' => false, 'error' => 'File exceeded maximum allowed size of 5MB.'];
            default:
                return ['success' => false, 'error' => 'Unknown upload error occurred.'];
        }

        if ($file['size'] > static::$maxSizeBytes) {
            return ['success' => false, 'error' => 'File exceeds maximum upload size (5MB).'];
        }

        // Validate MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        if (!array_key_exists($mime, static::$allowedMimes)) {
            return ['success' => false, 'error' => "Invalid file type: {$mime}. Only JPG, PNG, WEBP, GIF, and SVG are supported."];
        }

        $ext = static::$allowedMimes[$mime];
        $cleanFolder = trim(str_replace(['..', '/', '\\'], '', $folder));
        if (empty($cleanFolder)) {
            $cleanFolder = 'uploads';
        }

        $uploadDir = dirname(__DIR__, 2) . '/public/uploads/' . $cleanFolder;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uniqueName = bin2hex(random_bytes(16)) . '.' . $ext;
        $destination = $uploadDir . '/' . $uniqueName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            Logger::error("Failed to move uploaded file to: {$destination}");
            return ['success' => false, 'error' => 'Failed to save uploaded file to disk.'];
        }

        $publicUrl = '/uploads/' . $cleanFolder . '/' . $uniqueName;
        $imageInfo = @getimagesize($destination);

        return [
            'success' => true,
            'url' => $publicUrl,
            'original_filename' => basename($file['name'] ?? 'image.' . $ext),
            'filename' => $uniqueName,
            'format' => $ext,
            'bytes' => (int) $file['size'],
            'width' => $imageInfo ? (int) $imageInfo[0] : null,
            'height' => $imageInfo ? (int) $imageInfo[1] : null,
        ];
    }
}
