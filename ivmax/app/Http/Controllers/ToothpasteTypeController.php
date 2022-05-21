<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToothpasteTypeRequest;
use App\Http\Resources\ToothpasteTypeResource;
use App\Models\ToothpasteType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ToothpasteTypeController extends Controller {

    public function index(Request $request) : JsonResponse {

        return response()->json(ToothpasteType::query()->getAll($request), Response::HTTP_OK);

    }

    public function store(ToothpasteTypeRequest $request) : JsonResponse {
        $toothpasteType = ToothpasteType::query()->create($request->validated());

        return response()->json($toothpasteType, Response::HTTP_OK);
    }

    public function update(ToothpasteTypeRequest $request, ToothpasteType $toothpasteType) : JsonResponse {
        $toothpasteType->update($request->validated());

        return response()->json($toothpasteType, Response::HTTP_OK);
    }

    public function destroy(ToothpasteType $toothpasteType) {
        try {
            $toothpasteType->delete();
        }
        catch (\Exception $e){
            return response()->json('Toothpaste type can not be deleted while is bound to other fields.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return \response()->noContent();
    }

    public function getAll() : JsonResource {
        $data = ToothpasteType::all();

        return ToothpasteTypeResource::collection($data);
    }


}
