<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['colocation_id', 'inviter_id', 'email', 'token', 'expires_at', 'accepted'];

    protected $casts = ['expires_at' => 'datetime',];

    public function colocation() {
        return $this->belongsTo(Colocation::class);
    }

    public function inviter() {
        return $this->belongsTo(User::class, 'inviter_id');
    }
}
