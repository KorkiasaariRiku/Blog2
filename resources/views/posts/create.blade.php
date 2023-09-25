<x-app-layout>
    <!-- Header section -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Post') }}
        </h2>
    </x-slot>

    <!-- Body section -->
    <div class="container mx-auto p-6">
        <form action="/posts" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-600 text-sm font-medium">Title</label>
                <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
            </div>
            <div class="mb-4">
                <label for="body" class="block text-gray-600 text-sm font-medium">Body</label>
                <textarea name="body" id="body" rows="4" class="form-input rounded-md shadow-sm mt-1 block w-full" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">Create Post</button>
            </div>
        </form>
    </div>
</x-app-layout>
