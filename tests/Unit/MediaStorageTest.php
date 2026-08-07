<?php

uses(Tests\TestCase::class);

use App\Support\MediaStorage;
use Illuminate\Http\UploadedFile;

describe('MediaStorage', function () {
    it('guarda la imagen localmente cuando no hay Cloudinary configurado', function () {
        $tempFile = tempnam(sys_get_temp_dir(), 'img');
        file_put_contents($tempFile, 'fake-image-content');

        $uploadedFile = new UploadedFile(
            $tempFile,
            'producto.png',
            'image/png',
            null,
            true
        );

        $path = MediaStorage::store($uploadedFile, 'img/productos');

        expect($path)->toStartWith('img/productos/');
        expect(file_exists(public_path($path)))->toBeTrue();

        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
    });

    it('devuelve la url original cuando ya es una url remota', function () {
        expect(MediaStorage::resolveUrl('https://res.cloudinary.com/demo/image.jpg'))
            ->toBe('https://res.cloudinary.com/demo/image.jpg');
    });
});
