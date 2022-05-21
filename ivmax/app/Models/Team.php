<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class Team extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function images() : MorphMany {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function posts() : HasMany {
        return $this->hasMany(Post::class);
    }



    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

    public function scopeGetAll($query, Request $request){
        return $query
            ->when($request->term, function ($query) use ($request) {
                return $query->where('id', 'like', "%{$request->term}%")
                    ->orWhere('first_name', 'like', "%{$request->term}%")
                    ->orWhere('last_name', 'like', "%{$request->term}%")
                    ->orWhere('position', 'like', "%{$request->term}%");
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }


}
