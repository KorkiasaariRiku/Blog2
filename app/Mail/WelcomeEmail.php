<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use SerializesModels;

    public function build()
    {
        return $this->subject('Welcome to Laravel Blog')
                    ->view('emails.welcome_email');
    }
}
