<?php

namespace App\Models;

use App\Enums\ActivityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Activity extends Model implements Auditable
{
    use SoftDeletes, AuditableTrait;

    protected $fillable = [
        'name', 'slug', 'description', 'short_description',
        'icon', 'default_capacity', 'min_participants',
        'max_participants', 'duration_minutes', 'difficulty',
        'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'status' => ActivityStatus::class,
            'default_capacity' => 'integer',
            'min_participants' => 'integer',
            'max_participants' => 'integer',
            'duration_minutes' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Activity $activity) {
            if (blank($activity->slug)) {
                $activity->slug = Str::slug($activity->name);
            }
        });
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', ActivityStatus::Active);
    }
}