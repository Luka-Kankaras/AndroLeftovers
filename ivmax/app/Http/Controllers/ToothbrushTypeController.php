<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToothbrushTypeRequest;
use App\Http\Resources\ToothbrushTypeResource;
use App\Models\ToothbrushType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ToothbrushTypeController extends Controller {

    public function index(Request $request) : JsonResponse {

        return response()->json(ToothbrushType::query()->getAll($request), Response::HTTP_OK);

    }

    public function store(ToothbrushTypeRequest $request) : JsonResponse {
        $toothbrushType = ToothbrushType::query()->create($request->validated());

        return response()->json($toothbrushType, Response::HTTP_OK);
    }

    public function update(ToothbrushTypeRequest $request, ToothbrushType $toothbrushType) : JsonResponse {
        $toothbrushType->update($request->validated());

        return response()->json($toothbrushType, Response::HTTP_OK);
    }

    public function destroy(ToothbrushType $toothbrushType) {
        try {
            $toothbrushType->delete();
        }
        catch (\Exception $e){
            return response()->json('Toothbrush type can not be deleted while is bound to other fields.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return \response()->noContent();
    }

    public function getAll() : JsonResource {
        $data = ToothbrushType::all();

        return ToothbrushTypeResource::collection($data);
    }

}
