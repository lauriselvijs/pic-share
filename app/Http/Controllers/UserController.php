<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get all user posts
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function posts(User $user)
    {
        $posts = Post::latest()->where('user_id', $user->id)->filter(request(['tag', 'search']))->paginate(9);

        foreach ($posts as $post) {
            $post['author'] = Post::getPostAuthorName($post->id);
        }

        return view('posts.index', [
            'posts' => $posts
        ]);
    }
}
