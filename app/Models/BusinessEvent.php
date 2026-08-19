<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'event', 'entity_type', 'entity_id', 'entity_label',
        'actor_id', 'actor_name', 'reason',
        'before', 'after', 'metadata',
        'ip_address', 'user_agent', 'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'before' => 'array',
            'after' => 'array',
            'metadata' => 'array',
            'occurred_at' => 'datetime',
        ];
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}