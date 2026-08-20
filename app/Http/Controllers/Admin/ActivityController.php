<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreActivityRequest;
use App\Http\Requests\Admin\UpdateActivityRequest;
use App\Models\Activity;
use App\Services\ActivityService;

class ActivityController extends Controller
{
    public function __construct(private ActivityService $service) {}

    public function index()
    {
        $this->authorize('viewAny', Activity::class);
        $activities = Activity::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        $this->authorize('create', Activity::class);
        return view('admin.activities.create');
    }

    public function store(StoreActivityRequest $request)
    {
        $activity = $this->service->store($request);
        return redirect()->route('admin.activities.index')
            ->with('status', "Actividad «{$activity->name}» creada correctamente.");
    }

    public function edit(Activity $activity)
    {
        $this->authorize('update', $activity);
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $this->service->update($request, $activity);
        return redirect()->route('admin.activities.index')
            ->with('status', "Actividad «{$activity->name}» actualizada.");
    }

    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);
        $this->service->destroy($activity);
        return redirect()->route('admin.activities.index')
            ->with('status', "Actividad eliminada.");
    }

    public function toggleStatus(Activity $activity)
    {
        $this->authorize('update', $activity);
        $activity = $this->service->toggleStatus($activity);
        return back()->with('status', "Estado de «{$activity->name}» actualizado.");
    }
}