<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('tags')->withCount('comments');

        if ($request->has('tag')) {
            $tagname = $request->tag;
            $query->whereHas('tags', function ($q) use ($tagname) {
                $q->where('name', $tagname);
            });
        }
        $posts = $query->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('tags', 'comments')->findOrFail($id);
        return view('posts.show', compact('post'));
    }

}
