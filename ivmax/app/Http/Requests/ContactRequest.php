<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules() : array {
        return [
            'name' => 'required|min:3|max:30',
            'email' => 'required|email|min:3|max:100',
            'message' => 'required|min:3|max:5000',
        ];
    }

}
