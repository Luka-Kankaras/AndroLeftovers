<?php

namespace App\Http\Requests;

use App\Rules\FileRule;
use App\Rules\PhoneNumberRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class FooterRequest extends FormRequest {

    use FileHandling;

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'company_name' => ['required', 'min:3', 'max:50'],
            'address' => ['required', 'min:3', 'max:80'],
            'email' => ['required', 'min:3', 'max:80'],
            'phone_number' => ['required', 'min:3', 'max:50', 'regex: #^[+]{0,1}[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$#'],
            'terms_and_conditions' => ['required', 'max:3000', new FileRule('terms and conditions')],
            'privacy_policy' => ['required', 'max:3000', new FileRule('privacy policy'), 'max:1500'],
        ];
    }


    public function validated() : array {

        $data = parent::validated();

        if ($this->hasFile('privacy_policy'))
            $data['privacy_policy'] = "/media/footer-info/{$this->uploadFile($this->privacy_policy, 'footer-info')}";

        if ($this->hasFile('terms_and_conditions'))
            $data['terms_and_conditions'] = "/media/footer-info/{$this->uploadFile($this->terms_and_conditions, 'footer-info')}";

        return $data;

    }


}
