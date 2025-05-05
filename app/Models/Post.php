<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $with = ['user'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mix>
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'tags' => $this->tags,
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * How many posts per page
     *
     * @var int
     */
    public final const PER_PAGE = 9;

    /**
     * Allow mass assignment to provided fields
     *
     * @var array<string>
     */
    protected $fillable = ['title', 'user_id', 'tags', 'image', 'price'];

    /**
     * Relationship to user
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
     */
    public function getSearchResultsWithAuthorPaginated(?string $param = null, ?string $page = null): LengthAwarePaginator
    {
        $query = $this->with('user:id,name')->latest();

        if (! empty($param)) {
            return $this->search($param)->query(function () use ($query) {
                return $query;
            })->paginate(self::PER_PAGE);
        }

        return $query->paginate(self::PER_PAGE);
    }

    /**
     * Search in specific user posts, paginate and order by latest
     */
    public function getSearchResultsOfUserPaginated(string|int $userId, ?string $param = null, ?string $page = null): LengthAwarePaginator
    {
        $query = $this->where('user_id', $userId)->latest();

        if (! empty($param)) {
            return $this->search($param)->query(function () use ($query) {
                return $query;
            })->paginate(self::PER_PAGE);
        }

        return $query->paginate(self::PER_PAGE);
    }
}
