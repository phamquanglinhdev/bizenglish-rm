<?php

namespace App\Untils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class EzUpload
{
    public static function uploadToStorage(UploadedFile $file, string $name, string $folders = ""): string
    {
        try {
            $file->move(public_path() . "/uploads" . $folders, $name);
        } finally {
            return "/uploads/" . $folders . "/" . $name;
        }
    }
}
