<?php

namespace App\Http\Requests;

use App\Models\Post;
use App\Rules\PostThumbnailRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class PostRequest extends FormRequest {

    use FileHandling;

    public function authorize() {
        return true;
    }

    public function rules() : array {

        return [
            "title" => "required|max:50|min:2",
            "text" => "required|max:3000|min:2",
            "team_id" => "required|numeric",
            "thumbnail" => [new PostThumbnailRule($this->getMethod()), 'max:3000'],
            "time_to_read" => "required|numeric|min:1|max:60",
        ];
    }

    public function validated() : array {

        $data = parent::validated();

        if ($this->hasFile('thumbnail'))
            $data['thumbnail'] = "/media/post-thumbnails/{$this->uploadFile($this->thumbnail, 'post-thumbnails')}";
        else
            unset($data['thumbnail']);

        $data['user_id'] = \auth()->user()->id;

        return $data;
    }
}
