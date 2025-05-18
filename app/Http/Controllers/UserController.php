<?php

namespace App\Http\Controllers;

use App\Contracts\CanGenerateProfilePic;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
        private Post $post,
        private PostService $postService,
        private CanGenerateProfilePic $profilePicGenerator,
    ) {}

    /**
     * Get all user posts
     */
    public function posts(Request $request, User $user): View
    {
        $search = $request->query('search');
        $page = $request->query('page');

        $posts = $this->post->getSearchResultsOfUserPaginated($user->id, $search, $page);

        return view('posts.index', [
            'posts' => $this->postService->includeAuthorNamesAndGenImgUrlFor($posts),
        ]);
    }

    public function locale($locale)
    {
        $this->userService->setLocal($locale);

        return redirect()->back();
    }
}
