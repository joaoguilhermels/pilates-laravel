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
            $table->string('stripe_customer_id')->nullable()->after('is_active');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id');
            $table->string('stripe_payment_method_id')->nullable()->after('stripe_subscription_id');
            $table->string('stripe_subscription_status')->nullable()->after('stripe_payment_method_id');
            $table->timestamp('stripe_subscription_current_period_start')->nullable()->after('stripe_subscription_status');
            $table->timestamp('stripe_subscription_current_period_end')->nullable()->after('stripe_subscription_current_period_start');
            $table->boolean('stripe_subscription_cancel_at_period_end')->default(false)->after('stripe_subscription_current_period_end');
            $table->timestamp('stripe_subscription_canceled_at')->nullable()->after('stripe_subscription_cancel_at_period_end');
            $table->json('stripe_metadata')->nullable()->after('stripe_subscription_canceled_at');
            
            // Brazilian tax fields
            $table->string('tax_id')->nullable()->after('stripe_metadata'); // CPF or CNPJ
            $table->enum('tax_id_type', ['cpf', 'cnpj'])->nullable()->after('tax_id');
            $table->string('company_name')->nullable()->after('tax_id_type'); // For CNPJ
            
            // Address fields for Brazilian invoicing
            $table->string('address_line1')->nullable()->after('company_name');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('address_city')->nullable()->after('address_line2');
            $table->string('address_state')->nullable()->after('address_city');
            $table->string('address_postal_code')->nullable()->after('address_state');
            $table->string('address_country')->default('BR')->after('address_postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_customer_id',
                'stripe_subscription_id',
                'stripe_payment_method_id',
                'stripe_subscription_status',
                'stripe_subscription_current_period_start',
                'stripe_subscription_current_period_end',
                'stripe_subscription_cancel_at_period_end',
                'stripe_subscription_canceled_at',
                'stripe_metadata',
                'tax_id',
                'tax_id_type',
                'company_name',
                'address_line1',
                'address_line2',
                'address_city',
                'address_state',
                'address_postal_code',
                'address_country',
            ]);
        });
    }
};
