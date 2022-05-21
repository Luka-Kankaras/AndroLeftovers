<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonialController extends Controller {


    public function index(Request $request) : JsonResponse {

        return response()->json(Testimonial::query()->getAll($request), Response::HTTP_OK);

    }


    public function store(TestimonialRequest $request) : JsonResponse {

        $tag = Testimonial::query()->create($request->validated());

        return response()->json($tag, Response::HTTP_OK);

    }


    public function update(TestimonialRequest $request, Testimonial $testimonial) : JsonResponse {

        $testimonial->update($request->validated());

        return response()->json($testimonial, Response::HTTP_OK);

    }


    public function destroy(Testimonial $testimonial) {

        $testimonial->delete();

        return response()->noContent();

    }


}
