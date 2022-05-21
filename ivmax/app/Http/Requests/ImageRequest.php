<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'image' => ['required', 'array'],
            'image.*' => ['image', 'mimes:jpg,png,jpeg', 'max:3000'],
        ];
    }

    public function messages() {
        return [
            'image.*.max' => 'Image max size is 1MB.',
        ];
    }

    public function validated() {
        $folder_name = strtolower(str_replace('App\Models\\', '', $this->model) . '-images');
        $curr_object = ("App\Models\\$this->model")::query()->find($this->currObjID);
        $obj = [];
        foreach ($this->image as $image) {
            $obj = $curr_object->images()->create([
                'file_path' => uploadFile($image, "/$folder_name"),
                'order_number' => ("App\Models\\$this->model")::query()->find($this->currObjID)->images->max('order_number') + 1,
            ]);
        }
        return $obj->file_path;
    }

}
