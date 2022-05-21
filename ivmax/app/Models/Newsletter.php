<?php

namespace App\Models;

use App\Constants\Constants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model {

    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['subscribed_since'];


    public function getSubscribedSinceAttribute() : string {
        return Carbon::parse($this->created_at)->format('d.m.Y.');
    }


    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////


    public function scopeGetAll($query, $request){
        return $query
            ->when($request->term, function ($query) use ($request) {
                return $query->where('email', 'like', "%$request->term%");
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }





}
