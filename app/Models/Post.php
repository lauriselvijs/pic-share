<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
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


    // TODO:
    // [] - remove
    /**
     * Gets auth name of given post
     *
     * @param string $postId
     * @return string
     */
    public static function authorNameBy($postId)
    {
        return self::where('id', $postId)
            ->first()
            ->user()
            ->pluck('name')
            ->first();
    }

    /**
     * Returns all post records paginated
     *
     * @param array<string, array<string>> $filters
     * @return LengthAwarePaginator
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->with('user:id,name')
            ->latest()
            ->filter($filters)
            ->paginate(9);
    }
}
