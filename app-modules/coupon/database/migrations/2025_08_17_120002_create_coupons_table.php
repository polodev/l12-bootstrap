<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	public function up(): void
	{
		Schema::create('coupons', function(Blueprint $table) {
			$table->id();
			$table->string('code')->unique(); // Coupon code
			$table->string('name'); // Display name for the coupon
			$table->text('description')->nullable();
			
			// Discount configuration
			$table->enum('type', ['percentage', 'fixed']); // 'percentage' or 'fixed'
			$table->decimal('value', 10, 2); // Discount value (% or fixed amount)
			$table->decimal('minimum_amount', 10, 2)->nullable(); // Minimum order amount
			$table->decimal('maximum_discount', 10, 2)->nullable(); // Maximum discount for percentage coupons
			
			// Usage limitations
			$table->integer('usage_limit')->nullable(); // Total usage limit
			$table->integer('usage_limit_per_user')->nullable(); // Usage limit per user
			$table->integer('used_count')->default(0); // Total times used
			
			// Subscription plan limitations
			$table->json('applicable_plans')->nullable(); // Array of plan IDs this coupon applies to
			
			// Validity period
			$table->datetime('starts_at')->nullable();
			$table->datetime('expires_at')->nullable();
			
			// Status
			$table->boolean('is_active')->default(true);
			
			// Audit
			$table->unsignedBigInteger('created_by')->nullable(); // References users.id (admin who created)
			
			$table->timestamps();
			$table->softDeletes();
			
			// Indexes
			$table->index(['code', 'is_active']);
			$table->index(['is_active', 'starts_at', 'expires_at']);
			$table->index('created_by');
		});

		// Coupon usage tracking
		Schema::create('coupon_usages', function(Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('coupon_id'); // References coupons.id
			$table->unsignedBigInteger('user_id'); // References users.id
			$table->unsignedBigInteger('user_subscription_id'); // References user_subscriptions.id
			$table->decimal('discount_amount', 10, 2);
			$table->datetime('used_at');
			$table->timestamps();
			
			// Indexes
			$table->index(['coupon_id', 'user_id']);
			$table->index('used_at');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('coupon_usages');
		Schema::dropIfExists('coupons');
	}
};