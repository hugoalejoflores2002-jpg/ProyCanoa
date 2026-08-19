<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_events', function (Blueprint $table) {
            $table->id();
            $table->string('event', 80)->index();
            $table->string('entity_type', 80)->nullable()->index();
            $table->unsignedBigInteger('entity_id')->nullable()->index();
            $table->string('entity_label', 120)->nullable();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('actor_name', 120)->nullable();
            $table->text('reason')->nullable();
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('occurred_at')->useCurrent();

            $table->index(['entity_type', 'entity_id']);
            $table->index(['actor_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_events');
    }
};