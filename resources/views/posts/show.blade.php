<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
        <x-slot name="header">
            投稿詳細
        </x-slot>
        <body>
            <h2>タイトル</h2>
            <h1 class="title">
                {{ $post->title }}
            </h1>
            <div class="content">
                <div class="content__post">
                    <h3>本文</h3>
                    <p>{{ $post->body }}</p>    
                </div>
            </div>
            <div class="image">
                <h3>
                    画像
                </h3>
                <p>{{ $post->image_file_name }}</p>
            </div>
            <div class="genre">
                <h3>ジャンル</h3>
                <p>
                    @foreach($post->categories as $category)
                        {{ $category->category }}
                    @endforeach
                </p>
            </div>
            <div>
                @if($post->is_liked_by_auth_user())
                    <a href="/posts/{{ $post->id }}/unlike" class="btn btn-success btn-sm">いいね<span class="badge">{{ $post->post_likes->count() }}</span></a>
                @else
                    <a href="/posts/{{ $post->id }}/like" class="btn btn-secondary btn-sm">いいね<span class="badge">{{ $post->post_likes->count() }}</span></a>
                @endif
            </div>
            @if(Auth::id() == $post->user_id)
                <div class="edit"><a href="/posts/{{ $post->id }}/edit">編集</a></div>
            @endif
            
            <form action="{{route('comment.store')}}" method="POST">
                @csrf
                <input type="hidden" name='post_id' value="{{$post->id}}">
                <div class="body">
                    <h2>コメント</h2>
                    <textarea name="body" placeholder="コメント">{{ old('body') }}</textarea>
                    <p class="body__error" style="color:red">{{ $errors->first('body') }}</p>
                </div>
                <input type="submit" value="送信"/>
            </form>
            
            <div class="footer">
                <a href="/">戻る</a>
            </div>
        </body>
    </x-app-layout>
</html>