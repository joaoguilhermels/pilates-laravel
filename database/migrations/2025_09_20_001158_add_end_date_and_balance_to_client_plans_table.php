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
        Schema::table('client_plans', function (Blueprint $table) {
            $table->date('end_date')->nullable()->after('start_at');
            $table->decimal('balance', 10, 2)->default(0)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_plans', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'balance']);
        });
    }
};
