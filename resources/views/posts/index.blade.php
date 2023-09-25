<x-app-layout>
    <!-- Header section -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Latest Posts') }}
            <a href="{{ route('posts.create') }}" class="text-white-500 hover:underline">Create New Post</a>
        </h2>
    </x-slot>

    <!-- Body section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($postsPaginator as $post)
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">{{ $post['title'] }}</h3>
                <p class="text-gray-600">{{ Str::limit($post['body'], 100) }}</p>
                <p class="text-gray-500 mt-2">Original Poster: {{ $post['user_id'] }}</p>
                <a href="{{ route('posts.show', ['postId' => $post['id']]) }}">Read more...</a>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $postsPaginator->links() }} <!-- Pagination links -->
    </div>
</x-app-layout>
