<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function follow(User $user, Request $request)
    {   
        $follow = new Friend();
        $follow->follower_id=Auth::user()->id;
        $follow->followee_id=$user->id;
        $follow->save();
        return back();
    }
    
    public function unfollow(User $user, Request $request)
        
    {
        $unfollow=Friend::where('follower_id',Auth::user()->id)->where('followee_id',$user->id)->first();
        $unfollow->delete();
        return back();
    }
}
