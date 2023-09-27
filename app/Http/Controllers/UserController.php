<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function dashboard()
    {
        $current_user = Auth::id();
        
        $query = Post::where('user_id',$current_user);
        
        $posts = $query->has('reports','>=', 1)->get();
        
        $number = $posts->count();
        
        return view('dashboard',compact('posts','number'));
    }
}
