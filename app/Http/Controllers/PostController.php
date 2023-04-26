<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Post $post)
    {
        return view('posts/index')->with(['posts' => $post->orderBy('created_at','DESC')->get()]);
    }
    
    public function create()
    {
        return view('posts/create');
    }
    
    
    public function store(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        $input['user_id'] = Auth::id();
        $post->fill($input)->save();
        return redirect('/');
    }
    
    public function edit(Post $post)
    {
        return view('posts/edit')->with([ 'post' => $post]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/');
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
}
