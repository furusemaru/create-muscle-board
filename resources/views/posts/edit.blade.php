<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>筋肉掲示板</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @vite('resources/css/app.css')
    </head>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('投稿編集') }}
            </h2>
        </x-slot>
        <body>
            <div class='flex flex-col items-center mt-6'>
                <form class='w-3/4' action="/posts/{{ $post->id }}" enctype='multipart/form-data' method="POST">
                    @csrf
                    @method('PUT')
                    <div class='title'>
                        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">タイトル<span class='text-red-600'>*</span></label>
                        <div class="w-1/3 py-1 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <input type="text" name="post[title]" id="title" value="{{ $post->title }}" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required>
                        </div>
                        <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
                    </div>
                    <div class="body">
                        <label for="body" class="block text-sm font-medium leading-6 text-gray-900">内容<span class='text-red-600'>*</span></label>
                        <div class="w-1/3 py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                            <textarea name="post[body]" id='body' class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" required>{{ $post->body }}</textarea>
                        </div>
                        <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
                    </div>
                    <div class="image mb-6">
                        <label for="image" class="block text-sm font-medium leading-6 text-gray-900">画像</label>
                        <input type="file" name="image" id='image' value='asset{{($post->image)}}'> 
                        @if($post->image != null)
                        <label for="body" class="block text-sm font-medium leading-6 text-gray-700 mt-3">登録していた画像<span class='text-gray-500'>（変更しない場合、再度選択する必要はありません）</span></label>
                        <img class="h-48 w-96 object-cover flex-none bg-gray-50" src="{{ $post->image }}" alt="画像が読み込めません。" {{--src="{{asset($post->image)}}" alt="" --}}>
                        @endif
                    </div>
                    <div class='genre mb-6'>
                        <label class="block text-sm font-medium leading-6 text-gray-900">ジャンル</label>
                        @foreach($categories as $category)
                            <label class='mr-3'>
                                <input type="checkbox" value="{{ $category->id }}" name="categories_array[]" @foreach($post->categories as $oldcategory) @if($oldcategory->id == $category->id) checked @endif @endforeach>
                                    {{ $category->category }}
                                </input>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        変更
                    </button>
                </form>
            </div>
        </body>
    </x-app-layout>
</html>
