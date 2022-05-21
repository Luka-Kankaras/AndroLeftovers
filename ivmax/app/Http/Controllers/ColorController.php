<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ColorController extends Controller {

    public function index(Request $request) : JsonResponse {

        return response()->json(Color::query()->getAll($request), Response::HTTP_OK);

    }

    public function store(ColorRequest $request) : JsonResponse {
        $color = Color::query()->create($request->validated());

        return response()->json($color, Response::HTTP_OK);
    }

    public function update(ColorRequest $request, Color $color) : JsonResponse {
        $color->update($request->validated());

        return response()->json($color, Response::HTTP_OK);
    }

    public function destroy(Color $color) {
        try {
            $color->delete();
        }
        catch (\Exception $e){
            return response()->json('Color can not be deleted while is bound to other fields.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return \response()->noContent();
    }

    public function getAll() : JsonResource {
        $data = Color::all();

        return ColorResource::collection($data);
    }

}
