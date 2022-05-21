<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\UpdateManyToMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller {

    use UpdateManyToMany;


    public function index(Request $request) : JsonResponse {

        return response()->json(Product::query()->getAll($request), Response::HTTP_OK);

    }

    public function update(ProductRequest $request, Product $product) : JsonResponse {

        $product = tap($product)->update($request->validated());

        // update: ColorProduct, ProductToothbrushType, ProductToothbrushType
        $this->forProduct($request, $product);

        return response()->json($product, Response::HTTP_OK);

    }

}
