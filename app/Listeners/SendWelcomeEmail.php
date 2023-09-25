<?php
namespace App\Listeners; 

use App\Events\UserRegistered;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class SendWelcomeEmail
{
    public function handle(UserRegistered $event)
    {
        // Get the user from the event
        $user = $event->user;

        // Dispatch the email sending to a queue
        Queue::push(function () use ($user) {
            try {
                $result = Mail::to($user)->send(new WelcomeEmail());
                Log::info('Welcome email sending attempt: ' . ($result ? 'Success' : 'Failed'));
            } catch (\Exception $e) {
                // Log any exceptions that occur during email sending
                Log::error('Failed to send welcome email: ' . $e->getMessage());
            }
        });
    }
}
