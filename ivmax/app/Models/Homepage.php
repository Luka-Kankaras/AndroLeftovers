<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Homepage extends Model {

    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'homepage_info';

    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

}
