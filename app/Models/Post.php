<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Activity;
use Laravel\Scout\Searchable;
use App\Models\ActivityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    protected const PER_PAGE = 9;

    /**
     * Cache identifier for post
     * 
     * @var string
     */
    public const CACHE_ID = 'posts';

    /**
     * Define how for how long keep cache in memory
     * 
     * @var int
     */
    protected const CACHE_TIME = 60 * 60 * 24;

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
     * Returns all post records paginated
     *
     * @param array<string, array<string>> $filters
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters): LengthAwarePaginator
    {

        // return cache()->remember(self::CACHE_ID, self::CACHE_TIME, function () use ($filters) {
        // });

        if (empty($filters['search'])) {
            return $this->with('user:id,name')
                ->latest()
                ->paginate(self::PER_PAGE);
        }

        return self::search($filters['search'] ?? "")->query(function ($query) {
            return $query->with('user:id,name')->latest();
        })->paginate(self::PER_PAGE);
    }


    /**
     * Get all user posts
     *
     * @param string|integer $userId
     * @return Builder
     */
    public function getPostsThatContains(string|int $userId): Builder
    {
        return $this->where('user_id', $userId);
    }


    /**
     * Paginate specific user posts
     *
     * @param string|integer $userId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function paginatePostsContains(string|int $userId, array $filters): LengthAwarePaginator
    {
        return $this->getPostsThatContains($userId)->paginate($filters);
    }
}
