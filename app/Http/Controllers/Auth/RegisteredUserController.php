<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\UserRegistered;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{ 
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        // Create a new user in the local database with the modified user data
        $user = UserService::createLocalUser($request->all(), $request->password);

        // Fire the UserRegistered event
        event(new UserRegistered($user));

        // Log in the user
        Auth::login($user);

        // Redirect to the dashboard
        return redirect('/');

    }     
}
