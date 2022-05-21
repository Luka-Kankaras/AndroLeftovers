<?php

namespace App\Traits;

use App\Models\ColorProduct;
use App\Models\ProductToothbrushType;
use App\Models\ProductToothpasteType;

trait UpdateManyToMany {

    function forProduct($request, $product){

        $product->toothbrushColors()->detach();
        $product->toothbrushHeadColors()->detach();
        $product->toothbrushTypes()->detach();
        $product->toothpasteTypes()->detach();

        if($request->toothbrushColors) {
            foreach ($request->toothbrushColors as $color) {
                ColorProduct::query()->create([
                    'product_id' => $product->id,
                    'color_id' => $color
                ]);
            };
        }

        if($request->toothbrushHeadColors) {
            foreach ($request->toothbrushHeadColors as $color) {
                ColorProduct::query()->create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'is_toothbrush' => 0,
                ]);
            };
        }

        if($request->toothbrushTypes) {
            foreach ($request->toothbrushTypes as $color) {
                ProductToothbrushType::query()->create([
                    'product_id' => $product->id,
                    'toothbrush_type_id' => $color,
                ]);
            };
        }

        if($request->toothpasteTypes) {
            foreach ($request->toothpasteTypes as $color) {
                ProductToothpasteType::query()->create([
                    'product_id' => $product->id,
                    'toothpaste_type_id' => $color,
                ]);
            };
        }
    }

}
