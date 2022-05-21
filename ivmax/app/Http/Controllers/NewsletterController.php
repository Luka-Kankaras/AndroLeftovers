<?php

namespace App\Http\Controllers;

use App\Exports\NewsletterExport;
use App\Http\Requests\NewsletterRequest;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller {

    public function index(Request $request) : JsonResponse {
        return response()->json(Newsletter::query()->getAll($request), Response::HTTP_OK);
    }

    public function store(NewsletterRequest $request) : JsonResponse {
        return response()->json(Newsletter::query()->create($request->validated()), Response::HTTP_OK);
    }

    public function export() : JsonResponse {
        $subscribers = Newsletter::query()->orderByDesc('id')->get();

        $file_name = 'newsletter' . Carbon::now()->format('d-m-y-h-i-s') . '.xlsx';

        Excel::store(new NewsletterExport($subscribers), "public/newsletter/$file_name");
        $path = url("media/newsletter/$file_name");


        return response()->json($path, Response::HTTP_OK);
    }

}
