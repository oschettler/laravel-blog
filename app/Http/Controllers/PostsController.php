<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('posts.index', [
            'posts' => Post::search($request->input('q'))
                             ->with('author', 'media')
                             ->withCount('comments', 'likes')
                             ->latest()
                             ->paginate(10)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if (!empty($post->redirect_url)) {
            $url = $post->redirect_url;
            if (!preg_match('#^http(s?)://#', $url)) {
                $url = config('app.prod_url') . $url;
            }
            return redirect($url);
        }

        $post->comments_count = $post->comments()->count();
        $post->likes_count = $post->likes()->count();

        return view('posts.show', [
            'post' => $post
        ]);
    }
}
