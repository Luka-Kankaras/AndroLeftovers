<?php

namespace App\Http\Requests;

use App\Rules\GeneralInfoTranslatableRule;
use App\Rules\VideoMimeTypeRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class GeneralInfoRequest extends FormRequest {

    use FileHandling;

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
        return [
            'name' => ['required', 'min:3', 'max:250'],
            'description' => ['required', 'min:3', 'max:50000'],
            'info_category_id' => ['required', 'integer'],
            'video' => ['nullable', new VideoMimeTypeRule, 'max:150000'],
        ];
    }

    public function validated() : array {

        $data = parent::validated();

        if ($this->remove_video){
            $data['video'] = null;
            $data['video_name'] = null;
            $data['video_ext'] = null;
        }
        else if ($this->hasFile('video')){
            $data['video'] = "/media/general-info/{$this->uploadFile($this->video, 'general-info')}";
            $arr = explode('/', $data['video']);
            $data['video_name'] = end($arr);
            $data['video_ext'] = $this->video->getClientOriginalExtension();
        }


        return $data;
    }

}
