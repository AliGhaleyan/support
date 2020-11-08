<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 *
 * @property $first_name
 * @property $last_name
 * @property $full_name
 * @property $email
 * @property $mobile
 * @property $code
 * @property $type
 * @property $busy
 * @property $password
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "mobile",
        "code",
        "type",
        "busy",
        "password",
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
