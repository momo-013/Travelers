<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

class UserController extends Controller
{
    public function index(Post $post)
    {
        $posts = Post::where('user_id', Auth::id())->orderBy('created_at','desc')->get();
        return view('users/index',[
            'posts'=> $posts,
            ]);
    }

    
    public function show(User $user,Post $post)
    {   
        if($user->id == Auth::user()->id)
        {
            $posts = Post::where('user_id', Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('users/index',[
            'posts'=> $posts,
            ]);
        }
        else
        $posts = Post::where('user_id', $user->id)->orderBy('created_at','desc')->get();
        
        return view('users/show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }

}
