<?php

namespace App\Models;

// Import necessary traits and classes
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Use various traits for added functionality
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable, allowing them to be set in a mass assignment operation.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',         
        'email',        
        'password',     
        'api_id'        
    ];

    /**
     * The attributes that should be hidden when serialized, typically sensitive or security-related fields.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',         // Hide password field
        'remember_token',   // Hide remember token
    ];

    /**
     * The attributes that should be cast to native types, such as dates or booleans.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Cast email_verified_at to datetime
        'password' => 'hashed',             // Cast password to a hashed value
    ];

    /**
     * Define custom event listeners for model events. In this case, there's a 'creating' event that triggers 'UserCreating' event.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => \App\Events\UserCreating::class, // Dispatch 'UserCreating' event when creating a new user
    ];
}
