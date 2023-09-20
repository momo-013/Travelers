<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Jobs\LikeJob;

class LikeController extends Controller
{
    // public function like(Post $post, Request $request)
    // {
    //     // LikeJob::dispatch($post, Auth::user()->id); //ジョブをディスパッチ
        
    //     // return back();
    //     $like= new Like(); //インスタンス化
    //     $like->post_id=$post->id;
    //     $like->user_id=Auth::user()->id;
    //     $like->save;
        
        

    //     return back();
    // }
    
    // public function unlike(Post $post, Request $request)
    // {
    //     // LikeJob::dispatch($post, Auth::user()->id);
        
    //     // return back();
    //     $user=Auth::user()->id;
    //     $like=Like::where('post_id', $post->id)->where('user_id',$user)->first();
    //     $like->delete();
        

    //     return back();
    // }
    
    public function like(Post $post, Request $request)
    {
        $post_id = $request->post_id;
        $user_id = Auth::user()->id;
        $already_liked = Like::where('user_id', $user_id)->where('post_id',$post_id)->first();
        if(!$already_liked){
            $like = new Like;
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->save();
        }else{
            Like::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }
        
        //5.この投稿の最新の総いいね数を取得
        $post_likes_count = Post::withCount('likes')->findOrFail($post_id)->likes_count;
        $param = [
            'post_likes_count' => $post_likes_count,
        ];
        return response()->json($param); //6.JSONデータをjQueryに返す
    }
}
