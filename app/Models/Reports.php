<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reports extends Model
{
    use HasFactory;
    protected $fillable = [
        'reporter_id',
        'reported_id',
        'reportable_id',
        'reportable_type',
        'reason',
    ];

    /**
     * The user who reported the content.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * The user who was reported (if applicable).
     */
    // public function reportedUser(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'reported_id');
    // }
    public function reportedAuthor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    /**
     * The entity that was reported (Post, Comment, etc.).
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
