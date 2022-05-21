<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model {

    use HasFactory;

    protected $guarded = ['id'];

    public function images(): MorphMany {
        return $this->morphMany(Image::class, 'imageable');
    }

    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////


}
