<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ToothpasteType extends Model {

    use HasFactory;

    protected $guarded = ['id'];


    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

    public function scopeGetAll($query, Request $request){
        return $query
            ->when($request->term, function ($query) use ($request) {
                return $query->where('id', 'like', "%{$request->term}%")
                    ->orWhere('name', 'like', "%{$request->term}%");
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }


}
