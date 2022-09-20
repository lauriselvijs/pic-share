<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    /**
     * Return all posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $posts = Post::latest()->filter(request(["tag", "search"]))->paginate(9);

        foreach ($posts as $post) {
            $post["author"] = Post::getPostAuthorName($post->id);
        }

        return view("posts.index", [
            "posts" => $posts
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
        $post["author"] = Post::getPostAuthorName($post->id);

        return view(
            "posts.show",
            [
                "post" => $post
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
        return view("posts.create");
    }

    /**
     * Store new post in DB
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $formData = $request->validate([
            "title" => "required|string",
            "image" => "required|image|mimes:jpeg,png",
            "tags" => "nullable|sometimes|string|filled",
        ]);

        $imageName = Storage::disk("media")->put("images", $request->file("image"));
        $imagePath = parse_url(Storage::disk("media")->url($imageName))["path"];

        $formData["image"] = $imagePath;
        $formData["user_id"] = auth()->id();

        Post::create($formData);

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Post has been added to PicShare successfully!'));
    }

    /**
     * Show edit post form
     *
     * @param App\Models\Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function edit(Post $post)
    {
        $post["author"] = Post::getPostAuthorName($post->id);

        return view("posts.edit", ["post" => $post]);
    }

    /**
     * Update existing post
     *
     * @param App\Models\Post $post
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Post $post, Request $request)
    {
        //Check if user have permission
        if ($post->user_id !== auth()->id()) {
            abort(403, "Unauthorized action");
        }

        $formData = $request->validate([
            "title" => "sometimes|required|string",
            "image" => "sometimes|required|image|mimes:jpeg,png",
            "tags" => "nullable|sometimes|string|filled",
        ]);

        if ($request->hasFile("image")) {
            $imageName = Storage::disk("media")->put("images", $request->file("image"));
            $imagePath = parse_url(Storage::disk("media")->url($imageName))["path"];

            $formData["image"] = $imagePath;
        }

        $post->update($formData);

        return back()->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Post has been update!'));
    }

    /**
     * Remove post from DB
     *
     * @param App\Models\Post $post
     * @return \Illuminate\Routing\Redirector
     */
    public function delete(Post $post)
    {
        //Check if user have rights
        if ($post->user_id !== auth()->id()) {
            abort(403, "Unauthorized action");
        }


        $post->delete();

        return redirect("/")->with("message",  array('msgTitle' => 'Success!', 'msgInfo' => 'Post has been deleted'));
    }

    /**
     * Get all user posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function userPosts()
    {
        $posts = Post::latest()->where("user_id", auth()->id())->filter(request(["tag", "search"]))->paginate(9);

        foreach ($posts as $post) {
            $post["author"] = Post::getPostAuthorName($post->id);
        }

        return view("posts.index", [
            "posts" => $posts
        ]);
    }
}
