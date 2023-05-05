<?php

namespace App\Models;

use App\Contracts\CanManipulateFiles;
use App\Models\User;
use App\Models\Comment;
use App\Models\Activity;
use Laravel\Scout\Searchable;
use App\Models\ActivityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    use Searchable, HasFactory;

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
     * Cache tag for post group
     * 
     * @var string
     */
    public final const CACHE_PAGINATION_TAG = 'posts_paginated';

    /**
     * Define how for how long keep cache in memory
     * 
     * @var int
     */
    public final const CACHE_TIME = 60 * 60 * 24;

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
     * Get cache key for current page
     *
     */
    public function getCacheKeyForCurrentPage(string $page): string
    {
        return self::CACHE_KEY . '_page_' . $page;
    }

    /**
     * Get cache key for current page for given user
     *
     */
    public function getCacheKeyForCurrentPageWithGivenUser(string|int $userId, string $page): string
    {
        return $userId . '_page_' . $page;
    }

    /**
     * Search posts and return them with post author, paginated and ordered by latest
     */
    public function getSearchResultsWithAuthorPaginated(?string $param = null, ?string $page = null): LengthAwarePaginator
    {
        $query = $this->with('user:id,name')->latest();

        if (!empty($param)) {
            return ($this->search($param)->query(function () use ($query) {
                return $query;
            }))->paginate(self::PER_PAGE);
        }

        return cache()->tags([self::CACHE_PAGINATION_TAG])->remember($this->getCacheKeyForCurrentPage($page ?? "1"), self::CACHE_TIME, function () use ($query) {
            return $query->paginate(self::PER_PAGE);
        });
    }

    /**
     * Search in specific user posts, paginate and order by latest
     */
    public function getSearchResultsOfUserPaginated(string|int $userId, ?string $param = null, ?string $page = null): LengthAwarePaginator
    {
        $query = $this->where('user_id', $userId)->latest();

        if (!empty($param)) {
            return ($this->search($param)->query(function () use ($query) {
                return $query;
            }))->paginate(self::PER_PAGE);
        }

        // REVIEW: Check if cache works for multiple pages
        return cache()->tags([$userId])->remember($this->getCacheKeyForCurrentPageWithGivenUser($userId, ($page ?? "1")), self::CACHE_TIME, function () use ($query) {
            return $query->paginate(self::PER_PAGE);
        });
    }
}
