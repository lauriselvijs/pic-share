<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    /**
     * Get the post that owns the activity.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
