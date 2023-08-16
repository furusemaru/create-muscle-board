<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>筋肉掲示板</title>
    </head>
    <x-app-layout>
        <x-slot name="header">
                    投稿編集
        </x-slot>
        <body>
            <div class="content">
                <form action="/posts/{{ $post->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class='content__title'>
                        <h2>タイトル</h2>
                        <input type='text' name='post[title]' value="{{ $post->title }}">
                    </div>
                    <div class='content__body'>
                        <h2>本文</h2>
                        <input type='text' name='post[body]' value="{{ $post->body }}">
                    </div>
                    <div class="content__image">
                        <h2>画像</h2>
                        <input type='text' name='post[image_file_name]' value="{{ $post->image_file_name }}">
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
                    <input type="submit" value="保存">
                </form>
            </div>
        </body>
    </x-app-layout>
</html>
