<?php 
namespace App\Events;

use App\Models\User;

class UserCreating
{
    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * Event for modifying user data before creation.
     *
     * @param User $user The user model instance that is being created or modified.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }   
}
