<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Testimonial extends Model {

    use HasFactory;

    protected $guarded = ['id'];


    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

    public function scopeGetAll($query, Request $request) {
        return $query
            ->when($request->term, function ($query) use ($request) {
                return $query->where('full_name', 'like', "%{$request->term}%")
                    ->orWhere('text', 'like', "%{$request->term}%")
                    ->orWhere('city', 'like', "%{$request->term}%")
                    ->orWhere('country', 'like', "%{$request->term}%");
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }


}
