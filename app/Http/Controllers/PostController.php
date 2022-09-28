<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
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
        $posts = $this->post->paginate($request->only(Post::FILTERS));

        $this->postService->setAuthorNamesTo($posts);

        return view('posts.index', [
            'posts' => $posts
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
        $this->postService->setAuthorNameTo($post);

        return view(
            'posts.show',
            [
                'post' => $post
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
        $postData = $request->validated();

        $imagePath = $this->postService->returnPathOf($postData['image']);
        $userId = auth()->id();

        $this->postService->store($postData, $userId, $imagePath);

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

        // $post['author'] = $post->user->name;

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
        $formData = $request->validated();

        if ($request->hasFile('image')) {
            $imageName = Storage::disk('media')->put('images', $request->file('image'));
            $imagePath = parse_url(Storage::disk('media')->url($imageName))['path'];

            $formData['image'] = $imagePath;
        }

        $post->update($formData);

        return redirect()->route('posts.index')->with('message',  __('post.updated'));
    }

    /**
     * Remove post from DB
     *
     * @param App\Models\Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('message',  __('post.deleted'));
    }
}
