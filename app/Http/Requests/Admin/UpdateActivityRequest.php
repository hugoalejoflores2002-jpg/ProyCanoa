<?php

namespace App\Http\Requests\Admin;

use App\Enums\ActivityStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('activities.edit');
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:80', Rule::unique('activities', 'name')->ignore($this->activity)],
            'slug'              => ['nullable', 'string', 'max:80', Rule::unique('activities', 'slug')->ignore($this->activity)],
            'description'       => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'icon'              => ['nullable', 'string', 'max:40'],
            'default_capacity'  => ['required', 'integer', 'min:1', 'max:500'],
            'min_participants'  => ['required', 'integer', 'min:1'],
            'max_participants'  => ['required', 'integer', 'min:1', 'gte:min_participants'],
            'duration_minutes'  => ['required', 'integer', 'min:15'],
            'difficulty'        => ['required', Rule::in(['easy', 'moderate', 'hard', 'expert'])],
            'status'            => ['required', Rule::enum(ActivityStatus::class)],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ];
    }
}