<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasPublicCode
{
    public static function bootHasPublicCode(): void
    {
        static::creating(function (Model $model): void {
            if (blank($model->public_code)) {
                $model->public_code = $model->generatePublicCode();
            }
        });
    }

    public function generatePublicCode(): string
    {
        $year = now()->format('Y');
        $prefix = $this->publicCodePrefix().'-'.$year.'-';

        $last = static::query()
            ->where('public_code', 'like', $prefix.'%')
            ->lockForUpdate()
            ->orderByDesc('public_code')
            ->value('public_code');

        $sequence = $last ? ((int) substr($last, -4)) + 1 : 1;

        return $prefix.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    protected function publicCodePrefix(): string
    {
        return 'CNA';
    }

    public function getRouteKeyName(): string
    {
        return 'public_code';
    }
}