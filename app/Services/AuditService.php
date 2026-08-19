<?php

namespace App\Services;

use App\Models\BusinessEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService extends Service
{
    public function record(
        string $event,
        ?object $entity = null,
        ?string $reason = null,
        ?array $before = null,
        ?array $after = null,
        ?array $metadata = null
    ): BusinessEvent {
        $actor = Auth::user();

        return BusinessEvent::create([
            'event'        => $event,
            'entity_type'  => $entity ? class_basename($entity) : null,
            'entity_id'    => $entity?->getKey(),
            'entity_label' => $entity ? $this->labelFor($entity) : null,
            'actor_id'     => $actor?->id,
            'actor_name'   => $actor?->name ?? 'Sistema',
            'reason'       => $reason,
            'before'       => $before,
            'after'        => $after,
            'metadata'     => $metadata,
            'ip_address'   => Request::ip(),
            'user_agent'   => Request::userAgent(),
            'occurred_at'  => now(),
        ]);
    }

    private function labelFor(object $entity): string
    {
        return match (true) {
            isset($entity->name)  => $entity->name,
            isset($entity->title) => $entity->title,
            isset($entity->email) => $entity->email,
            isset($entity->public_code) => $entity->public_code,
            default => class_basename($entity).' #'.$entity->getKey(),
        };
    }
}