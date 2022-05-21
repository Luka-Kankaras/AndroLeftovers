<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'first_name' => ['required', 'min:2', 'max:250'],
            'last_name' => ['required', 'min:2', 'max:250'],
            'email' => [
                'required',
                'max:250',
                $this->isMethod('POST')
                    ? Rule::unique('users', 'email')
                    : Rule::unique('users', 'email')->ignore($this->route('user')),
            ],
            'password' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'min:8',
                'confirmed',
            ],
        ];
    }

    public function validated() : array {
        $data = parent::validated();

        if ($this->filled('password'))
            $data['password'] = bcrypt($data['password']);
        else
            unset($data['password']);

        return $data;
    }
}
