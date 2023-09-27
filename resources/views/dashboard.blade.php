<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ダッシュボード') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-xl font-bold">
                    {{ __("ログインに成功しました！") }}
                </div>
            </div>
        </div>
        @if($number !== 0)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class='p-6 text-gray-900 text-base font-bold'>下記の投稿は不快に思う人が多いため、編集か削除をお願いいたします。</p>
                @foreach($posts as $post)
                <a href="/posts/{{ $post->id }}"><p class='px-6 mb-3 text-blue-600 dark:text-blue-500 hover:underline'>{{ $post->title }}</p></a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
