<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FaqController extends Controller {

    public function index(Request $request) : JsonResponse {

        return response()->json(Faq::query()->getAll($request), Response::HTTP_OK);

    }

    public function store(FaqRequest $request) : JsonResponse {
        $faq = Faq::query()->create($request->validated());

        return response()->json($faq, ResponseAlias::HTTP_OK);

    }

    public function update(FaqRequest $request, Faq $faq) : JsonResponse {

        $faq->update($request->validated());

        return response()->json($faq, ResponseAlias::HTTP_OK);

    }

    public function destroy(Faq $faq) : Response {

        $faq->delete();

        return response()->noContent();

    }
}
