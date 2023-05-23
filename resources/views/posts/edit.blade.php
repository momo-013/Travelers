 <!DOCTYPE html>
    <!--<x-slot name="header">編集</x-slot>-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/style2.css" >

    </head>
    
    <body class="antialised">
        <div class="app">
         <header class='header'>
             <h2>Travelers</h2>
            <a href="/" class="cancel">キャンセル</a>
         </header>
         
        <div class="create">
        <form action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="prefecture">
                <i class="fa-solid fa-location-dot"></i>
                <select name="post[prefecture_id]">
                    <option value="" selected>{{ $post->prefecture->name }}</option>
                    @foreach($prefectures as $prefecture)
                        <option value="{{ $prefecture->id }}">{{ $prefecture->name}}</option>
                    @endforeach    
                </select>
                 <p class="prefecture_id_error" style="color:red">{{ $errors -> first('post.prefecture_id') }}</p>
            </div>
            
            <div class="star">
                <i class="fa-solid fa-star"></i>
                <input type="number" name=post[star] min="1" max="5" value="{{ $post->star }}"/> 
                <p class="star_error" style="color:red">{{ $errors -> first('post.star') }}</p>
            </div>
            
            <div class="place">
                <input type="text" name=post[place] placeholder="スポットを入力" value="{{ $post->place }}"></input>
                <p class="place_error" style="color:red">{{ $errors -> first('post.place') }}</p>
            </div>
            
            <!--<div class="title">-->
            <!--    <input type="text" name=post[title] placeholder="タイトルを入力(最大20字)" value="{{ $post->title }}">-->
            <!--    <p class="title_error" style="color:red">{{ $errors -> first('post.title') }}</p>-->
            <!--</div>-->
            
            <div class="body">
                <textarea name="post[body]" placeholder="本文：どんな体験をしたかなど(最大200字)" >{{ $post->body }}</textarea>
                <p class="body_error" style="color:red">{{ $errors -> first('post.body') }}</p>
            </div>
            <div class="submit">
            <input type="submit" value="保存">
            </div>
        </form>
        </div>
        </div>
            
        
    </body>
</html>