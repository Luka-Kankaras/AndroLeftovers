<?php

namespace App\Http\Requests;

use App\Rules\TestimonialPhotoRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest {

    use FileHandling;

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'first_name' => 'required|min:3|max:15',
            'last_name' => 'required|min:3|max:15',
            'text' => 'required|min:3|max:1000',
            'city' => 'required|min:3|max:15',
            'country' => 'required|min:3|max:15',
            "photo" => [new TestimonialPhotoRule($this->getMethod()), 'max:1024'],
        ];
    }


    public function validated() {

        $data = parent::validated();

        if ($this->hasFile('photo'))
            $data['photo'] = "/media/testimonials/{$this->uploadFile($this->photo, 'testimonials')}";
        else
            unset($data['photo']);

        return $data;

    }


}
