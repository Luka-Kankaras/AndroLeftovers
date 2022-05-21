<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

class Product extends Model {

    use HasFactory;

    protected $guarded = ['id'];

    public const STARTER_PACK = 1;
    public const ANNUAL_PLAN = 2;
    public const TOOTHBRUSH_HEAD = 3;
    public const TOOTHPASTE = 4;

    public function toothbrushColors() : BelongsToMany {
        return $this->belongsToMany(Color::class, 'color_products')->where('is_toothbrush', '=', 1);
    }

    public function toothbrushHeadColors() : BelongsToMany {
        return $this->belongsToMany(Color::class, 'color_products')->where('is_toothbrush', '=', 0);
    }

    public function toothbrushTypes() : BelongsToMany {
        return $this->belongsToMany(ToothbrushType::class, 'product_toothbrush_types');
    }

    public function toothpasteTypes() : BelongsToMany {
        return $this->belongsToMany(ToothpasteType::class, 'product_toothpaste_types');
    }

    public function images() : MorphMany {
        return $this->morphMany(Image::class, 'imageable');
    }



    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

    public function scopeGetAll($query, Request $request){
        return $query
            ->with(['toothbrushTypes', 'toothpasteTypes', 'toothbrushColors', 'toothbrushHeadColors'])
            ->when($request->term, function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->term}%")
                    ->orWhere('description', 'like', "%{$request->term}%")
                    ->orWhere('price', 'like', "%{$request->term}%")
                    ->orWhere('discount', 'like', "%{$request->term}%")
                    ->orWhere('buy_url', 'like', "%{$request->term}%");
            })
            ->paginate(Constants::ITEMS_PER_PAGE);
    }

}
