<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->input('reply');
    
        // 必要なバリデーションを追加することをおすすめします
    
        // 新しいコメントを作成
        $reply = new Reply();
        $reply->body = $input['body'];
        $reply->post_id = $input['post_id'];
        $reply->user_id = auth()->user()->id; // ログインユーザーのID\
        
        if ($reply->save()) {
            // コメントに関連するユーザー情報を取得
            $user = $reply->user;
            return response()->json([
                'success' => true,
                'reply' => $reply,
                'user' => $user, // ユーザーオブジェクトを含める
            ]);
            dd($user);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'コメントの追加に失敗しました。',
            ], 500); // エラーコードは適宜変更してください
        }
    //     $input = $request->input('reply');
    // $input['user_id'] = Auth::user()->id;
    
    // if ($input['body']) {
    //     $reply = Reply::with('user')->create($input);
    //     // $reply->load('user'); // ユーザーリレーションを読み込む

    //     return response()->json(['success' => true, 'reply' => $reply]);
    // }
    
    // return response()->json(['success' => false]);
    }

    public function destroy(Request $request)
    {
        $reply = Reply::find($request->reply_id);

        if ($reply) {
            $reply->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    
   public function store2(Request $request)
    {
        $input = $request->input('reply');
    
        // 必要なバリデーションを追加することをおすすめします
    
        // 新しいコメントを作成
        $reply = new Reply();
        $reply->body = $input['body'];
        $reply->post_id = $input['post_id'];
        $reply->user_id = auth()->user()->id; // ログインユーザーのID
    
        if ($reply->save()) {
            // コメントに関連するユーザー情報を取得
            $user = $reply->user;
    
            return response()->json([
                'success' => true,
                'reply' => $reply,
                'user' => $user, // ユーザーオブジェクトを含める
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'コメントの追加に失敗しました。',
            ], 500); // エラーコードは適宜変更してください
        }
    }

    
    public function getComments($postId)
    {
        // 特定の投稿に関連するコメントを取得（ユーザー情報も一緒にロード）
        $comments = Reply::with('user')->where('post_id', $postId)->get();
        
        // コメントデータをJSON形式で返す
        return response()->json(['comments' => $comments]);
    }

    
    
    
    
    // public function store(Request $request, Reply $reply)
    // {
    //     $input = new Reply(); 
    //     $input = $request['reply'];
    //     $input['user_id']= Auth::user()->id;
    //     if($input['body']){
    //         $reply->fill($input)->save();
    //     }
        
    //     return redirect('/');
    // }
    
    // public function destroy(Request $request)
    // {
    //     $reply = Reply::find($request->reply_id);
    //     $reply->delete();
    //     return redirect('/');
    // }
}
