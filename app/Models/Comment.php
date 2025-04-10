<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\GleaningLocation;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'gleaning_location_id',
        'parent_id',
    ];

    protected $with = ['replies.user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gleaningLocation(): BelongsTo
    {
        return $this->belongsTo(GleaningLocation::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
