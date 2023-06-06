<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use App\Contracts\CanGenerateProfilePic;
use App\Http\Middleware\SetAppLocale;
use App\Services\UserService;

class UserController extends Controller
{

    public function __construct(
        private Post $post,
        private PostService $postService,
        private CanGenerateProfilePic $profilePicGenerator,
        private UserService $userService,
    ) {
        $this->post = $post;
        $this->postService = $postService;
        $this->profilePicGenerator = $profilePicGenerator;
        $this->$userService = $userService;
    }

    /**
     * Get all user posts
     */
    public function posts(Request $request, User $user): View
    {
        $search = $request->query('search');
        $page = $request->query('page');

        $posts = $this->post->getSearchResultsOfUserPaginated($user->id, $search, $page);

        return view('posts.index', [
            'posts' => $this->postService->includeAuthorNamesAndGenImgUrlFor($posts)
        ]);
    }

    public function locale($locale)
    {
        $this->userService->setLocal($locale);

        return redirect()->back();
    }
}
