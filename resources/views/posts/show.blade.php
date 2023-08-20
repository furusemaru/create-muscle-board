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
                <img src="{{asset($post->image)}}" alt="">
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
            <h3>コメント</h3>
            <div class="comments">
                @foreach ($post->comments as $comment)
                    <div>{{ $comment->user->name }}{{ $comment->created_at }}</div>
                    <div class='comment'>
                        {{ $comment->body }}
                    </div>
                    @if(Auth::id() == $comment->user->id)
                        <form action="/comments/{{ $comment->id }}" id="form_{{ $comment->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deleteComment({{ $comment->id }})">削除</button> 
                        </form>
                    @endif
                @endforeach
            </div>
            @auth
                <form action="{{route('comment.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name='post_id' value="{{$post->id}}">
                    <div class="body">
                        <h2>新規コメント</h2>
                        <textarea name="comment[body]" placeholder="コメント">{{ old('comment.body') }}</textarea>
                        <p class="body__error" style="color:red">{{ $errors->first('comment.body') }}</p>
                    </div>
                    <input type="submit" value="送信"/>
                </form>
            @endauth
            <div class="footer">
                <a href="/">戻る</a>
            </div>
        </body>
        <script>
            function deleteComment(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </x-app-layout>
</html>