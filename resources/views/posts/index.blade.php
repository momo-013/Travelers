<x-app-layout>
    <x-slot name="header">ホーム</x-slot>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Travelers</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialised">
        <h1>すべて</h1>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
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
                    <h2 class='place'>{{ $post->place }}</h2>
                    <p class='star'>{{ $post->star }}</p>
                    <h3 class='title'>{{ $post->title}}</h3>
                    <p class='body'>{{ $post->body}}</p>
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