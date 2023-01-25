<?php

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\User\Relationships\UserRelationship;
use App\Models\User\Scopes\UserScope;
use App\Traits\CanOrdered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use UserScope , UserRelationship;
    use CanOrdered;

    protected $guarded = ['id' , 'created_at' , 'updated_at'];

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
        'birth_day' => 'date',
    ];

    //todo - if not save age in database can use this method directly
   /* public function AgeAttribute(): int
    {
        return now()->diffInYears($this->birth_day);
    }*/
}
