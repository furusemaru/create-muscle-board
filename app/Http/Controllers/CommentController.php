<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostRequest;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    //
    public function store(PostRequest $request)
    {
        //console.log('ok');
        /*
        $inputs = request()->validate([
            'body' => 'required|max:255'
        ]);
        */
        console.log("iii");
        Comment::create([
        'body' => $request->body,
        'user_id' => Auth::id(),
        'post_id' => $request->post_id,
        ]);
        //console.log('ok');
        return redirect('/posts/' . $post->id);
    }
    public function destroy(PostRequest $request)
    {
        
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        //↓保留
        return redirect('/');
    }
}
