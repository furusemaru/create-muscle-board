<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function dashboard()
    {
        $current_user = Auth::id();
        
        $query = Post::where('user_id',$current_user);
        
        
        $query->withCount('reports');
        $query->having('reports_count', '>=', 1);
        $posts = $query->get();
        
        $number = $posts->count();
        
        return view('dashboard',compact('posts','number'));
    }
}
