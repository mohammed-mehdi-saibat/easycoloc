<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = ['name', 'description', 'owner_id'];

    public function users() {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'left_at')
            ->withTimestamps();
    }

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function expenses() {
        return $this->hasMany(Expense::class);
    }
}