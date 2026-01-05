<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait UploadsFiles
{
    /**
     * Upload a file with a randomized name to a specific folder.
     *
     * @param UploadedFile $file The file object
     * @param string $folder The sub-folder name (e.g., 'logos')
     * @return string The relative path to the file
     */
    public function uploadFile(UploadedFile $file, string $folder): string
    {
        $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();

        $destinationPath = public_path('assets/' . $folder);

        $file->move($destinationPath, $filename);

        return 'assets/' . $folder . '/' . $filename;
    }
}