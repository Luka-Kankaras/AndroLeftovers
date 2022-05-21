<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class ProductImagesRule implements Rule
{
    private $custom_message;
    private $id;

    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value) : bool {

        if ($this->id == Product::ANNUAL_PLAN)
            return true;

        // TODO Remove
        if ($value == url('test-photo.jpg'))
            return true;

        if (is_file($value)) {
            $arr = explode('/', $value->getClientMimeType());

            if (!in_array(end($arr), ['jpg', 'jpeg', 'png'])) {
                $this->custom_message = "The image must be a file of type: jpg, jpeg, png.";
                return false;
            }
        }
        else if (Product::query()->where('image', '=', $value)->count() == 1)
            return true;
        else {
            $this->custom_message = "The image field is required.";
            return false;
        }


        return true;

    }

    public function message() : string {
        return $this->custom_message;
    }
}
