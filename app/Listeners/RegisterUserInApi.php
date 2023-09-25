<?php

namespace App\Listeners;

use App\Events\UserCreating;
use App\Services\UserApiClient;
use Illuminate\Support\Facades\Log;

class RegisterUserInApi
{
    protected $userApiClient;

    public function __construct(UserApiClient $userApiClient)
    {
        $this->userApiClient = $userApiClient;
    }

    /**
     * Handle the event.
     *
     * This method is called when the UserCreating event is fired. It handles the process
     * of creating a new user in the external API via the UserApiClient service.
     *
     * @param  UserCreating  $event
     * @return void
     */
    public function handle(UserCreating $event): void
    {
        // Make an API call to create the user
        $response = $this->userApiClient->createUser($event->user);
        
        // Check if the API call was successful
        if ($response->successful()) {
            // Extract the 'id' from the API response
            $apiId = $response->json('id');
    
            // Log that the API ID was retrieved successfully
            Log::info('API ID retrieved: ' . $apiId);
    
            // Update the 'api_id' property in the user data
            $event->user->api_id = $apiId;
        } else {
            // Handle API error here and log the response body
            Log::error('Failed to create user via API: ' . $response->body());
        }
    }
}
