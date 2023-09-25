<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Http\Client\PendingRequest;

class UserApiClient
{
    /**
     * Create an HTTP client with authorization headers.
     *
     * @return \Illuminate\Http\Client\PendingRequest
     */
    public function client(): PendingRequest
    {
        // Create an HTTP client with the necessary authorization headers
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . config('api.gorest_api_key'),
        ]);
    }

    /**
     * Create a new user via the API.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Client\Response
     */
    public function createUser(User $user)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Define the user data for the request
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'gender' => 'female', // Hardcoded for testing purposes
            'status' => 'active', // Hardcoded for testing purposes
        ];

        // Make a POST request to the API to create a new user
        return $client->post('https://gorest.co.in/public/v2/users', $userData);
    }

    /**
     * Get user details via the API.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Client\Response
     */
    public function getUserDetails($userId)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Make a GET request to the API to retrieve user details
        return $client->get("https://gorest.co.in/public/v2/users/{$userId}");
    }

    /**
     * Get all posts via the API.
     *
     * @param  int  $page
     * @return \Illuminate\Http\Client\Response
     */
    public function getAllPosts($page = 1)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Make a GET request to the API to retrieve all posts
        return $client->get('https://gorest.co.in/public/v2/posts', [
            'page' => $page,
        ]);
    }

    /**
     * Get a single post by ID via the API.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\Client\Response
     */
    public function getSinglePost($postId)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Make a GET request to the API to retrieve a single post by ID
        return $client->get("https://gorest.co.in/public/v2/posts/{$postId}");
    }

    /**
     * Get comments related to a specific post via the API.
     *
     * @param int $postId
     * @return \Illuminate\Http\Client\Response
     */
    public function getPostComments($postId)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Make a GET request to the API to retrieve post comments
        return $client->get("https://gorest.co.in/public/v2/posts/{$postId}/comments");
    }

    /**
     * Create a new comment via the API.
     *
     * @param int $postId
     * @param array $commentData
     * @return \Illuminate\Http\Client\Response
     */
    public function createComment($postId, $commentData)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Define the comment data in the desired structure
        $commentPayload = [
            'post_id' => $postId,
            'name' => $commentData['name'], // Assuming you have the commenter's name
            'email' => $commentData['email'], // Assuming you have the commenter's email
            'body' => $commentData['body'],
        ];

        // Make a POST request to the API to create a new comment
        return $client->post("https://gorest.co.in/public/v2/comments", $commentPayload);
    }

    /**
     * Create a new post via the API.
     *
     * @param int $userId
     * @param string $title
     * @param string $body
     * @return \Illuminate\Http\Client\Response
     */
    public function createPost($userId, $title, $body)
    {
        // Create an HTTP client instance
        $client = $this->client();

        // Define the post data in the desired structure
        $postData = [
            'user_id' => $userId, // Make sure this is correctly set as the user's ID
            'title' => $title,
            'body' => $body,
            // You can add more fields here as needed
        ];

        // Make a POST request to the API to create a new post
        return $client->post('https://gorest.co.in/public/v2/posts', $postData);
    }
}
