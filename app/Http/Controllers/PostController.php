<?php

namespace App\Http\Controllers;

use App\Contracts\CanCaptureScreenshot;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    public function __construct(private Post $post, private PostService $postService)
    {
        $this->post = $post;
        $this->postService = $postService;
    }
    /**
     * Return all posts
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $posts = $this->post->paginate($request->only($this->post::FILTERS));

        return view('posts.index', [
            'posts' => $this->postService->includeAuthorNamesInPosts($posts)
        ]);
    }

    /**
     * Show single post
     *
     * @param Post $post
     * @return View
     */
    public function show(Post $post): View
    {
        return view(
            'posts.show',
            [
                'post' =>  $this->postService->includeAuthorNameInPost($post)
            ]
        );
    }


    /**
     * Show create post form
     *
     * @return View
     */
    public function create(): View
    {
        return view('posts.create');
    }

    /**
     * Store new post in DB
     *
     * @param StorePostRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(StorePostRequest $request)
    {
        $this->postService->store([...$request->validated(), 'user_id' => auth()->id()]);

        return redirect()->route('posts.index')->with('message',  __('post.created'));
    }

    /**
     * Show edit post form
     *
     * @param Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update existing post
     *
     * @param Post $post
     * @param UpdatePostRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Post $post, UpdatePostRequest $request)
    {
        $this->postService->update($post, $request->validated());

        return redirect()->route('posts.index')->with('message',  __('post.updated'));
    }

    /**
     * Remove post from DB
     *
     * @param Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $this->postService->delete($post);

        return redirect()->route('posts.index')->with('message',  __('post.deleted'));
    }
}
