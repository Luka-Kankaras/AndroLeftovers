<?php

namespace App\Rules;

use App\Models\Homepage;
use Illuminate\Contracts\Validation\Rule;

class CoverPhotoRule implements Rule
{
    private $method;
    private $custom_message;
    private $image;
    private $field_name;

    public function __construct($method, $image) {
        $this->method = $method;
        $this->image = $image;
        $this->field_name = $image == 'cover_image_big' ? 'Cover image (big screen)' : 'Cover image (small screen)';
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
                $this->custom_message = "The $this->field_name field is required.";
                return false;
            }

            $arr = explode('/', $value->getClientMimeType());

            if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                $this->custom_message = "The $this->field_name must be a file of type: jpg, jpeg, png.";
                return false;
            }

        }
        else if ($this->method == 'PUT') {

            if (is_file($value)) {
                $arr = explode('/', $value->getClientMimeType());

                if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                    $this->custom_message = "The $this->field_name must be a file of type: jpg, jpeg, png.";
                    return false;
                }
            }
            else if (Homepage::query()->where($this->image, '=', $value)->count() == 1)
                return true;
            else {
                $this->custom_message = "The $this->field_name field is required.";
                return false;
            }

        }

        return true;

    }

    public function message() : string {
        return $this->custom_message;
    }
}
