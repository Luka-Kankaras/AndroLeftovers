<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller {


    public function index(Request $request) : JsonResponse {

        return response()->json(Tag::query()->getAll($request), Response::HTTP_OK);

    }


    public function store(TagRequest $request) : JsonResponse {

        $tag = Tag::query()->create($request->validated());

        return response()->json($tag, Response::HTTP_OK);

    }


    public function update(TagRequest $request, Tag $tag) : JsonResponse {

        $tag->update($request->validated());

        return response()->json($tag, Response::HTTP_OK);

    }


    public function destroy(Tag $tag) : Response {

        $tag->delete();

        return response()->noContent();

    }


    public function selectTags() : JsonResponse {

        $data = Tag::all();

        return response()->json(TagResource::collection($data));

    }

}
