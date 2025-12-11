<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Local file uploader used instead of the real Cloudinary SDK.
 * It keeps the same service name so the existing controllers continue to work,
 * but files are stored in public/uploads on the same machine.
 */
class CloudinaryUploader
{
    public function __construct(string $cloudinaryUrl = '')
    {
        // The constructor keeps the same signature but we ignore the URL:
        // this implementation writes files locally instead of using Cloudinary.
    }

    /**
     * Upload a logo for a sponsor / partenaire under public/uploads/logos.
     * Returns the public path (to be used in Twig <img src="...">).
     */
    public function uploadSponsorLogo(UploadedFile $file): string
    {
        $targetDir = __DIR__ . '/../../public/uploads/logos';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $extension = $file->guessExtension() ?: 'bin';
        $filename  = uniqid('sponsor_', true) . '.' . $extension;

        $file->move($targetDir, $filename);

        return '/uploads/logos/' . $filename;
    }

    /**
     * Upload an image for a publicité under public/uploads/publicites.
     * Returns the public path.
     */
    public function uploadPubliciteImage(UploadedFile $file): string
    {
        $targetDir = __DIR__ . '/../../public/uploads/publicites';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $extension = $file->guessExtension() ?: 'bin';
        $filename  = uniqid('pub_', true) . '.' . $extension;

        $file->move($targetDir, $filename);

        return '/uploads/publicites/' . $filename;
    }
}
