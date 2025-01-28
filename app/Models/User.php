<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Eums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const MALE = 'm';
    const FEMALE = 'f';
    const OTHER = 'o';
    const GENDERS = [
            self::MALE => 'Male',
            self::FEMALE => 'Female',
            self::OTHER => 'Other',
        ];


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'dob',
        'gender',
        'role_type',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRoleTypeEnumAttribute()
    {
        return UserRole::tryFrom($this->attributes['role_type']);
    }

    public function getRoleName()
    {
        return UserRole::getName($this->role_type);
    }

    public function hasRole(UserRole $role): bool
    {
        return $this->role_type === $role->value;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name. " ". $this->last_name;
    }
}
