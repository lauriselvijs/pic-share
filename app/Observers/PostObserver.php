<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Str;

class PostObserver
{
    // REVIEW: Runs events after transactions
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the User "creating" event.
     *
     * @param  User  $user
     */
    public function creating(Post $post): void
    {
        $post->slug = Str::slug($post->title, '-');
    }

    /**
     * Handle the Post "created" event.
     *
     * @return void
     */
    public function created(Post $post) {}

    /**
     * Handle the Post "updating" event.
     *
     * @return void
     */
    public function updating(Post $post)
    {
        // cache()->flush($post->image);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @return void
     */
    public function updated(Post $post) {}

    /**
     * Handle the Post "deleted" event.
     *
     * @return void
     */
    public function deleted(Post $post) {}

    /**
     * Handle the Post "restored" event.
     *
     * @return void
     */
    public function restored(Post $post) {}

    /**
     * Handle the Post "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Post $post) {}
}
