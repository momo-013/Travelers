<x-app-layout>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Travelers</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialised">
        <h1>{{ $user->name }}</h1>
        <!--フォロー機能-->
        <div>
            @if($user->isfollow())
                <form id="unfollow-form" action="/unfollow/{{ $user->id }}" method="POST">
                    @csrf
                    <button id="unfollow-button" type="submit">フォロー解除</button>
                </form>
            @else
                <form id="follow-form" action="/follow/{{ $user->id }}" method="POST">
                    @csrf
                    <button id="follow-button" type="submit">フォローする</button>
                </form>
            @endif
        </div>
            
        
        <h3>{{ $posts->count() }}投稿　　{{ $user->followers->count() }}フォロワー　　{{ $user->followings->count() }}フォロー</h3>
        
        <div>
            @if($posts->isEmpty())
            <p>まだ投稿がありません</p>
            @endif
        </div>
        <div class='posts'>
            @foreach($posts as $post)
                <div class='post'>
                    <h3>{{ $user->name }}</h3>
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
                </div>
        @endforeach
        </div>
            
        
        
        
    </body>
</html>

</x-app-layout>