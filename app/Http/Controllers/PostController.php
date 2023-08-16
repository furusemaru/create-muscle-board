<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class PostController extends Controller
{
    //
    public function index(Post $post)
    {
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit()]);
    }
    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }
    public function create(Category $category)
    {
        return view('posts.create')->with(['categories' => $category->get()]);
    }
    public function store(PostRequest $request, Post $post)
    {
        //postに関して
        $input = $request['post'];
        $post->fill($input);
        $post->user_id = Auth::id();
        $post->save();
        
        $input_categories = $request->categories_array;
        $post->categories()->attach($input_categories);
        
        return redirect('/posts/' . $post->id);
    }
}
