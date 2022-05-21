<?php

namespace App\Traits;

trait FileHandling {

    function uploadFile($file, $path) : string {

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $time = now()->getTimestamp();

        $filename = "{$originalName}-{$time}.{$extension}";

        $file->storeAs($path, $filename, 'public');

        return $filename;
    }


}


