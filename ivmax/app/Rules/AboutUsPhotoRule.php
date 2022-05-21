<?php

namespace App\Rules;

use App\Models\Company;
use Illuminate\Contracts\Validation\Rule;

class AboutUsPhotoRule implements Rule
{
    private $method;
    private $custom_message;
    private $column;

    public function __construct($method, $column) {
        $this->method = $method;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) : bool {

        // TODO Remove
        if ($value == 'http://127.0.0.1:8000/test-photo.jpg')
            return true;

        if ($this->method == 'POST'){

            if (is_null($value)){
                $this->custom_message = "The cover photo field is required.";
                return false;
            }

            $arr = explode('/', $value->getClientMimeType());

            if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                $this->custom_message = "The cover photo must be a file of type: jpg, jpeg, png.";
                return false;
            }

        }
        else if ($this->method == 'PUT') {

            if (is_file($value)) {
                $arr = explode('/', $value->getClientMimeType());

                if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                    $this->custom_message = "The cover photo must be a file of type: jpg, jpeg, png.";
                    return false;
                }
            }
            else if (Company::query()->where($this->column, '=', $value)->count() == 1)
                return true;
            else {
                $this->custom_message = 'The cover photo field is required.';
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
    public function message() {
        return $this->custom_message;
    }
}
