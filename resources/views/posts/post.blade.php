<x-app-layout>
    <!-- Header section -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Single Post') }} <!-- Display the title "Single Post" in the header -->
        </h2>
    </x-slot>

    <!-- Body section -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-6">
            <h3 class="text-2xl font-semibold">{{ $post['title'] }}</h3>
            <!-- Display the post title with a larger font size -->
            <p class="text-gray-600">{{ $post['body'] }}</p>
            <!-- Display the post body with gray text color -->
        </div>
        
        <div class="mb-4">
            <p class="text-gray-500">Original Poster: {{ $post['user_id'] }}</p>
            <!-- Display the original poster's user ID -->
        </div>

        <!-- Display comments if available -->
        @if (!empty($comments))
            <div class="mt-6">
                <h4 class="text-xl font-semibold mb-2">Comments:</h4>
                <!-- Display the "Comments" heading with a larger font size -->
                @foreach ($comments as $comment)
                    <div class="bg-gray-100 p-3 rounded-lg mb-4">
                        <!-- Display each comment in a gray box with padding -->
                        <p class="text-gray-500">{{ $comment['body'] }}</p>
                        <!-- Display the comment body with gray text color -->
                        <div class="mt-2">
                            <p class="text-gray-500">Original Commenter: {{ $comment['commenter_name'] }}</p>
                            <!-- Display the original commenter's name -->
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-lg mt-6">No comments available.</p>
            <!-- Display a message when no comments are available -->
        @endif

        <!-- Add a New Comment Section -->
        <div class="mt-6">
            <h4 class="text-xl font-semibold mb-2">Add a Comment:</h4>
            <!-- Display the "Add a Comment" heading with a larger font size -->
            <form method="POST" action="{{ route('comments.store', $post['id']) }}">
                @csrf
        
                <div class="mb-4">
                    <label for="body" class="block text-gray-500">Your Comment:</label>
                    <!-- Display a label for the comment input -->
                    <textarea name="body" id="body" rows="4" class="form-input rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    <!-- Display a text area for entering the comment -->
                    @error('body')
                        <p class="text-red-500">{{ $message }}</p>
                        <!-- Display an error message if the comment input has errors -->
                    @enderror
                </div>
                <div class="text-right">
                    <button type="submit" class="px-4 py-2 bg-gray-600 text-black rounded-md hover:bg-gray-700">Submit</button>
                    <!-- Display a "Submit" button for submitting the comment -->
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
