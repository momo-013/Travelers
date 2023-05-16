 <!DOCTYPE html>
<x-app-layout>
    <x-slot name="header"></x-slot>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Travelers</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="">
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <a href="{{ route('users.show', $post->user_id)}}">{{ $post->user->name }}</a>
                    
                    <p class='edit'>
                        @if(Auth()->user()->id== $post->user_id)
                        <a href="/posts/{{ $post->id }}/edit">編集</a>
                        @endif
                    </p>
                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id}}" method="post">
                        @csrf
                        @method('DELETE')
                        @if(Auth()->user()->id== $post->user_id)
                        <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                        @endif
                    </form>
                    <!--画像-->
                    @if($post->images())
                        @foreach($post->images as $image)
                    <div>
                        <img src={{ $image->image_url }} alt="画像が読み込めません。"/>
                    </div>
                        @endforeach
                    @endif
                    <p class="prefecture">{{ $post->prefecture->name }}</p>
                    <h2 class='place'>{{ $post->place }}</h2>
                    <p class='star'>{{ $post->star }}</p>
                    <h3 class='title'>{{ $post->title}}</h3>
                    <p class='body'>{{ $post->body}}</p>
                    <!--コメント-->
                    <a href="/posts/{{ $post->id }}/reply">
                        
                        <span class="material-icons">comment</span>
                    </a>
                    <!--いいね機能-->
                    <span>
                        <img src="{{ asset('https://biz.addisteria.com/wp-content/uploads/2021/02/nicebutton.png')}}" width="20px">
                        @if($post->islike())
                            <a href="{{ route('unlike',$post) }}" class="btn btn-success btn-sm">
                                <span class="badge1">
                                    いいね取り消し{{ $post->likes->count() }}
                                </span>
                            </a>
                        @else
                            <a href="{{ route('like',$post) }}" class="btn btn-secondary btn-sm">
                                <span class="badge2">
                                    いいね{{ $post->likes->count() }}
                                </span>
                            </a>
                        @endif    
                    </span>
                    <!--コメント表示-->
                    <div class='reply'>
                        @foreach($post->replies as $reply)
                        <p>{{ $reply->user->name }}:{{ $reply->body }}</p>
                        @endforeach
                    </div>
                    <!--コメント追加-->
                    <form action="{{ route('reply.store')}}" method="POST">
                        @csrf
                        <input type="text" name=reply[body] placeholder="コメントを追加">
                        <button type="submit"><input type="hidden" value="{{ $post->id }}" name="reply[post_id]"/>
                        送信</button>
                    </form>
                </div>
             @endforeach   
        </div>
        <script>
            function deletePost(id){
                'use strict'
                
                if (confirm('削除すると復元できません。')){
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>  
    </body>
</html>

</x-app-layout>