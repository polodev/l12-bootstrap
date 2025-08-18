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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // References users.id
            $table->unsignedBigInteger('subscription_plan_id'); // References subscription_plans.id
            $table->unsignedBigInteger('payment_id')->nullable(); // References payments.id
            
            // Subscription period
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->datetime('activated_at')->nullable();
            $table->datetime('cancelled_at')->nullable();
            
            // Status is calculated dynamically via model accessor based on payment status and dates
            
            // Pricing at time of purchase (for historical record)
            $table->decimal('paid_amount', 10, 2);
            $table->string('currency', 3)->default('BDT');
            
            // Coupon information (if used)
            $table->unsignedBigInteger('coupon_id')->nullable(); // References coupons.id
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('coupon_code')->nullable(); // Store for historical record
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'ends_at']);
            $table->index(['payment_id']);
            $table->index(['starts_at', 'ends_at']);
            $table->index(['cancelled_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};