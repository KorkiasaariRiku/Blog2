<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserApiClient;

class CommentController extends Controller
{
    protected $userApiClient;

    public function __construct(UserApiClient $userApiClient)
    {
        $this->userApiClient = $userApiClient;
    }

    /**
     * Store a new comment for a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $postId)
    {
        // Validate the request data
        $request->validate([
            'body' => 'required|string',
        ]);

        // Prepare the comment data
        $commentData = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'body' => $request->input('body'),
        ];

        // Send the comment data to the API
        $response = $this->userApiClient->createComment($postId, $commentData);

        if ($response->successful()) {
            // Comment created successfully
            // You may handle a successful response as needed
            return redirect()->route('posts.show', $postId)->with('success', 'Comment added successfully');
        } else {
            // Handle API error by redirecting back with an error message
            return back()->withErrors(['api_error' => 'Failed to add comment to the API']);
        }
    }
}
