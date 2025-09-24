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
        Schema::table('users', function (Blueprint $table) {
            $table->string('studio_name')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('saas_plan_id')->nullable()->constrained('saas_plans');
            $table->string('billing_cycle')->default('monthly'); // monthly or yearly
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();
            $table->boolean('is_trial')->default(true);
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['saas_plan_id']);
            $table->dropColumn([
                'studio_name',
                'phone',
                'saas_plan_id',
                'billing_cycle',
                'trial_ends_at',
                'subscription_ends_at',
                'is_trial',
                'is_active'
            ]);
        });
    }
};
