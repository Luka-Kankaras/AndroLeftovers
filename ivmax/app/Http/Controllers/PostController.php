<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class PostController extends Controller {

    public function index(Request $request): JsonResponse {

        Session::put(['tinyMce' => []]);

        return response()->json(Post::query()->getAll($request), Response::HTTP_OK);

    }

    public function store(PostRequest $request): JsonResponse {
        $post = Post::query()->create($request->validated());

        if (!empty(Session::get('tinyMce'))) {
            foreach (Session::get('tinyMce') as $img) {
                $post->images()->create([
                    'file_path' => $img,
                    'order_number' => $post->images->max('order_number') + 1,
                ]);
            }
        }

        $post->tags()->attach($request->tags);

        return response()->json($post, ResponseAlias::HTTP_OK);
    }

    public function update(PostRequest $request, Post $post): JsonResponse {
        $post->update($request->validated());

        if (!empty(Session::get('tinyMce'))) {
            foreach (Session::get('tinyMce') as $img) {
                $post->images()->create([
                    'file_path' => $img,
                    'order_number' => $post->images->max('order_number') + 1,
                ]);
            }
        }
        if ($request->removed_images) {
            foreach ($request->removed_images as $img) {
                $fileName = explode('/', $img)[3];
                Storage::delete('public/post-images/' . $fileName);
                $i = Image::query()->where('file_path', '=', $img)->delete();
            }
        }

        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        return response()->json($post, ResponseAlias::HTTP_OK);
    }

    public function toggleStatus(Post $post): JsonResponse {
        $status = $post->active;
        $post->update(['active' => !$status]);

        return response()->json($post, ResponseAlias::HTTP_OK);
    }

    public function destroy(Post $post): Response {
        $post->tags()->detach();
        $post->delete();

        return response()->noContent();
    }

    public function preSaveImage(Request $request): JsonResponse {
        $validated = $request->validate([
            'image' => ['image', 'mimes:jpg,png,jpeg', 'max:1024'],
        ]);

        $array = session('tinyMce');

        array_push($array, uploadFile($validated['image'], '/post-images'));

        Session::put(['tinyMce' => $array]);

        return \response()->json(['location' => end($array)]);
    }

}
