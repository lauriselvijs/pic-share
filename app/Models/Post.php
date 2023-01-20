<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Activity;
use Laravel\Scout\Searchable;
use Laravel\Scout\Builder as LaravelScoutBuilder;
use App\Models\ActivityStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use Searchable, HasFactory;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'tags' => $this->tags,
        ];
    }

    /**
     * How many posts per page
     * 
     * @var int
     */
    public final const PER_PAGE = 9;

    /**
     * Cache identifier for post
     * 
     * @var string
     */
    public final const CACHE_KEY = 'posts';

    /**
     * Define how for how long keep cache in memory
     * 
     * @var int
     */
    protected final const CACHE_TIME = 60 * 60 * 24;

    /**
     * Allow mass assignment to provided fields
     *
     * @var array<string>
     */
    protected $fillable = ['title', 'user_id', 'tags', 'image', 'price'];

    /**
     * Relationship to user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the post's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the activities for the blog post.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Get all of activity statuses for the post.
     */
    public function activityStatuses()
    {
        return $this->hasManyThrough(ActivityStatus::class, Activity::class);
    }

    /**
     * Search posts and return them with post author, paginated and ordered by latest
     *
     * @param string|null $param
     * @return LengthAwarePaginator result ordered by latest post and paginated
     */
    public function getSearchResultsWithAuthorPaginated(string|null $param = ''): LengthAwarePaginator
    {
        $query = $this->with('user:id,name')->latest();

        if (!empty($param)) {
            return ($this->search($param)->query(function () use ($query) {
                return $query;
            }))->paginate(self::PER_PAGE);;
        }

        return cache()->remember(self::CACHE_KEY, self::CACHE_TIME, function () use ($query) {
            return $query->paginate(self::PER_PAGE);
        });
    }

    /**
     * Search in specific user posts, paginate and order by latest
     *
     * @param string|int $userId
     * @param string $param
     * @return LengthAwarePaginator
     */
    public function getSearchResultsOfUserPaginated(string|int $userId, string|null $param = ''): LengthAwarePaginator
    {
        $query = $this->where('user_id', $userId)->latest();

        if (!empty($param)) {
            return ($this->search($param)->query(function () use ($query) {
                return $query;
            }))->paginate(self::PER_PAGE);
        }

        return cache()->remember($userId, self::CACHE_TIME, function () use ($query) {
            return $query->paginate(self::PER_PAGE);
        });
    }
}
