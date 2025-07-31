<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

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
            ''
        ];
    }

    public function superAdmin(): \Illuminate\Database\Eloquent\Relations\HasOne|User
    {
        return $this->hasOne(SuperAdmin::class);
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\HasOne|User
    {
        return $this->hasOne(Admin::class);
    }

    public function faculty(): \Illuminate\Database\Eloquent\Relations\HasOne|User
    {
        return $this->hasOne(Faculty::class);
    }

    public function student(): \Illuminate\Database\Eloquent\Relations\HasOne|User
    {
        return $this->hasOne(Student::class);
    }
}
