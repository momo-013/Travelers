 <!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">投稿</x-slot>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Travelers</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="antialised">
        <div>
            <a href="/">キャンセル</a>
        </div>
        <form action="/posts" method="POST">
            @csrf
            <div class="place">
                <h2>Place</h2>
                <input type="text" name=post[place] placeholder="スポットを入力" value= {{ old('post.place') }}></input>
                <p class="place_error" style="color:red">{{ $errors -> first('post.place') }}</p>
            </div>
            <!--Place＝スポットアイコン-->
            <div class="star">
                <h2>Star</h2>
                <input type="number" name=post[star] min="1" max="5"/> 
            </div>
            
            <div class="title">
                <input type="text" name=post[title] placeholder="タイトルを入力(最大20字)" value={{ old('post.title') }}></input>
                <p class="title_error" style="color:red">{{ $errors -> first('post.title') }}</p>
            </div>
            
            <div class="body">
                <textarea name="post[body]" placeholder="本文：どんな体験をしたかなど(最大200字)" value={{ old('post.body') }}></textarea>
                <p class="body_error" style="color:red">{{ $errors -> first('post.body') }}</p>
            </div>
            <input type="submit" value="投稿">
        </form>
        
            
        
    </body>
</html>

</x-app-layout>