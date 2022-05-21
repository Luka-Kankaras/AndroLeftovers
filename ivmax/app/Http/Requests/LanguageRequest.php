<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array {
        return [
            'name' => 'required|unique:languages|min:3|max:15',
            'country_code' => 'required|unique:languages|string|min:2|max:2',
        ];
    }

    public function validated() : array {
        return array_replace($this->all(), ['country_code' => strtoupper($this->country_code)]);
    }

}
