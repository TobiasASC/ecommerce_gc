<?php

namespace App\Support;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaStorage
{
    public static function store(UploadedFile $file, string $folder = 'img/productos'): ?string
    {
        if (! $file || ! $file->isValid()) {
            return null;
        }

        $cloudinaryUrl = env('CLOUDINARY_URL');
        $isProduction = in_array(app()->environment(), ['production', 'staging'], true);

        // En producción SIEMPRE requiere Cloudinary
        if ($isProduction) {
            if (empty($cloudinaryUrl)) {
                throw new \RuntimeException('CLOUDINARY_URL no está configurado en producción');
            }
            
            try {
                $cloudinary = new Cloudinary($cloudinaryUrl);
                $result = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => self::normalizeFolder($folder),
                        'resource_type' => 'image',
                    ]
                );

                return $result['secure_url'] ?? null;
            } catch (\Throwable $e) {
                logger()->error('Error al subir a Cloudinary en producción', [
                    'error' => $e->getMessage(),
                    'folder' => $folder,
                ]);
                throw $e;
            }
        }

        // En local: usar Cloudinary si está disponible, si no usar filesystem local
        if (!empty($cloudinaryUrl)) {
            try {
                $cloudinary = new Cloudinary($cloudinaryUrl);
                $result = $cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder' => self::normalizeFolder($folder),
                        'resource_type' => 'image',
                    ]
                );

                return $result['secure_url'] ?? null;
            } catch (\Throwable $e) {
                logger()->warning('Fallo al subir a Cloudinary en local, usando fallback local', [
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Fallback local solo en desarrollo
        $destination = public_path($folder);
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $filename);

        return $folder . '/' . $filename;
    }

    public static function delete(?string $path): void
    {
        if (empty($path) || self::isRemoteUrl($path)) {
            return;
        }

        $fullPath = public_path($path);
        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }

    public static function resolveUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }

        return self::isRemoteUrl($path) ? $path : asset($path);
    }

    public static function isRemoteUrl(?string $path): bool
    {
        return is_string($path) && filter_var($path, FILTER_VALIDATE_URL) !== false;
    }

    private static function normalizeFolder(string $folder): string
    {
        return str_replace('\\', '/', trim($folder, '/'));
    }
}
