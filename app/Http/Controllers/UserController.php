<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function __construct(private Post $post, private PostService $postService)
    {
        $this->post = $post;
        $this->postService = $postService;
    }

    /**
     * Get all user posts
     *
     * @param Request $request
     * @param User $user
     * @return View
     */
    public function posts(Request $request, User $user): View
    {
        $posts = $this->post->paginatePostsContains($user->id, $request->only(Post::FILTERS));

        return view('posts.index', [
            'posts' => $this->postService->includeAuthorNamesInPosts($posts)
        ]);
    }
}
