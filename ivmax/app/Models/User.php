<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'email_verified_at' => 'datetime',
    ];

    public function role() : BelongsTo {
        return $this->belongsTo(Role::class);
    }

    public function country() : BelongsTo {
        return $this->belongsTo(Language::class);
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
                    ->orWhere('email', 'like', "%{$request->term}%");
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }


}
