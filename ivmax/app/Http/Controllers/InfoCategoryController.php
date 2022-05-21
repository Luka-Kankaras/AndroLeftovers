<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoCategoryRequest;
use App\Http\Resources\InfoCategoryResource;
use App\Models\InfoCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InfoCategoryController extends Controller {


    public function index(Request $request): JsonResponse {

        return response()->json(InfoCategory::query()->getAll($request), ResponseAlias::HTTP_OK);

    }


    public function store(InfoCategoryRequest $request): JsonResponse {

        $category = InfoCategory::query()->create($request->validated());

        return response()->json($category, ResponseAlias::HTTP_OK);

    }


    public function update(InfoCategoryRequest $request, InfoCategory $infoCategory): JsonResponse {

        $infoCategory->update($request->validated());

        return response()->json($infoCategory, ResponseAlias::HTTP_OK);

    }


    public function destroy(InfoCategory $infoCategory) {

        try {
            $infoCategory->delete();
        }
        catch (\Exception $e){
            return response()->json('Category can not be deleted while is bound to other fields.', Response::HTTP_METHOD_NOT_ALLOWED);
        }

        return response()->noContent();

    }


    public function getAll() : JsonResource {

        $data = InfoCategory::all();

        return InfoCategoryResource::collection($data);

    }


}
