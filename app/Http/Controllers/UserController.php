<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use App\Contracts\CanGenerateProfilePic;

class UserController extends Controller
{
    public function __construct(private Post $post, private PostService $postService, private CanGenerateProfilePic $profilePicGenerator)
    {
        $this->post = $post;
        $this->postService = $postService;

        $this->profilePicGenerator = $profilePicGenerator;
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
        $search = $request->query("search");
        $posts = $this->post->getSearchResultsOfUserPaginated($user->id, $search);


        return view('posts.index', [
            'posts' => $this->postService->includeAuthorNamesInPosts($posts)
        ]);
    }
}
