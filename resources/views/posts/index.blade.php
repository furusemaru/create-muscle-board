<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
        <x-slot name="header">
                投稿一覧
        </x-slot>
        <body>
            <div>
                <form action="{{ route('index') }}" method="GET">
                    <input type="text" name="search" value="@if (isset($search)) {{ $search }} @endif">
                    <input type="submit" value="検索">
                </form>
            </div>
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='post'>
                        <p>{{ $post->user->name }}</p>
                        <p>{{ $post->updated_at }}</p>
                        <h2 class='title'>
                            <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h2>
                        <p class='body'>{{ $post->body }}</p>
                        <h5>
                            @foreach($post->categories as $category)
                                {{ $category->category }}
                            @endforeach
                        </h5>
                        <p>いいね{{$post->post_likes->count()}}</p>
                        @if(Auth::id() == $post->user_id)
                            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deletePost({{ $post->id }})">削除</button> 
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
            @auth
                <a href='/posts/create'>新規投稿</a>
            @endauth
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
            @auth
                <p>{{ Auth::user()->name }}</p>
            @else
                <p>ゲスト</p>
            @endauth
        </body>
        <script>
            function deletePost(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </x-app-layout>
</html>