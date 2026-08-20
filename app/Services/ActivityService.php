<?php

namespace App\Services;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Http\Requests\Admin\StoreActivityRequest;
use App\Http\Requests\Admin\UpdateActivityRequest;

class ActivityService extends Service
{
    public function store(StoreActivityRequest $request): Activity
    {
        return $this->transaction(fn() => Activity::create($request->validated()));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): Activity
    {
        return $this->transaction(function () use ($request, $activity) {
            $activity->update($request->validated());
            return $activity->fresh();
        });
    }

    public function toggleStatus(Activity $activity): Activity
    {
        return $this->transaction(function () use ($activity) {
            $activity->update([
                'status' => $activity->status === ActivityStatus::Active
                    ? ActivityStatus::Inactive
                    : ActivityStatus::Active,
            ]);
            return $activity->fresh();
        });
    }

    public function destroy(Activity $activity): void
    {
        $this->transaction(fn() => $activity->delete());
    }
}