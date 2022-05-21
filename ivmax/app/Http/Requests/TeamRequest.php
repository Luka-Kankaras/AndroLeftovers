<?php

namespace App\Http\Requests;

use App\Rules\PostThumbnailRule;
use App\Rules\TeamImageRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest {

    use FileHandling;

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            "first_name" => "required|min:2|max:100",
            "last_name" => "required|min:2|max:100",
            "position" => "required|min:2|max:100",
            "image" => [new TeamImageRule($this->getMethod()), 'max:1024'],
        ];
    }

    public function validated(): array {

        $data = parent::validated();

        if ($this->hasFile('image'))
            $data['image'] = "/media/team-photos/{$this->uploadFile($this->image, 'team-photos')}";
        else
            unset($data['image']);

        return $data;
    }

}
