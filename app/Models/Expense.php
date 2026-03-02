<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = ['description', 'amount', 'spent_at', 'user_id', 'colocation_id', 'category_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function payer(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function colocation(): BelongsTo {
        return $this->belongsTo(Colocation::class);
    }

    public function settlements() {
        return $this->hasMany(Settlement::class);
    }
}