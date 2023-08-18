<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\PostLike;


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
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
    public function edit(Post $post, Category $category)
    {
        return view('posts.edit')->with(['post' => $post,'categories' => $category->get()]);
    }
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post);
        $post->user_id = Auth::id();
        $post->save();
        
        $input_categories = $request->categories_array;
        $post->categories()->sync($input_categories);
    
        return redirect('/posts/' . $post->id);
    }
    
    public function like($id)
    {
        PostLike::create([
        'post_id' => $id,
        'user_id' => Auth::id(),
        ]);
        
        return redirect()->back();
    }
    public function unlike($id)
    {
        $like = PostLike::where('post_id', $id)->where('user_id', Auth::id())->first();
        $like->delete();
        
        return redirect()->back();
    }
}
