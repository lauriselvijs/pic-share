<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{

    /**
     * Return all posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = Post::latest()->filter(request(['tag', 'search']))->paginate(9);

        foreach ($posts as $post) {
            $post['author'] = Post::getPostAuthorName($post->id);
        }

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show single post
     *
     * @param App\Models\Post $post
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Post $post)
    {
        $post['author'] = Post::getPostAuthorName($post->id);

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
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
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
        $formData = $request->validated();

        $imageName = Storage::disk('media')->put('images', $request->file('image'));
        $imagePath = parse_url(Storage::disk('media')->url($imageName))['path'];

        $formData['image'] = $imagePath;
        $formData['user_id'] = auth()->id();

        Post::create($formData);

        return redirect()->route('posts.index')->with('message',  __('post.created'));
    }

    /**
     * Show edit post form
     *
     * @param App\Models\Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function edit(Post $post)
    {
        $post['author'] = Post::getPostAuthorName($post->id);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update existing post
     *
     * @param App\Models\Post $post
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
        // TODO:
        // [] - implement policies or  access delegation
        $post->delete();

        return redirect()->route('posts.index')->with('message',  __('post.deleted'));
    }
}
