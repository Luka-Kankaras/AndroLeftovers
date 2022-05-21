<?php

namespace App\Http\Requests;

use App\Rules\AboutUsPhotoRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest {

    use FileHandling;

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            "section_1" => "required|max:2000|min:2",
            "section_1_bold" => "required|max:2000|min:2",
            "section_2" => "required|max:2000|min:2",
            "photo_1" => [new AboutUsPhotoRule($this->getMethod(), 'photo_1'), 'max:3000'],
            "photo_2" => [new AboutUsPhotoRule($this->getMethod(), 'photo_2'), 'max:3000'],
        ];
    }

    public function validated() : array {

        $data = parent::validated();

        if ($this->hasFile('photo_1'))
            $data['photo_1'] = "/media/about_us_photos/{$this->uploadFile($this->photo_1, 'about_us_photos')}";
        else
            unset($data['photo_1']);

        if ($this->hasFile('photo_2'))
            $data['photo_2'] = "/media/about_us_photos/{$this->uploadFile($this->photo_2, 'about_us_photos')}";
        else
            unset($data['photo_2']);

        return $data;

    }

}
