<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'page_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();
    
        static::created(function ($user) {
            $user->pageSettings()->create([
                'page_description' => null, // Initialize with null or default value
            ]);
        });
    }
    
    


    public function links()
    {
        return $this->hasMany(Link::class);
    }
    public function pageSettings()
    {
        return $this->hasOne(PageSettings::class);
    }
}