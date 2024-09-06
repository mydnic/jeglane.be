<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GleaningLocation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'files',
        'user_id',
        'description',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'files' => 'array',
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
