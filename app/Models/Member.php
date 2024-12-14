<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'members';

    protected $fillable = [
        'phone_no',
        'name',
        'email',
        'pass',
        'level',
        'current_point',
    ];

    protected $hidden = [
        'pass', 
    ];

    public function getAuthIdentifierName()
    {
        return 'phone_no'; 
    }

    public function getAuthPassword()
    {
        return $this->pass;
    }
}