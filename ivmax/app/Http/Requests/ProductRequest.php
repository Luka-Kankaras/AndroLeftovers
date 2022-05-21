<?php

namespace App\Http\Requests;

use App\Rules\ProductImagesRule;
use App\Traits\FileHandling;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {

    use FileHandling;

    public function authorize() : bool {
        return true;
    }

    public function rules() : array {
//        dd($this->discount);
        return [
            'name' => 'required|min:3|max:20',
            'description' => 'required|min:3|max:2000',
            "image" => [new ProductImagesRule($this->id), 'max:5000'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:99'],
            'buy_url' => 'required|url|min:0|max:99',
            'ivmax_toothbrush_count' => 'required|numeric|min:0|max:99',
            'brush_head_count' => 'required|numeric|min:0|max:99',
            'toothpaste_cartridges_count' => 'required|numeric|min:0|max:99',
            'toothbrushTypes' => 'nullable|array',
            'toothbrushTypes.*' => 'numeric|min:1',
            'toothpasteTypes' => 'nullable|array',
            'toothpasteTypes.*' => 'numeric|min:1',
            'toothbrushColors' => 'nullable|array',
            'toothbrushColors.*' => 'numeric|min:1',
            'toothbrushHeadColors' => 'nullable|array',
            'toothbrushHeadColors.*' => 'numeric|min:1',
        ];
    }

    public function validated() : array {
        $data =  parent::validated();

        $this->discount == 'null' ?? $data['discount'] = 0;

        if ($this->hasFile('image'))
            $data['image'] = "/media/product-covers/{$this->uploadFile($this->image, 'product-covers')}";
        else
            unset($data['image']);

        return $data;

    }


}
