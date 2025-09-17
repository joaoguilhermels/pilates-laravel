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
        // Add soft deletes to clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to professionals table
        Schema::table('professionals', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to rooms table
        Schema::table('rooms', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to class_types table
        Schema::table('class_types', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to client_plans table
        Schema::table('client_plans', function (Blueprint $table) {
            $table->softDeletes();
        });

        // Add soft deletes to schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove soft deletes from clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from professionals table
        Schema::table('professionals', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from rooms table
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from class_types table
        Schema::table('class_types', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from plans table
        Schema::table('plans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from client_plans table
        Schema::table('client_plans', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Remove soft deletes from schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
