<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>筋トレ掲示板</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <x-app-layout>
        <x-slot name="header">
            投稿詳細
        </x-slot>
        <body>
            <div class='flex flex-col items-center mt-6'>
                <div class=" mb-6 w-3/4">
                    <div class='flex items-end'>
                        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{$post->title}}</h2>
                        <p class="text-gray-700 dark:text-gray-400 mx-6">
                        @foreach($post->categories as $category)
                            <span>#{{$category->category}}</span>
                        @endforeach
                            <span>
                            @if($post->is_liked_by_auth_user())
                                <a href="/posts/{{ $post->id }}/unlike" class="btn btn-success btn-sm">いいね<span class="badge">{{ $post->post_likes->count() }}</span></a>
                            @else
                                <a href="/posts/{{ $post->id }}/like" class="btn btn-secondary btn-sm">いいね<span class="badge">{{ $post->post_likes->count() }}</span></a>
                            @endif
                            </span>
                            <span>コメント{{ $post->comments->count() }}</span>
                        </p>
                    </div>
                    <div class='flex justify-between my-3'>
                        <div class='flex items-center'><p class="text-lg text-gray-700 dark:text-gray-400">{{ $post->body }}</p></div>
                        @if(Auth::id() == $post->user_id)
                        <div class='flex justify-start items-center'>
                            <div class="edit mr-6">
                                <a href="/posts/{{ $post->id }}/edit">
                                    <button class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">編集</button>
                                </a>
                            </div>
                            <div class='delete'>
                                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-red-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800" type="button" onclick="deletePost({{ $post->id }})">削除</button> 
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if($post->image != null)
                    <img class="h-48 w-96 object-cover flex-none bg-gray-50" src="{{asset($post->image)}}" alt="">
                    @endif
                </div>
                @auth
                <form class="mb-6 w-3/4" action="{{ route('comment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name='post_id' value="{{$post->id}}">
                    <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <textarea name="comment[body]" id="comment" rows="6" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" placeholder="コメントをするときはこちら" required></textarea>
                    </div>
                    <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        送信
                    </button>
                </form>
                @endauth
                @foreach($post->comments as $comment)
                <article class="py-6 text-base dark:bg-gray-900 w-3/4">
                    <footer class="flex justify-start items-center mb-2">
                        <div class="flex items-center">
                            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">{{ $comment->user->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{$comment->created_at->diffForHumans()}}</p>
                        </div>
                    </footer>
                    <p class="text-gray-500 dark:text-gray-400">{{ $comment->body }}</p>
                </article>
                @endforeach
                <div class="footer w-3/4 flex justify-center">
                    <a href="/"><button class="bg-green-600 hover:bg-green-500 text-white rounded px-4 py-2">戻る</button></a>
                </div>
            </div>
{{--
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
--}}
        </body>
        <script>
            function deleteComment(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
                }
            }
            function deletePost(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
    </x-app-layout>
</html>