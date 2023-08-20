<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'title',
        'body',
        'image_file_name',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function post_likes()
    {
        return $this->hasMany(PostLike::class,'post_id');    
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class,'post_id');
    }
    public function getByLimit(int $limit_count = 10)
    {
        return $this->orderBy('updated_at', 'DESC')->limit($limit_count)->get();
    }
    public function getPaginateByLimit(int $limit_count = 1)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    public function is_liked_by_auth_user()
    {
        $id = Auth::id();
        
        $likers = array();
        
        foreach($this->post_likes as $like) {
            array_push($likers, $like->user_id);
        }

        if (in_array($id, $likers)) {
          return true;
        } else {
          return false;
        }
    }
}
