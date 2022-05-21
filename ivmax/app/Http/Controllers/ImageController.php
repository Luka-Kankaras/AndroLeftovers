<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Traits\FileHandling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller {

    use FileHandling;

    public function index($object_id) : JsonResponse {
        $model_name = request()->model_name;
        $curr_object = ("App\Models\\$model_name")::query()->find($object_id);

        $images = $curr_object->images()
            ->orderBy('order_number', 'ASC')
            ->get()
            ->map(function (Image $image) {
                return [
                    'id' => $image->id,
                    'file_path' => $image->file_path,
                    'order_number' => $image->order_number,
                    'model' => $image->imageable_type,
                    'object_id' => $image->imageable_id,
                ];
            });

        return response()->json([
            'images' => $images,
            'max_order' => $curr_object->images()->count(),
        ]);
    }

    public function store(ImageRequest $request) : JsonResponse {
        $obj = $request->validated();

        return response()->json(['location' => $obj]);
    }

    public function updateOrder(Image $image) {
        if (request('method') == 'moveOrderDown') {
            $next = $image->imageable->images->where('order_number', $image->order_number + 1)->first();
            $next_order_number = $next->order_number;

            $next->order_number = $image->order_number;
            $image->order_number = $next_order_number;

            $image->save();
            $next->save();

        } else {
            $next = $image->imageable->images->where('order_number', $image->order_number - 1)->first();
            $next_order_number = $next->order_number;

            $next->order_number = $image->order_number;
            $image->order_number = $next_order_number;

            $image->save();
            $next->save();
        }
    }

    public function destroy($model_id, $image_id) : Response {
        $target = Image::query()->find($image_id);
        $target_order = $target->order_number;

        Image::query()->find($image_id)->imageable->images()->where('order_number', '>', $target_order)->update([
            'order_number' => DB::raw('order_number - 1'),
        ]);

        $target->delete();

        return \response()->noContent();
    }
}
