<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>筋トレ掲示板</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <x-app-layout>
        <x-slot name="header">
                自分の投稿
        </x-slot>
        <body>
            <div class='flex flex-col items-center'>
                <div class='title-box w-3/4 text-center my-6'>
                    <h1 class='text-6xl font-black'>筋トレ掲示板</h1>
                    <p class='text-sm font-normal mt-6'>ここは筋トレについての掲示板です。この掲示板は登録しないと閲覧しかできないクリーンな掲示板です！！</p>
                </div>
                <div class='search-box　w-3/4'>
                    <form action="{{ route('index') }}" method="GET" class='my-6'>
                        <div class='flex'>
                            <div class="mr-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ワード検索</label>
                                <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text" name="search" value="@if (isset($search)) {{ $search }} @endif" placeholder="検索ワード">
                            </div>
                            <div class="mr-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">カテゴリ</label>
                                <select name='category' class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">未選択</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if($category->id == $input_category) selected @endif>
                                        {{ $category->category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mr-6">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">表示順</label>
                                <select name='sort' class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value='new' @if($sort == 'new') selected @endif>新着</option>
                                    <option value='good' @if($sort == 'good') selected @endif>いいね</option>
                                    <option value='comment' @if($sort == 'comment') selected @endif>コメント</option>
                                </select>
                            </div>
                            <div class='mr-6 my-7'>
                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-1/4 sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">絞り込み</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class='new-post mb-6'>
                @auth
                    <a href='/posts/create'>
                        <button class="text-white bg-green-600 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">新規投稿</button>
                    </a>
                @endauth
                </div>
                <div class='post-box w-3/4'>
                    <ul>
                        @foreach($posts as $post)
                        <a class='block' href="/posts/{{ $post->id }}">
                            <li class="flex justify-between gap-x-6 py-5 border-t-2 hover:bg-blue-100">
                                <div class="flex min-w-0 gap-x-4 items-center">
                                    @if($post->image != null)
                                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ $post->image }}" alt="画像が読み込めません。"{{--@if($post->image != null) src="{{asset($post->image)}}" @else src="{{asset('/storage/post_image/画像無し.jpeg')}}" @endif alt=''--}}>
                                    @else
                                    <svg class="h-12 w-12 text-black-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" /></svg>
                                    @endif
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-gray-900">{{$post->user->name}}</p>
                                        <!--<p class="mt-1 truncate text-xs leading-5 text-gray-500">leslie.alexander@example.com</p>-->
                                        <p class='text-lg'>{{$post->title}}</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="mt-1 text-xs leading-5 text-gray-500">{{$post->created_at->diffForHumans()}}</p>
                                    <p class="text-sm leading-6 text-gray-900">
                                        @foreach($post->categories as $category)
                                        <span>#{{$category->category}}</span>
                                        @endforeach
                                    </p>
                                    <p class="text-sm leading-6 text-gray-900">
                                        @if($post->is_liked_by_auth_user())
                                        <span class='text-red-600 font-bold'>いいね</span><span>{{$post->post_likes->count()}}</span>
                                        @else
                                        <span>いいね</span><span>{{$post->post_likes->count()}}</span>
                                        @endif
                                        @if($post->is_commented_by_auth_user())
                                        <span class='text-red-600 font-bold'>コメント</span><span>{{ $post->comments->count() }}</span>
                                        @else
                                        <span>コメント{{ $post->comments->count() }}</span>
                                        @endif
                                    </p>
                                </div>    
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
                {{--<div class='post-box'>
                    @foreach ($posts as $post)
                        <div class='post mb-6'>
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
                            <p>コメント{{ $post->comments->count() }}</p>
                            @if(Auth::id() == $post->user_id)
                                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deletePost({{ $post->id }})">削除</button> 
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>--}}
                <div class='pagination w-3/4 py-6 border-t-2'>
                    {{ $posts->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
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