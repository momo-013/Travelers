<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Prefecture;
use App\Models\Image;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Cloudinary;

class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = $post->get();
        return view('posts/index')->with(['posts' => $posts]);
    }
    
    public function create(Prefecture $prefecture)
    {
        return view('posts/create')->with(['prefectures' => $prefecture->get()]);
    }
    
    public function store(PostRequest $request, Post $post, Image $image_model)
    {   
        $input = $request['post'];
        $input['user_id'] = Auth::id();
        $post->fill($input)->save();
        //画像保存処理
        
        $images = $request->file('images');
        if ($images){
            foreach($images as $image){   
            $input_image['image_url'] = Cloudinary::upload($image->getRealPath(),['width' => 190,'height' => 190])->getSecurePath();
            $input_image['post_id'] = $post->id;
            $new_image_model = new Image();
            $new_image_model->image_url = $input_image['image_url'];
            $new_image_model->post_id = $input_image['post_id'];
            $new_image_model->save();
            }
        }
        
        return redirect('/');
    }
    
    public function edit(Post $post, Prefecture $prefecture)
    {
        return view('posts/edit')
        ->with([ 'post' => $post])
        ->with(['prefectures' => $prefecture->get()]);
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
    
    public function reply(Post $post)
    {
        return view('posts/reply')->with(['post' => $post]);
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        $query = Post::with('prefecture');
        
        if(!empty($keyword))
        {
            $query->where('place','LIKE',"%{$keyword}%")
                ->orWhereHas('prefecture', function($query) use ($keyword) 
                {
                   $query->where('name', 'LIKE', "%{$keyword}%");
                });
        }
        $posts = $query->orderBy('star','DESC')->get();
        
        
        
        return view('posts/search')->with(['posts'=> $posts ]);
    }
    
    public function likes(Post $post)
    {
        
        // $like_posts = Auth::user()->likes()->get();
        $like_posts = Auth::user()->likeposts()->orderBy('created_at', 'desc')->get();
        return view('posts/likes')->with(['posts'=>$like_posts]);
    }
}


