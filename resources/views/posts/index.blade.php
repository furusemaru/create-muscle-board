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
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='post'>
                        <p>{{ $post->user->name }}</p>
                        <p>{{ $post->updated_at }}</p>
                        <h2 class='title'>
                            <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h2>
                        <p class='body'>{{ $post->body }}</p>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
            @auth
                <p>{{ Auth::user()->name }}</p>
            @endauth
        </body>
    </x-app-layout>
</html>