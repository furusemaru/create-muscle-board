<?php

namespace App\Http\Controllers;
use App\Http\Requests\CommentRequest;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentController extends Controller
{
    //
    public function store(CommentRequest $request)
   {
        $input = $request['comment'];
        
        //console.log('ok');
        $comment = Comment::create([
            'body' => $input['body'],
            'user_id' => auth()->user()->id,
            'post_id' => $request->post_id
        ]);
        return back();
   }
   
   public function delete(Comment $comment_id)
    {
        $comment_id->delete();
        return back();
    }
}
