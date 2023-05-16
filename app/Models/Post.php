<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Prefecture;
use App\Models\Image;
use App\Models\Like;
use App\Models\Reply;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'place',
        'star',
        'title',
        'body',
        'user_id',
        'prefecture_id',
        'image_url'
        ];
        
    public function get()
    {
        return $this::with('prefecture')->orderBy('created_at','DESC')->get();
    }
    
    public function ranking()
    {
        return $this::with('prefecture')->orderBy('star','DESC')->get();
    }
    
    
    public function user()
    {
         return $this->belongsTo(User::class);
    }
    
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
    //いいねをすでに押せれているか判別するメソッド
    public function islike(): bool 
    {
        return Like::where('user_id', Auth::id())->where('post_id', $this->id)->first()!==null; //条件
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
