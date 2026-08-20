<?php

use App\Enums\ActivityStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80)->unique();
            $table->string('slug', 80)->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('icon', 40)->nullable();
            $table->unsignedSmallInteger('default_capacity')->default(20);
            $table->unsignedSmallInteger('min_participants')->default(1);
            $table->unsignedSmallInteger('max_participants')->default(50);
            $table->unsignedSmallInteger('duration_minutes')->default(120);
            $table->string('difficulty', 20)->default('moderate');
            $table->string('status', 20)->default(ActivityStatus::Active->value)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};