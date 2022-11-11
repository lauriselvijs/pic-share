<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\ActivityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * Query params used for post filtering
     * 
     * @var array<string>
     * 
     */
    public const FILTERS = ['tag', 'search'];


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
    protected $fillable = ['title', 'user_id', 'tags', 'image'];

    /**
     * Filter posts
     *
     * @param mixed $query
     * @param array<string, array<string>> $filters
     * @return void
     */
    public function scopeFilter(mixed $query, array $filters): void
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . implode(', ', $filters['tag']) . '%');
        }

        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('tags', 'like', '%' . $filters['search'] . '%');
        }
    }

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
        return cache()->remember(self::CACHE_ID, self::CACHE_TIME, function () use ($filters) {
            return $this->with('user:id,name')
                ->latest()
                ->filter($filters)
                ->paginate(self::PER_PAGE);
        });
    }

    public function getPostsContains(string|int $userId)
    {
        return $this->where('user_id', $userId);
    }

    public function paginatePostsContains(string|int $userId, array $filters): LengthAwarePaginator
    {
        return $this->getPostsContains($userId)->paginate($filters);
    }
}
