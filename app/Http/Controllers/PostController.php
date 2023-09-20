<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Like;
use App\Models\Prefecture;
use App\Models\Image;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Cloudinary;
use Illuminate\Support\Facades\Storage;
use InterventionImage;


class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = $post->orderBy('created_at','desc')->take(50)->get();
        return view('posts/index')->with(['posts' => $posts]);
    }
    
    public function follow(Post $post)
    {
        //フォローしているユーザのID取得
        $followedUserIds = Auth::user()->followings()->pluck('followee_id');
        
        //フォローしているユーザの投稿を取得
        $posts = Post::whereIn('user_id',$followedUserIds)->orderBy('created_at','desc')->take(50)->get();
        
        return view('posts/follow')->with(['posts' => $posts]);
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
        if ($images) {
            foreach ($images as $image) {
                $filename = $image->getClientOriginalName();
                $imagePath = $image->storeAs('public/images', $filename);
        
                //画像のリサイズ処理
                $resizedImage = InterventionImage::make($image)->fit(190,190,
                function ($constraint) {
                    $constraint->upsize();})
                    ->save(public_path('storage/images/' . $filename));
                    
                // $resizedImage = InterventionImage::make($image)
                // ->fit(190, 190, function ($constraint) {
                //     $constraint->upsize();
                // })
                // ->encode('jpg') // ここで画像を JPEG 形式にエンコード
                // ->save(public_path('storage/images/' . $filename . '.jpg')); // ファイル名を .jpg として保存
        
                // Image モデルへの保存
                $input_image['image_url'] = 'storage/images/' . $filename;
                $input_image['post_id'] = $post->id;
        
                $new_image_model = new Image();
                $new_image_model->image_url = $input_image['image_url'];
                $new_image_model->post_id = $input_image['post_id'];
                $new_image_model->save();
            }
        }

        // $images = $request->file('images');
        // if ($images) {
        //     foreach ($images as $image) {
        //         $filename = $image->getClientOriginalName();
        //         $imagePath = $image->storeAs('public/images', $filename);
        //         dd($filename);
    
        //         // 画像のリサイズ処理を追加
        //         $resizedImage = InterventionImage::make($image)->resize(540,null,function ($constraint)
        //         {
        //             $constraint->aspectRatio()
        //         ;})
        //         ->save(public_path('storage/images'.$filename));
    
        //         $input_image['image_url'] = $imagePath;
        //         $input_image['post_id'] = $post->id;
    
        //         $new_image_model = new Image();
        //         $new_image_model->image_url = 'storage/images/' . $filename; 
        //         $new_image_model->post_id = $input_image['post_id'];
        //         $new_image_model->save();
        //     }
        // }
        
        // $images = $request->file('images');
        // if ($images){
        //     foreach($images as $image){
        //         $filename = $image->getClientOriginalName();
        //         $input_image['image_url'] = $image->storeAs('public/images', $filename);
        //         $input_image['post_id']= $post->id;
                
        //         $new_image_model = new Image();
        //         $new_image_model->image_url = $filename;
        //         $new_image_model->post_id = $input_image['post_id'];
        //         $new_image_model->save();

        //     }
        // }
        // $images = $request->file('images');
        // if ($images){
        //     foreach($images as $image){   
        //     $input_image['image_url'] = Cloudinary::upload($image->getRealPath(),['width' => 190,'height' => 190])->getSecurePath();
        //     $input_image['post_id'] = $post->id;
        //     $new_image_model = new Image();
        //     $new_image_model->image_url = $input_image['image_url'];
        //     $new_image_model->post_id = $input_image['post_id'];
        //     $new_image_model->save();
        //     }
        // }
        
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
        
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('place', 'LIKE', "%{$keyword}%")
                      ->orWhereHas('prefecture', function ($query) use ($keyword) {
                          $query->where('name', 'LIKE', "%{$keyword}%");
                      });
            });
        }
        
        $posts = $query->orderBy('star', 'DESC')->get();
        
        return view('posts/search')->with(['posts' => $posts, 'keyword' => $keyword]);
    }

    // public function search(Request $request)
    // {
    //     $keyword = $request->input('keyword');
        
    //     $query = Post::with('prefecture');
        
    //     if(!empty($keyword))
    //     {
    //         $query->where('place','LIKE',"%{$keyword}%")
    //             ->orWhereHas('prefecture', function($query) use ($keyword) 
    //             {
    //               $query->where('name', 'LIKE', "%{$keyword}%");
    //             });
    //     }
    //     $posts = $query->orderBy('star','DESC')->get();
    //     dd($posts);
        
        
    //     return view('posts/search')->with(['posts'=> $posts ]);
    // }
    
    // public function likes(Post $post)
    // {
        
    //     // $like_posts = Auth::user()->likes()->get();
    //     dd(Auth::user());
    //     $like_posts = Auth::user()->likeposts()->orderBy('created_at', 'desc')->get();
        
    //     return view('posts/likes')->with(['posts'=>$like_posts]);
    // }
    
    public function likes(Post $post)
    {
        $userId = Auth::id(); // ログインしているユーザーのIDを取得

        $likedPosts = User::find($userId)->likes()->orderBy('created_at', 'desc')->get();
        
        return view('posts/likes')->with(['posts'=>$likedPosts]);
    }
}


