<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'global_role',
        'is_banned',
        'reputation',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
            'reputation' => 'integer',
        ];
    }

   
    public function colocations(): BelongsToMany
    {
        return $this->belongsToMany(Colocation::class)
            ->withPivot('role', 'left_at')
            ->withTimestamps();
    }

  
    public function hasColocation(): bool
    {
        return $this->colocations()->wherePivot('left_at', null)->exists();
    }

   
    public function activeColocation()
    {
        return $this->colocations()->wherePivot('left_at', null)->first();
    }

    public function expenses() {
        return $this->hasMany(Expense::class);
    }
}