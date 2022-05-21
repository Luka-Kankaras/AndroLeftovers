<?php

namespace App\Http\Requests;

use App\Rules\UniqueOnUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class ToothpasteTypeRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => [
                'required',
                $this->method() == 'POST' ? 'unique:toothpaste_types' : new UniqueOnUpdateRule('ToothpasteType', $this->id),
                'min:3',
                'max:20',
            ]
        ];
    }

}
