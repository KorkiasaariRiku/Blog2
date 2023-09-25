<?php

namespace App\Http\Controllers;

use App\Services\UserApiClient;

class SinglePostController extends Controller
{
    protected $userApiClient;

    public function __construct(UserApiClient $userApiClient)
    {
        $this->userApiClient = $userApiClient;
    }

    public function show($postId)
    {
        // Fetch the post content using the API
        $response = $this->userApiClient->getSinglePost($postId);

        if ($response->successful()) {
            // Retrieve the post data from the API response
            $post = $response->json();

            // Fetch comments related to the post
            $commentsResponse = $this->userApiClient->getPostComments($postId);

            if ($commentsResponse->successful()) {
                // Retrieve comments data from the comments API response
                $comments = $commentsResponse->json();

                // Fetch user details for each comment's author
                foreach ($comments as &$comment) {
                    // Assuming $comment['name'] contains the commenter's name
                    $comment['commenter_name'] = $comment['name'];
                }

            } else {
                // Handle error when fetching comments
                $comments = [];
                // You can add error handling code here
            }

            // Return the 'post' view with the post and comments data
            return view('posts.post', compact('post', 'comments'));
        }

        // Handle API error by redirecting back with an error message
        return back()->withErrors(['api_error' => 'Failed to retrieve post from the API']);
    }
}
