<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // buyer | seller | admin
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | Complaint Relationships (ikut ERD)
    |--------------------------------------------------------------------------
    */

    // Buyer → complaint dia sendiri
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    // Seller → complaint yang berkaitan dengan dia
    public function handledComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'seller_id');
    }

    // Admin → complaint yang dia handle
    public function adminComplaints(): HasMany
    {
        return $this->hasMany(Complaint::class, 'handled_by');
    }
}

