<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Events\UserRegistered;


class UserService
{
    /**
     * Create a new local user using provided user data and password.
     *
     * @param  array  $userData
     * @param  string  $password
     * @return \App\Models\User
     */
    public static function createLocalUser(array $userData, string $password)
    {
        // Create a new user record in the local database
        $user = new User;
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }
}
