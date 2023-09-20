<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Like;
use App\Models\Frined;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    // public function likes()
    // {
    //     return $this->hasMany(Like::class);
    // }
     public function likes()
    {
        return $this->hasManyThrough(Post::class, Like::class, 'user_id', 'id', 'id', 'post_id');
    }
    
    public function likeposts()
    {
        return $this->belongsToMany(Post::class,'likes','post_id','user_id');
    }
    
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //フォローしているユーザー
    public function followings()
    {
        return $this->BelongsToMany('App\Models\User', 'friends', 'follower_id', 'followee_id');
    }
    
    //フォロワー
    public function followers()
    {
        return $this->BelongsToMany('App\Models\User', 'friends', 'followee_id', 'follower_id');
    }
    
    //フォローしているかどうか判別
    public function isfollow(): bool
    {
        return Friend::where('follower_id',Auth::id())->where('followee_id', $this->id)->first()!==null;
    }
}
