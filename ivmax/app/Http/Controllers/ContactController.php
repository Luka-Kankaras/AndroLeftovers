<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller {

    public function index(Request $request) : JsonResponse {

        return response()->json(Contact::query()->getAll($request), Response::HTTP_OK);

    }

    public function store(ContactRequest $request) : JsonResponse {

        $message = Contact::query()->create($request->validated());

        return response()->json($message, Response::HTTP_OK);

    }

    public function destroy(Contact $contact) : Response {

        $contact->delete();

        return response()->noContent();

    }

}
