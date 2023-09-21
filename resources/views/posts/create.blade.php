<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>筋トレ掲示板</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <x-app-layout>
        <x-slot name="header">
            新規投稿
        </x-slot>
        <body>
            <div class='flex flex-col items-center mt-6'>
                <form class='w-3/4' action="/posts" enctype='multipart/form-data' method="POST">
                    @csrf
                    <div class='title'>
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">タイトル</label>
                        <div class="w-1/3 py-1 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <input type="text" name="post[title]" id="title" placeholder="" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required>
                        </div>
                    </div>
                    <div class="body">
                        <label for="body" class="block text-sm font-medium leading-6 text-gray-900">内容</label>
                        <div class="w-1/3 py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <textarea name="post[body]" id='body' placeholder="" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required></textarea>
                        </div>
                    </div>
                    <div class="image mb-6">
                        <label for="image" class="block text-sm font-medium leading-6 text-gray-900">画像</label>
                        <input type="file" name="image" id='image'> 
                    </div>
                    <div class='genre mb-6'>
                        <label class="block text-sm font-medium leading-6 text-gray-900">ジャンル</label>
                        @foreach($categories as $category)
                            <label class='mr-3'>
                                <input type="checkbox" value="{{ $category->id }}" name="categories_array[]">
                                    {{ $category->category }}
                                </input>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        投稿
                    </button>
                </form>
                <div class="footer w-3/4 flex justify-center mt-36">
                    <a href="/"><button class="bg-green-600 hover:bg-green-500 text-white rounded px-4 py-2">戻る</button></a>
                </div>
                    
            {{--
            <form action="/posts" enctype='multipart/form-data' method="POST">
                @csrf
                <div class="title">
                    <h2>タイトル</h2>
                    <input type="text" name="post[title]" placeholder="タイトル" value="{{ old('post.title') }}"/>
                    <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                </div>
                <div class="body">
                    <h2>内容</h2>
                    <textarea name="post[body]" placeholder="今日も1日お疲れさまでした。">{{ old('post.body') }}</textarea>
                    <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                </div>
                <div class="image">
                    <h2>画像</h2>
                    <input type="file" name="image"> 
                </div>
                <div>
                    <h2>ジャンル</h2>
                    @foreach($categories as $category)
                        <label>
                            <input type="checkbox" value="{{ $category->id }}" name="categories_array[]">
                                {{ $category->category }}
                            </input>
                        </label>
                    @endforeach
                </div>
                <input type="submit" value="投稿"/>
            </form>
            <div class="footer">
                <a href="/">戻る</a>
            </div>
            --}}
        </body>
    </x-app-layout>
</html>