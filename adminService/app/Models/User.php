<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // Correct traits for API authentication
    use HasApiTokens, HasFactory, Notifiable;

    // Proper table configuration
    protected $table = 'users'; // Explicit (though Laravel defaults to this)
    protected $primaryKey = 'id'; // Explicit (default behavior)

    // Correct fillable fields for mass assignment
    protected $fillable = [
        'name',
        'email', 
        'password',
    ];

    // Proper relationship definition
    public function orders()
    {
        return $this->hasMany(Order::class); // Correct relationship
    }
}