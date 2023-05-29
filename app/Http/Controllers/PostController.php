<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{

    public function __construct(private Post $post, private PostService $postService)
    {
        $this->post = $post;
        $this->postService = $postService;
    }

    /**
     * Return all posts
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $page = $request->query('page');

        $posts = $this->post->getSearchResultsWithAuthorPaginated($search, $page);

        return view('posts.index', [
            'posts' => $this->postService->includeAuthorNamesAndGenImgUrlFor($posts)
        ]);
    }

    /**
     * Show single post
     */
    public function show(Post $post): View
    {

        return view(
            'posts.show',
            [
                'post' =>  $this->postService->includeAuthorNameAndGenImgUrlFor($post)
            ]
        );
    }

    /**
     * Show create post form
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store new post in DB
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $this->postService->store([...$request->validated(), 'user_id' => auth()->id()]);

        return redirect()->route('posts.index')->with('message',  __('post.created'));
    }

    /**
     * Show edit post form
     */
    public function edit(Post $post): View
    {
        $this->authorize('edit', $post);

        $post->image = $this->postService->generateTempUrlForImg($post->image);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update existing post
     */
    public function update(Post $post, UpdatePostRequest $request): RedirectResponse
    {
        $this->postService->update($post, $request->validated());

        return redirect()->route('posts.index')->with('message',  __('post.updated'));
    }

    /**
     * Remove post from DB
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        return redirect()->route('posts.index')->with('message',  __('post.deleted'));
    }
}
