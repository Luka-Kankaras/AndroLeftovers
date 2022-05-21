<?php

namespace App\Models;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Post extends Model {

    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['similar_posts'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo {
        return $this->belongsTo(Team::class);
    }

    public function images(): MorphMany {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function getSimilarPostsAttribute() {

        $tags = $this->tags->pluck('id')->toArray();

        $query = DB::table('post_tags')
            ->join('posts', 'post_tags.post_id', '=', 'posts.id')
            ->select('post_tags.post_id', DB::raw('count(post_tags.tag_id) as total'))
            ->whereIn('post_tags.tag_id', $tags)
            ->where('post_tags.post_id', '!=', $this->id)
            ->where('posts.active', '=', 1)
            ->groupBy('post_tags.post_id')
            ->orderByDesc('total')
            ->get();

        $allSimilarBlogs = $query->toArray();

        switch (count($allSimilarBlogs)) {
            case 0:
                return 0;
            case 1:
                return [
                    $allSimilarBlogs[0]->post_id,
                ];
            default:
                return [
                    $allSimilarBlogs[0]->post_id,
                    $allSimilarBlogs[1]->post_id,
                ];
        }
    }

    public function similarPosts(): Collection {

        $collection = new Collection();

        if ($this->similar_posts == 0)
            return $collection;

        if (count($this->similar_posts) == 1)
            $collection->add(Post::query()->find($this->similar_posts[0]));

        if (count($this->similar_posts) == 2){
            $collection->add(Post::query()->find($this->similar_posts[0]));
            $collection->add(Post::query()->find($this->similar_posts[1]));
        }

        return $collection;
    }

    ////////////////////////////////////
    ///////////// SCOPES ///////////////
    ////////////////////////////////////

    public function scopeGetAll($query, Request $request) {
        return $query
            ->with(['user', 'tags', 'team'])
            ->when(!is_null($request->status), function (Builder $query) use ($request) {
                return $query->where('active', $request->status);
            })
            ->when($request->term, function ($query) use ($request) {

                $author_ids = Team::query()->where('full_name', 'like', "%{$request->term}%")->get()->pluck('id');

                $query->where('id', 'like', "%{$request->term}%")
                    ->orWhere('title', 'like', "%{$request->term}%")
                    ->orWhere('text', 'like', "%{$request->term}%")
                    ->orWhereIn('team_id', $author_ids);
            })
            ->orderByDesc('id')
            ->paginate(Constants::ITEMS_PER_PAGE);
    }
}
