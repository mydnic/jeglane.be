<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GleaningLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'latitude',
        'longitude',
    ];

    public function scopeActive()
    {
        return $this->whereDate('created_at', '>=', now()->subMonths(2));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
