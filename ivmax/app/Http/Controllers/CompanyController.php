<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CompanyController extends Controller {

    public function index() : JsonResponse {

        return response()->json(Company::query()->first(), ResponseAlias::HTTP_OK);

    }

    public function update(CompanyRequest $request, Company $company) : JsonResponse {

        $company->update($request->validated());

        return response()->json($company, ResponseAlias::HTTP_OK);

    }

}
