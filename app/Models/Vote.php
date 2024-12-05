<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    protected $fillable = ['vote', 'user_id', 'gleaning_location_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gleaningLocation(): BelongsTo
    {
        return $this->belongsTo(GleaningLocation::class);
    }
}
