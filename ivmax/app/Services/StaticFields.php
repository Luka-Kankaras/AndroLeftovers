<?php

namespace App\Services;

use App\Http\Requests\StaticFieldRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;

class StaticFields {

    public function index() : JsonResponse {

        return response()->json(Lang::get('static'), Response::HTTP_OK);

    }

    public function update(StaticFieldRequest $request) : JsonResponse {

        $lang = strtolower(config('app.locale'));

        file_put_contents(base_path("resources/lang/$lang/static.php"), "<?php\nreturn " . var_export($request->all(), true) . ';');

        Artisan::call('cache:clear');

        return response()->json(Response::HTTP_OK);

    }

}
