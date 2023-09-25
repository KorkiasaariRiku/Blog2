<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\UserApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $userApiClient;

    public function __construct(UserApiClient $userApiClient)
    {
        $this->userApiClient = $userApiClient;
    }

    public function index()
    {
        // Set the number of posts to display per page
        $perPage = 6;

        // Get the current page from the request query parameter 'page' or default to 1
        $currentPage = request()->query('page', 1);

        // Make a request to the UserApiClient to get all posts
        $response = $this->userApiClient->getAllPosts();

        if ($response->successful()) {
            // Retrieve posts data from the API response
            $posts = $response->json();

            foreach ($posts as &$post) {
                // Fetch user details for each post's user_id
                $userResponse = $this->userApiClient->getUserDetails($post['user_id']);
                if ($userResponse->successful()) {
                    // Retrieve user data from the user API response
                    $userData = $userResponse->json();
                    // Assuming the user's name is in 'name' key
                    $post['author_name'] = $userData['name'];
                } else {
                    // Handle error by setting author name to 'Unknown'
                    $post['author_name'] = 'Unknown';
                }
            }

            // Manually paginate the posts array based on current page and perPage
            $postsSlice = array_slice($posts, ($currentPage - 1) * $perPage, $perPage);
            $totalPosts = count($posts);

            // Create a LengthAwarePaginator instance based on the paginated data
            $postsPaginator = new LengthAwarePaginator(
                $postsSlice,
                $totalPosts,
                $perPage,
                $currentPage,
                ['path' => route('posts.index')] // Adjust the route name as needed
            );

            // Return the 'posts.index' view with the paginated posts
            return view('posts.index', compact('postsPaginator'));
        }

        // Handle API error by redirecting back with an error message
        return back()->withErrors(['api_error' => 'Failed to retrieve posts from the API']);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request, UserApiClient $userApiClient)
    {
        // Validate the request data, including title and body
        // Add your validation logic here

        // Retrieve the authenticated user's api_id
        $apiId = auth()->user()->api_id;

        // Check if the user has an api_id
        if ($apiId) {
            // Send the POST request to create the post using UserApiClient
            $response = $userApiClient->createPost($apiId, $request->input('title'), $request->input('body'));

            // Log the request data for debugging purposes
            Log::info('Post creation request data:', [
                'user_id' => $apiId,
                'title' => $request->input('title'),
                'body' => $request->input('body'),
            ]);

            // Log the API response for debugging purposes
            Log::info('Post creation API response:', [
                'status' => $response->status(),
                'response_body' => $response->json(),
            ]);

            // Handle the response, check for errors, and process accordingly
            if ($response->successful()) {
                // Post created successfully
                $responseData = $response->json(); // Get the response data
                $postId = $responseData['id']; // Extract the new post ID

                // Log success message
                Log::info('Post created successfully. Post ID: ' . $postId);

                // Redirect to the appropriate page, e.g., the list of posts
                return redirect()->route('posts.index')->with('success', 'Post created successfully');
            } else {
                // Handle the error
                $errorData = $response->json(); // Get error response data
                // Log error message
                Log::error('Error creating post: ' . json_encode($errorData));

                // Handle error response and return an error message or view
                return back()->withErrors(['api_error' => 'Failed to create the post']);
            }
        } else {
            // Handle the case where the user does not have an api_id
            Log::error('User does not have an API ID');
            return back()->withErrors(['api_error' => 'User does not have an API ID']);
        }
    }
}
