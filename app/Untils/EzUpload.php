<?php

namespace App\Untils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class EzUpload
{
    public static function uploadToStorage(UploadedFile $file, string $name, string $folders = ""): string
    {
        $file->move(public_path() . "/uploads" . $folders, $name);
        return "/uploads/" . $folders . "/" . $name;
    }
}
