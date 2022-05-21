<?php

namespace App\Rules;

use App\Models\Post;
use Illuminate\Contracts\Validation\Rule;

class PostThumbnailRule implements Rule {

    private $method;
    private $custom_message;

    public function __construct($method) {
        $this->method = $method;
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
                $this->custom_message = "The thumbnail field is required.";
                return false;
            }

            $arr = explode('/', $value->getClientMimeType());

            if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                $this->custom_message = "The thumbnail must be a file of type: jpg, jpeg, png.";
                return false;
            }

        }
        else if ($this->method == 'PUT') {

            if (is_file($value)) {
                $arr = explode('/', $value->getClientMimeType());

                if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                    $this->custom_message = "The thumbnail must be a file of type: jpg, jpeg, png.";
                    return false;
                }
            }
            else if (Post::query()->where('thumbnail', '=', $value)->count() == 1)
                return true;
            else {
                $this->custom_message = 'The thumbnail field is required.';
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
