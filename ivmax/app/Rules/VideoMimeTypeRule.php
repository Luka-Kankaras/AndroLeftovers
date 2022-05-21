<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VideoMimeTypeRule implements Rule {

    public function __construct() {
        //
    }

    public function passes($attribute, $value) : bool {

        if (!is_file($value))
            return true;

        $extension = $value->getClientOriginalExtension();
        $allowed_extensions = ['mp4', 'mov', 'wmv', 'flv', 'mkv', 'jpeg', 'jpg', 'png'];
        return in_array($extension, $allowed_extensions);
    }

    public function message() : string {
        return 'Valid file formats: mp4, mov, wmv, flv, mkv, jpeg, jpg, png';
    }
}
