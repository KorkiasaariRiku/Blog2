<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class WelcomeEmail
 * 
 * This class represents a mailable object responsible for sending a welcome email
 * to the users of the Laravel Blog application.
 * 
 * @package App\Mail
 */
class WelcomeEmail extends Mailable
{
    // This trait provides the ability to serialize models when the mailable is queued.
    use SerializesModels;

    /**
     * Build the message.
     *
     * This method constructs the welcome email by setting its subject and associating it
     * with a specific view, which will be used as the email's content.
     * 
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to Laravel Blog')  // Setting the email's subject.
                    ->view('emails.welcome_email');      // Associating the email with a view.
    }
}
