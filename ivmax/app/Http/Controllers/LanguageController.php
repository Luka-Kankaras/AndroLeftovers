<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LanguageController extends Controller {

    public function index(Request $request) : JsonResponse {
        $languages = Language::query()->where('name', '<>', 'Default')->select('id', 'name', 'country_code')->get();

        return response()->json($languages, Response::HTTP_OK);
    }

    public function store(LanguageRequest $request) : JsonResponse {
        $language = Language::query()->create($request->validated());

        return response()->json($language, Response::HTTP_OK);
    }

    public function update(LanguageRequest $request, Language $language) : JsonResponse {
        $country = $language->update($request->validated());

        return response()->json($country, Response::HTTP_OK);
    }

    public function destroy(Language $language) {
        if ($language->id != 1){
            $language->update(['is_active' => false]);
            return response()->noContent();
        }
        return response()->json('This language can not be deleted.', Response::HTTP_FORBIDDEN);
    }

    public function getActiveLanguage() : JsonResponse {
        $languages = Language::query()->where('is_active', '=', 1)->select('id', 'name', 'country_code')->get();

        return response()->json($languages, Response::HTTP_OK);
    }

    public function setActiveLanguage(Request $request) : JsonResponse {
        Language::query()->find($request->language)->update(['is_active' => true]);

        return response()->json('Success.', Response::HTTP_OK);
    }

}
