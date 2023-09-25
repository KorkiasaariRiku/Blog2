<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

/**
 * Class SendWelcomeEmail
 * 
 * This listener class is responsible for sending a welcome email to users
 * upon their registration to the application.
 * 
 * @package App\Listeners
 */
class SendWelcomeEmail
{
    /**
     * Handle the UserRegistered event.
     *
     * This method gets triggered when the UserRegistered event is dispatched.
     * It queues the email sending task to ensure that the user does not experience
     * a delay during their registration process.
     * 
     * @param  UserRegistered  $event  The event object containing user details.
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        // Retrieve the registered user from the event.
        $user = $event->user;

        // Queue the process of sending the welcome email.
        Queue::push(function () use ($user) {
            try {
                // Attempt to send the welcome email to the registered user.
                $result = Mail::to($user)->send(new WelcomeEmail());

                // Log the result of the email sending attempt.
                Log::info('Welcome email sending attempt: ' . ($result ? 'Success' : 'Failed'));
            } catch (\Exception $e) {
                // If there's an exception (e.g., email service not responding), log the error message.
                Log::error('Failed to send welcome email: ' . $e->getMessage());
            }
        });
    }
}
