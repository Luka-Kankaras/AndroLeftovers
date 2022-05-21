<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HexColorRule implements Rule {

    public function __construct() {
        //
    }

    public function passes($attribute, $value) : bool {
        preg_match('/#([a-f0-9]{3}){1,2}\b/i', $value, $matched);
        return (bool) count($matched);
    }

    public function message() : string {
        return 'Please enter a valid hex value.';
    }

}
