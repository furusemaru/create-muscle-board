<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
    </head>
    <x-app-layout>
        <x-slot name="header">
                    新規投稿
        </x-slot>
        <body>
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
        </body>
    </x-app-layout>
</html>