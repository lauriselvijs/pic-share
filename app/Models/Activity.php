<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use App\Models\ActivityStatus;
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

    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activity statuses for the activity.
     */
    public function activityStatuses()
    {
        return $this->hasMany(ActivityStatus::class);
    }
}
