<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->as('assignment')
            ->withTimestamps();
    }

    public function isSuperAdministrator()
    {
        return $this->roles()->where('name', 'Super Administrator')->exists();
    }

    public function isAdministrator()
    {
        return $this->roles()->where('name', 'Administrator')->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('name', 'User')->exists();
    }

    public function isGuest()
    {
        return $this->roles()->where('name', 'Guest')->exists();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
