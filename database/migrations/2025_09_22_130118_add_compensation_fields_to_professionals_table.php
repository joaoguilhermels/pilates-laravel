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
        Schema::table('professionals', function (Blueprint $table) {
            $table->enum('compensation_model', [
                'fixed_salary', 
                'commission_only', 
                'salary_plus_commission'
            ])->default('commission_only')->after('phone');
            
            $table->decimal('fixed_salary', 10, 2)->nullable()->after('compensation_model');
            $table->decimal('commission_percentage', 5, 2)->nullable()->after('fixed_salary');
            $table->text('compensation_notes')->nullable()->after('commission_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropColumn([
                'compensation_model',
                'fixed_salary', 
                'commission_percentage',
                'compensation_notes'
            ]);
        });
    }
};
