<?php

namespace App\Rules;

use App\Models\Language;
use Illuminate\Contracts\Validation\Rule;

class TranslatableRule implements Rule {

    public function __construct() {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) : bool {
        $langs = Language::query()->where('is_active', '=', 1)->pluck('country_code')->toArray();

        if (count($langs) - count($value) != 0){
            return false;
        }
        else {
            foreach ($value as $lang => $item) {
                if (!in_array(strtoupper($lang), $langs) || is_null($item))
                    return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() : string {
        return 'This field is required for all languages.';
    }

}
