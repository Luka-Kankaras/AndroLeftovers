<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

class GeneralInfo extends Model {

    use HasFactory;

    protected $guarded = ['id'];

    public function infoCategory(): BelongsTo {
        return $this->belongsTo(InfoCategory::class);
    }

    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

    public function scopeGetAll($query, Request $request){
        return $query
            ->with('infoCategory')
            ->when($request->term, function ($query) use ($request) {
                $categories = InfoCategory::query()->where('name', 'like', "%{$request->term}%")->get()->pluck('id');
                return $query->where('id', 'like', "%{$request->term}%")
                    ->orWhere('name', 'like', "%{$request->term}%")
                    ->orWhere('description', 'like', "%{$request->term}%")
                    ->orWhereIn('info_category_id', $categories);
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }


}
