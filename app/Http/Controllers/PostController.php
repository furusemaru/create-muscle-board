<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\PostLike;
use App\Models\Comment;
use Illuminate\Support\Facades\DB; //
use Illuminate\Pagination\Paginator;
use Cloudinary;
use App\Models\Report;




class PostController extends Controller
{
    //
    /*
    public function index(Post $post, PostRequest $request)
    {
        $instance = $post->getPaginateByLimit();
        return view('posts.index')->with(['posts' => $instance]);
    }
    */
    public function index(Request $request, Category $category)
    {
        $search = $request->input('search');
        $query = Post::query();
            //->with(['categories'])
            //->get();
        //dd($test);
        
        $categories = $category->get();
        
        $input_category = $request->input('category');
        /*
        $query = Post::whereHas('categories',function ($q) {
            $q->where('category')
        })
        */
        if(!empty($input_category)){
            $query->whereHas('categories', function ($name) use ($input_category) {
                $name->where('id',$input_category);
            });
        }
        
        if(!empty($search)) {
            $query->where('title', 'LIKE', "%{$search}%")->orwhere('body', 'LIKE', "%{$search}%");
        }
        
        $sort = $request->input('sort');
        
        if(empty($sort) || $sort == 'new'){
            $posts = $query->orderBy('updated_at', 'DESC')->paginate(10);
        }
        elseif($sort == 'good'){
            $posts = $query->withCount('post_likes')->orderBy('post_likes_count','DESC')->orderBy('updated_at', 'DESC')->paginate(10);
        }
        else{
            $posts = $query->withCount('comments')->orderBy('comments_count','DESC')->orderBy('updated_at', 'DESC')->paginate(10);
        }
        
        
        //$search_categories = $request->categories_array;//検索で入力されたカテゴリidを配列で取得
        
        return view('posts.index', compact('posts', 'search','categories','input_category','sort'));
    }
    
    public function my_posts(Request $request, Category $category){
        $search = $request->input('search');
        
        $current_user = Auth::id();
        
        $query = Post::where('user_id',$current_user);
        
        
        $categories = $category->get();
        
        $input_category = $request->input('category');
        
        if(!empty($input_category)){
            $query->whereHas('categories', function ($name) use ($input_category) {
                $name->where('id',$input_category);
            });
        }
        
        if(!empty($search)) {
            $query->where('title', 'LIKE', "%{$search}%")->orwhere('body', 'LIKE', "%{$search}%");
        }
        
        $sort = $request->input('sort');
        
        if(empty($sort) || $sort == 'new'){
            $posts = $query->orderBy('updated_at', 'DESC')->paginate(10);
        }
        elseif($sort == 'good'){
            $posts = $query->withCount('post_likes')->orderBy('post_likes_count','DESC')->orderBy('updated_at', 'DESC')->paginate(10);
        }
        else{
            $posts = $query->withCount('comments')->orderBy('comments_count','DESC')->orderBy('updated_at', 'DESC')->paginate(10);
        }
        
        
        //$search_categories = $request->categories_array;//検索で入力されたカテゴリidを配列で取得
        
        return view('posts.my_index', compact('posts', 'search','categories','input_category','sort'));
    }
    
    public function related_posts(Request $request, Category $category){
        $search = $request->input('search');
        
        $current_user = Auth::id();
        
        $query = Post::whereHas('post_likes', function($inp) {
            $inp->where('user_id', Auth::id());
        })
        ->orWhereHas('comments', function($inp2) {
            $inp2->where('user_id', Auth::id());
        });
        
        
        $categories = $category->get();
        
        $input_category = $request->input('category');
        
        if(!empty($input_category)){
            $query->whereHas('categories', function ($name) use ($input_category) {
                $name->where('id',$input_category);
            });
        }
        
        if(!empty($search)) {
            $query->where('title', 'LIKE', "%{$search}%")->orwhere('body', 'LIKE', "%{$search}%");
        }
        
        $sort = $request->input('sort');
        
        if(empty($sort) || $sort == 'new'){
            $posts = $query->orderBy('updated_at', 'DESC')->paginate(10);
        }
        elseif($sort == 'good'){
            $posts = $query->withCount('post_likes')->orderBy('post_likes_count','DESC')->orderBy('updated_at', 'DESC')->paginate(10);
        }
        else{
            $posts = $query->withCount('comments')->orderBy('comments_count','DESC')->orderBy('updated_at', 'DESC')->paginate(10);
        }
        
        
        //$search_categories = $request->categories_array;//検索で入力されたカテゴリidを配列で取得
        
        return view('posts.related_posts', compact('posts', 'search','categories','input_category','sort'));
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
        if($request->file('image')){
            $image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $input += ['image' => $image];
        }
        
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
        
        if($request->image != null)
        {
            $file_name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/post_image', $file_name);
            $post->image = 'storage/post_image/' .  $file_name;
        }
        
        
        $input_post = $request['post'];
        $post->fill($input_post);
        $post->user_id = Auth::id();
        $post->save();
        
        $input_categories = $request->categories_array;
        $post->categories()->sync($input_categories);
    
        return redirect('/posts/' . $post->id);
    }
    
    public function like(Post $post)
    {
        //console.log('ok');
        PostLike::create([
        'post_id' => $post->id,
        'user_id' => Auth::id(),
        ]);
        //Log::debug($post);
        
        return redirect()->back();
    }
    public function unlike(Post $post)
    {
        $like = PostLike::where('post_id', $post->id)->where('user_id', Auth::id())->first();
        $like->delete();
        
        return redirect()->back();
    }
    
    public function report(Post $post)
    {
        Report::create([
        'post_id' => $post->id,
        'user_id' => Auth::id()
        ]);
        
        return redirect()->back();
    }
    
    public function unreport(Post $post)
    {
        $report = Report::where('post_id', $post->id)->where('user_id', Auth::id())->first();
        $report->delete();
        
        return redirect()->back();
    }
    
    
}
