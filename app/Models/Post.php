<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

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
     * @param array<string> $filters
     * @return void
     */
    public function scopeFilter($query, array $filters)
    {

        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . implode(', ', request('tag')) . '%');
        }

        if ($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%');
        }
    }

    /**
     * Relationship to user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // TODO:
    // [] - replace with scope filter
    /**
     * Gets auth name of given post
     *
     * @param string $postId
     * @return string
     */
    public static function authorNameBy($postId)
    {
        return self::where('id', $postId)->first()->user()->pluck('name')->first();
    }
}
