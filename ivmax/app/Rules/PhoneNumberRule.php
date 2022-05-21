<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberRule implements Rule {

    public function __construct() {
        //
    }

    public function passes($attribute, $value) : bool {

        dd(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $value));

        if(preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $value))
            return true;

        return false;

    }

    public function message() : string {
        return 'The phone number must be of valid format.';
    }

}
