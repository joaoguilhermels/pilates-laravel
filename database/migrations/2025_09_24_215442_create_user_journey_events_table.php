<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_journey_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('session_id')->index(); // For anonymous tracking
            $table->string('event_type'); // awareness, consideration, trial, adoption, advocacy
            $table->string('event_name'); // specific action taken
            $table->string('persona_type')->nullable(); // marina, carlos, ana, lucia
            $table->string('source')->nullable(); // utm_source, referrer, etc.
            $table->string('medium')->nullable(); // utm_medium
            $table->string('campaign')->nullable(); // utm_campaign
            $table->json('properties')->nullable(); // additional event data
            $table->string('page_url')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('event_timestamp');
            $table->timestamps();
            
            // Indexes for analytics queries
            $table->index(['event_type', 'event_name']);
            $table->index(['persona_type', 'event_type']);
            $table->index(['user_id', 'event_timestamp']);
            $table->index(['session_id', 'event_timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_journey_events');
    }
};
