<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Color;
use App\Models\ColorProduct;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\GeneralInfo;
use App\Models\Homepage;
use App\Models\InfoCategory;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductToothbrushType;
use App\Models\ProductToothpasteType;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\ToothbrushType;
use App\Models\ToothpasteType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebsiteController extends Controller
{
    public function index()
    {
        $homePageInfo = Homepage::query()->select('title', 'subtitle', 'photo_or_video', 'video_name', 'video_ext', 'thumbnail_big', 'thumbnail_small', 'text_1', 'text_2', 'feature_1', 'feature_2', 'feature_3', 'feature_4', 'ivmax_anatomy', 'annual_text_1', 'annual_text_2')
            ->first();

        $testimonials = Testimonial::query()->select('first_name', 'last_name', 'text', 'city', 'country', 'photo')
            ->get();

        return view('index', compact("homePageInfo", "testimonials"));
    }

    public function blog()
    {
        $postMain = Post::query()
            ->where('active', '=', true)
            ->select('id', 'title', 'text', 'thumbnail', 'created_at', 'user_id', 'team_id')
            ->orderBy("id", "DESC")
            ->with(['user', 'tags', 'team'])
            ->take(1)
            ->get();

        $posts = Post::query()
            ->where('active', '=', true)
            ->where('id', '!=', $postMain[0]->id)
            ->select('id', 'title', 'text', 'thumbnail', 'created_at', 'user_id', 'team_id')
            ->orderBy("id", "DESC")
            ->with(['user', 'tags', 'team'])
            ->paginate(8);

        return view('blog', compact("postMain", "posts"));
    }

    public function blogSingle($id)
    {
        $postSingle = Post::where('id', $id)->select('id', 'title', 'text', 'thumbnail', 'created_at', 'user_id', 'team_id', 'time_to_read')
            ->where('active', '=', true)
            ->with(['user', 'tags', 'team'])
            ->first();

        return view('blog-single', compact("postSingle"));
    }

    public function about()
    {
        $about = Company::query()->select('section_1', 'section_1_bold', 'section_2', 'photo_1', 'photo_2')
            ->first();

        $team = Team::query()->select('id', 'first_name', 'last_name', 'position', 'image')
            ->orderBy("id", "DESC")
            ->get();

        return view('about', compact("about", "team"));
    }

    public function products()
    {
        $products = Product::query()->select('id', 'name', 'description', 'buy_url', 'image', 'discount', 'ivmax_toothbrush_count', 'brush_head_count', 'toothpaste_cartridges_count')
            ->with(['toothbrushColors', 'toothbrushHeadColors', 'toothbrushTypes', 'toothpasteTypes', 'images'])
            ->get();

        return view('products', compact("products"));
    }

    public function help()
    {
        $infoCategory = InfoCategory::query()
            ->whereHas('generalInfos')
            ->select('id', 'name')
            ->orderBy("id", "ASC")
            ->get();

        $generalInfo = GeneralInfo::query()
            ->select('id', 'name', 'description', 'info_category_id', 'video')
            ->get();

        $faqs = Faq::query()->select('id', 'question', 'answer')
            ->orderBy("id", "DESC")
            ->get();

        return view('help', compact("infoCategory", "generalInfo", "faqs"));
    }


    public function submitContactForm(ContactRequest $request) : JsonResponse {

        $message = Contact::query()->create($request->validated());

        return response()->json($message, Response::HTTP_OK);

    }


}
