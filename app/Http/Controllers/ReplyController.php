<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request, Reply $reply)
    {
        $input = new Reply(); 
        $input = $request['reply'];
        $input['user_id']= Auth::user()->id;
        if($input['body']){
            $reply->fill($input)->save();
        }
        
        return redirect('/');
    }
    
    public function destroy(Request $request)
    {
        $reply = Reply::find($request->reply_id);
        $reply->delete();
        return redirect('/');
    }
}
