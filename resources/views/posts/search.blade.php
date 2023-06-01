 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Travelers</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css" >

    </head><body class="antialised">
        <div class="app">
            <div class='posts'>
    
                @foreach ($posts as $post)
                    <div class='post'>
                        <!--user name-->
                        <a href="{{ route('users.show', $post->user_id)}}" class="username">{{ $post->user->name }}</a>
                        
                        <!--編集-->
                        @if(Auth()->user()->id== $post->user_id)
                            <form action="/posts/{{ $post->id }}/edit" class="edit">
                            <button type="submit">編集</button>
                            </form>
                        @endif
                        
                        <!--削除-->
                        <form action="/posts/{{ $post->id }}" id="form_{{ $post->id}}" method="post" class="delete">
                            @csrf
                            @method('DELETE')
                                @if(Auth()->user()->id== $post->user_id)
                                <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                                @endif
                        </form>
                        
                       <!--画像-->
                        <div class='images'>
                            @if($post->images())
                                @foreach($post->images as $image)
                                    <div class="image">
                                        <img src={{ $image->image_url }} alt="画像が読み込めません。"/>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <div class="post-body">
                            <div class="post-info">
                                <p class="prefecture"><i class="fa-solid fa-location-dot"></i>{{ $post->prefecture->name }}</p>
                                <p class='star'><i class="fa-solid fa-star"></i>{{ $post->star }}</p>
                            </div>
                            
                            <div class="post-icons">
                                <!--コメント--> 
                                <a href="" class="comment"> 
                                    <i-1 class="fa-regular fa-comment"></i-1>
                                </a>
                                
                                <!--いいね機能-->
                                <span class="">
                                    @if($post->islike())
                                        <a href="{{ route('unlike',$post) }}" class="likes">
                                            <span class="unlike">
                                                <i-1 class="fa-solid fa-heart"></i-1>
                                            </span>
                                            {{ $post->likes->count() }}
                                        </a>
                                    @else
                                        <a href="{{ route('like',$post) }}" class="likes">
                                            <span class="like">
                                                <i-1 class="fa-regular fa-heart"></i-1>
                                            </span>
                                            {{ $post->likes->count() }}
                                        </a>
                                    @endif    
                                </span>
                            </div>
                        </div>
                        
                        
                        <h4 class='place'>{{ $post->place }}</h4>
                        <!--<h3 class='title'>{{ $post->title}}</h3>-->
                        <p class='body'>{{ $post->body}}</p>
                        
                        <!--コメント表示-->
                        <div class='reply'>
                            @foreach($post->replies as $reply)
                            <p>{{ $reply->user->name }}:{{ $reply->body }}</p>
                            @endforeach
                        </div>
                        <!--コメント追加-->
                        <form action="{{ route('reply.store')}}" method="POST">
                            @csrf
                            <input class="addComment" type="text" name=reply[body] placeholder="コメントを追加">
                            <button class="postComment"type="submit"><input type="hidden" value="{{ $post->id }}" name="reply[post_id]"/>
                            送信</button>
                        </form>
                    </div>
                 @endforeach   
            </div>
            
            <div class="navigation">
                <h1 style="margin-left: 25px">Travelers</h1>
                <div class=navigationMenu>
                    <form  action="/posts/search" method="GET">
                    @csrf
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="search" type="text" name="keyword" placeholder="旅先を入力" >
                    <button class="postSearch" type="submit">検索</i></button>
                    </form>
                        <a href="/"><i class="fa-solid fa-house"></i>ホーム</a><br>
                        <a href="/posts/create"><i class="fa-solid fa-square-plus"></i>投稿</a><br>
                        <a href="/posts/likes"><i class="fa-solid fa-heart"></i>いいね</a><br>
                        <a href=""><i class="fa-solid fa-plane"></i>旅行計画</a><br>
                        <a href="/user"><i class="fa-solid fa-user"></i>マイページ</a><br>
                        <form method="POST" action="{{ route('logout') }}" class="logout">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class='logout'>
                                {{ __('ログアウト') }}
                            </x-dropdown-link>
                        </form>
                </div>
            </div>
            <script>
                function deletePost(id){
                    'use strict'
                    
                    if (confirm('削除すると復元できません。')){
                        document.getElementById(`form_${id}`).submit();
                    }
                }
            </script>  
        </div>
    </body>
</html>