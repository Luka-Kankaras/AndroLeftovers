<?php

namespace App\Http\Requests;

use App\Rules\UniqueOnUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class ToothbrushTypeRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => [
                'required',
                $this->method() == 'POST' ? 'unique:toothbrush_types' : new UniqueOnUpdateRule('ToothbrushType', $this->id),
                'min:3',
                'max:20',
            ]
        ];
    }

}
