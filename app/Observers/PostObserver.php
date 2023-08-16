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
     * @return void
     */
    public function creating(Post $post): void
    {
        $post->slug = Str::slug($post->title, '-');
    }


    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        cache()->tags($post->user_id)->flush();
        cache()->tags($post::CACHE_PAGINATION_TAG)->flush();
    }

    /**
     * Handle the Post "updating" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        cache()->flush($post->image);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        cache()->tags($post->user_id)->flush();
        cache()->tags($post::CACHE_PAGINATION_TAG)->flush();
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        cache()->tags($post->user_id)->flush();
        cache()->tags($post::CACHE_PAGINATION_TAG)->flush();
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        cache()->tags($post->user_id)->flush();
        cache()->tags($post::CACHE_PAGINATION_TAG)->flush();
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        cache()->tags($post->user_id)->flush();
        cache()->tags($post::CACHE_PAGINATION_TAG)->flush();
    }
}
