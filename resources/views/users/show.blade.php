<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Travelers</title>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css" >
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body class="">
     <div class="app">
        <div class='posts'>
            <!--フォロー機能-->
            <div class="follows">
                @if($user->isfollow())
                    <form id="unfollow-form" action="/unfollow/{{ $user->id }}" method="POST" >
                        @csrf
                        <button id="unfollow-button" type="submit" class='unfollow'>フォロー解除</button>
                    </form>
                @else
                    <form id="follow-form" action="/follow/{{ $user->id }}" method="POST" >
                        @csrf
                        <button id="follow-button" type="submit" class="follow">フォローする</button>
                    </form>
                @endif
            </div>
            
            <div class='profile'>
                <p class='other-username'>{{ $user->name }}</p>
                <p class=''>{{ $posts->count() }}投稿　　 {{ $user->followers->count() }}フォロワー　　 {{ $user->followings->count() }}フォロー</p>
            </div>
            
            <div>
                @if($posts->isEmpty())
                <p>まだ投稿がありません</p>
                @endif
            </div>
            
            
            @foreach ($posts as $post)
                <div class='post'>
                    <!--user name-->
                    <p class="username">{{ $user->name }}</p>
                    
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
                            <button type="button" class="icon showComment" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $post->id }}" data-bs-whatever="@mdo" data-post-id="{{ $post->id }}"><i class="fa-regular fa-comment"></i></button>
                            <!--モーダルダイアログ-->
                            <div class="modal fade" id="exampleModal{{ $post->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <p class="modal-title" id="exampleModalLabel">{{ $post->user->name }}</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  
                                  
                                  <!-- HTML部分 -->
                                    <div class="modal-body">
                                        <p>{{ $post->user->name }}:{{ $post->body }}</p>
                                        
                                        <div class='reply' data-post-id="{{ $post->id }}">
                                            @foreach($post->replies as $reply)
                                            <p>{{ $reply->user->name }}:{{ $reply->body }}<a class="reply-link" data-username="{{ $reply->user->name }}">返信</a></p>
                                            @endforeach
                                        </div>
                                    </div>
                            
                                    <div class="modal-footer">
                                        <form class="comment-form" action="{{ route('reply.store') }}" method="POST">
                                            @csrf
                                            <input class="reply-input" type="text" name="reply[body]" placeholder="コメントを追加">
                                            <input type="hidden" value="{{ $post->id }}" name="reply[post_id]">
                                            <button class="btn btn-primary postComment" type="submit" disabled> 送信</button>
                                        </form>
                                    </div>
                                    
                                </div>
                              </div>
                            </div>
                            
                            <!--いいね機能-->
                                <span class="like">
                                    @if($post->islike())
                                        <span class="likes">
                                            <i-1 class="fa-regular fa-heart like-toggle liked" data-post-id="{{ $post->id }}"></i-1>
                                        <span class='like-counter'>{{ $post->likes->count() }}</span>
                                        </span><!-- /.likes -->
                                    @else
                                        <span class="likes">
                                            <i-1 class="fa-regular fa-heart like-toggle" data-post-id="{{ $post->id }}"></i-1>
                                        <span class='like-counter'>
                                        {{ $post->likes->count() }}
                                        </span>
                                        </span><!-- /.likes -->
                                    @endif    
                                </span>
                        </div>
                    </div>
                    
                    
                    <h4 class='place'>{{ $post->place }}</h4>
                    <!--<h3 class='title'>{{ $post->title}}</h3>-->
                    <p class='body'>{{ $post->body}}</p>
                    
                    <!-- コメントを表示ボタン -->
                    <div class='show-Comment'>
                        <button type="button" class="showComment" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $post->id }}" data-bs-whatever="@mdo" data-post-id="{{ $post->id }}">コメントを全て表示</button>
                    </div>
                   
                    <!--コメント追加-->
                    <!-- モーダル外のコメント追加フォーム -->
                    <form class="comment-form-external" action="{{ route('reply.store.external') }}" method="POST">
                        @csrf
                        <input class="addComment" type="text" name="reply[body]" placeholder="コメントを追加">
                        <input type="hidden" name="reply[post_id]" value="{{ $post->id }}">
                        <button class="postComment postComment-external" type="submit" disabled>送信</button>
                    </form>
                </div>
             @endforeach   
        </div>
            
        <div class="navigation">
            <h1 style="margin-left: 25px">Travelers</h1>
            <div class=navigationMenu>
                <form action="/posts/search" method="GET">
                    @csrf
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="search" type="text" name="keyword" placeholder="旅先を入力">
                    <button class="postSearch" type="submit" id="searchButton" disabled>検索</i></button>
                </form>
                    <a href="/"><i class="fa-solid fa-house"></i>ホーム</a><br>
                    <a href="/posts/create"><i class="fa-solid fa-square-plus"></i>投稿</a><br>
                    <a href="/posts/likes"><i class="fa-solid fa-heart"></i>いいね</a><br>
                    <a href="/books/index"><i class="fa-solid fa-plane"></i>旅行計画</a><br>
                    <a href="/user"><i class="fa-solid fa-user"></i>マイページ</a><br>
                    <form method="POST" action="{{ route('logout') }}" class="logout">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class='logout'>
                                <i class="fa-solid fa-right-from-bracket"></i>
                                {{ __('ログアウト') }}
                            </x-dropdown-link>
                        </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="{{ asset('js/delete_confirm.js') }}"></script>
        <script src="{{ asset('js/search_page.js') }}"></script>
        <script src="{{ asset('js/like.js') }}"></script>
        <script src="{{ asset('js/show_comment.js') }}"></script>
        <script src="{{ asset('js/reply_link.js') }}"></script>
        <script src="{{ asset('js/external_addComment.js') }}"></script>
        <script src="{{ asset('js/modal_addComment.js') }}"></script>
        <script src="{{ asset('js/avoid_reply.js') }}"></script>
       </div>  
    </body>
</html>
