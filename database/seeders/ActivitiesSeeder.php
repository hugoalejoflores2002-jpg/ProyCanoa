<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        $activities = [
            ['name' => 'Rafting',      'slug' => 'rafting',      'icon' => 'waves',    'duration_minutes' => 180, 'default_capacity' => 10, 'sort_order' => 1],
            ['name' => 'Tubing',       'slug' => 'tubing',       'icon' => 'circle',   'duration_minutes' => 120, 'default_capacity' => 20, 'sort_order' => 2],
            ['name' => 'Kayaking',     'slug' => 'kayaking',     'icon' => 'anchor',   'duration_minutes' => 120, 'default_capacity' => 8,  'sort_order' => 3],
            ['name' => 'Paddling',     'slug' => 'paddling',     'icon' => 'wind',     'duration_minutes' => 90,  'default_capacity' => 12, 'sort_order' => 4],
            ['name' => 'Camping',      'slug' => 'camping',      'icon' => 'tent',     'duration_minutes' => 480, 'default_capacity' => 15, 'sort_order' => 5],
            ['name' => 'Trekking',     'slug' => 'trekking',     'icon' => 'map',      'duration_minutes' => 240, 'default_capacity' => 12, 'sort_order' => 6],
            ['name' => 'Espeleologia', 'slug' => 'espeleologia', 'icon' => 'mountain', 'duration_minutes' => 180, 'default_capacity' => 8,  'sort_order' => 7],
        ];

        foreach ($activities as $data) {
            Activity::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}