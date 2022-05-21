<?php

namespace App\Http\Requests;

use App\Rules\UniqueOnUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class InfoCategoryRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'name' => [
                'required',
                $this->method() == 'POST' ? 'unique:info_categories' : new UniqueOnUpdateRule('InfoCategory', $this->id),
                'min:2',
                'max:15'
            ],
        ];
    }
}
