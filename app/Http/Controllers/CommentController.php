<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostRequest;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    public function store(PostRequest $request)
   {
        $comment = Comment::create([
            'body' => $inputs['body'],
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id
        ]);

        return back();
   }
   
   public function destroy(PostRequest $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        //↓保留
        return redirect('/');
    }
}
