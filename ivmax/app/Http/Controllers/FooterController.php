<?php

namespace App\Http\Controllers;

use App\Http\Requests\FooterRequest;
use App\Models\Footer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FooterController extends Controller {

    public function index() : JsonResponse {
        return response()->json(Footer::query()->first(), Response::HTTP_OK);
    }

    public function update(FooterRequest $request, Footer $footer) : JsonResponse {
        return response()->json($footer->update($request->validated()), Response::HTTP_OK);
    }

}
