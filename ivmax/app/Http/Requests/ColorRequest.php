<?php

namespace App\Http\Requests;

use App\Rules\HexColorRule;
use App\Rules\UniqueOnUpdateRule;
use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'name' => [
                'required',
                $this->method() == 'POST' ? 'unique:colors' : new UniqueOnUpdateRule('Color', $this->id),
                'min:2',
                'max:15'
            ],
            'hex' => [
                'required',
                $this->method() == 'POST' ? 'unique:colors' : new UniqueOnUpdateRule('Color', $this->id, 'hex'),
                'min:7',
                'max:7',
                new HexColorRule()
            ],
        ];
    }
}
