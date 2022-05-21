<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileRule implements Rule {

    public function __construct($column) {
        $this->column = $column;
    }

    public function passes($attribute, $value) : bool {

        if (is_string($value))
            return true;

        if ($value->getClientOriginalExtension() == 'pdf')
                return true;

        return false;

    }

    public function message() : string {
        return "The $this->column must be a file of type pdf.";
    }
}
