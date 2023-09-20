<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $userId;
    
    
    /**
     * Create a new job instance.
     *
     * @param int $post_id
     * @param int $user_id
     * @return void
     */
    public function __construct($post, $userId)
    {
        $this->post = $post;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Likeを作成または削除する処理をここに移動します
        $like = Like::where('post_id', $this->post->id)->where('user_id', $this->userId)->first();
        if (!$like) {
            // いいねが存在しない場合、新しいLikeを作成
            $like = new Like();
            $like->post_id = $this->post->id;
            $like->user_id = $this->userId;
            $like->save();
        } else {
            // いいねが存在する場合、Likeを削除
            $like->delete();
        }
    }
}
