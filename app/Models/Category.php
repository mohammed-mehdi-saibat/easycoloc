<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'icon', 'colocation_id'];

  
    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

   
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}