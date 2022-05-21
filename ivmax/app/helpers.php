<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (! function_exists('deleteFile')) {
    /**
     * Delete file at given path if it exists.
     *
     * @param string $path
     *
     * @return void
     */
    function deleteFile($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

if (! function_exists('uploadFile')) {
    /**
     * Upload given file to the specified path and return filename.
     *
     * @param string $path
     *
     * @return string
     */
    function uploadFile(UploadedFile $file, $path)
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $time = now()->getTimestamp();

        $originalName = str_replace(' ', '-', $originalName);

        $filename = "{$originalName}-{$time}.{$extension}";

        $file->storeAs($path, $filename, 'public');

        return '/media'.$path.'/'.$filename;
    }
}
