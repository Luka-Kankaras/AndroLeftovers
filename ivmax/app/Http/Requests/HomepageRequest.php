<?php

namespace App\Http\Requests;

use App\Rules\CoverPhotoRule;
use App\Rules\VideoMimeTypeRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class HomepageRequest extends FormRequest {

    use FileHandling;

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'title' => 'required|min:5|max:100',
            'subtitle' => 'required|min:5|max:100',
            'text_1' => 'required|min:10|max:2000',
            'text_2' => 'required|min:10|max:2000',
            'ivmax_anatomy' => 'required|min:10|max:2000',
            'feature_1' => 'required|min:10|max:2000',
            'feature_2' => 'required|min:10|max:2000',
            'feature_3' => 'required|min:10|max:2000',
            'feature_4' => 'required|min:10|max:2000',
            'annual_text_1' => 'required|min:10|max:2000',
            'annual_text_2' => 'required|min:10|max:2000',
            'photo_or_video' => ['required', new VideoMimeTypeRule],
            "thumbnail_big" => [new CoverPhotoRule($this->getMethod(), 'thumbnail_big'), 'max:10000'],
            "thumbnail_small" => [new CoverPhotoRule($this->getMethod(), 'thumbnail_small'), 'max:5000'],
        ];
    }

    public function validated() : array {

        $data = parent::validated();

        // video_name -> photo or video name for annual plan section on homepage
        // video_ext -> photo or video extension for annual plan section on homepage

        if ($this->hasFile('photo_or_video')){
            $data['photo_or_video'] = "/media/homepage/{$this->uploadFile($this->photo_or_video, 'homepage')}";
            $arr = explode('/', $data['photo_or_video']);
            $data['video_name'] = end($arr);
            $data['video_ext'] = $this->photo_or_video->getClientOriginalExtension();
        }

        if ($this->hasFile('thumbnail_big'))
            $data['thumbnail_big'] = "/media/homepage-cover/{$this->uploadFile($this->thumbnail_big, 'homepage-cover')}";
        else
            unset($data['thumbnail_big']);

        if ($this->hasFile('thumbnail_small'))
            $data['thumbnail_small'] = "/media/homepage-cover/{$this->uploadFile($this->thumbnail_small, 'homepage-cover')}";
        else
            unset($data['thumbnail_small']);

        return $data;

    }

}
