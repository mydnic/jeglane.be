<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GleaningLocation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'files',
        'user_id',
        'description',
        'gleanable_id',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'archived_at',
    ];

    protected $casts = [
        'files' => 'array',
        'archived_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->whereNull('archived_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gleanable()
    {
        return $this->belongsTo(Gleanable::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function userVote()
    {
        return $this->hasOne(Vote::class)->where('user_id', auth()->id());
    }

    public function getVoteCountAttribute()
    {
        return $this->votes()->sum('vote');
    }
}
