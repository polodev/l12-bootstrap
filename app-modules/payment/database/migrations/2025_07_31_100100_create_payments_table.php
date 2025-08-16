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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Payment type - determines if this is for a booking or custom payment
            $table->string('payment_type')->default('custom_payment'); // 'custom_payment'
            
            
            // Who created this payment record
            $table->foreignId('created_by')->nullable(); // User ID of creator (admin/employee or auto-generated)
            
            // Payment details
            $table->decimal('amount', 10, 2);
            $table->string('email_address')->nullable(); // Email address for payment (used for both types)
            $table->string('store_name')->default('default_store'); // SSL Commerz store name
            $table->string('status')->default('pending'); // 'pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded'
            $table->string('payment_method')->nullable(); // 'sslcommerz', 'bkash', 'nagad', 'city_bank', 'brac_bank', 'bank_transfer', 'cash', 'other'
            
            // Customer details (used when payment_type = 'custom_payment')
            $table->string('name')->nullable(); // Customer name for custom payments
            $table->string('mobile', 20)->nullable(); // Customer mobile for custom payments
            $table->string('purpose')->nullable(); // Purpose of payment (custom payments)
            $table->text('description')->nullable(); // Payment description (custom payments)
            
            // Form submission details (from custom_payments)
            $table->json('form_data')->nullable(); // Complete form submission data
            $table->string('ip_address')->nullable(); // Submitter's IP
            $table->string('user_agent')->nullable(); // Submitter's browser info
            
            // Payment gateway information
            $table->string('transaction_id')->nullable(); // Gateway transaction ID
            $table->string('gateway_payment_id')->nullable(); // Payment ID sent to gateway
            $table->json('gateway_response')->nullable(); // Full gateway response
            $table->string('gateway_reference')->nullable(); // Gateway reference number
            $table->string('bank_name')->nullable(); // Bank name for bank transfers
            
            // Payment dates
            $table->datetime('payment_date')->nullable(); // When payment was made
            $table->datetime('processed_at')->nullable(); // When payment was processed
            $table->datetime('failed_at')->nullable(); // When payment failed
            $table->datetime('refunded_at')->nullable(); // When payment was refunded
            
            // Additional information
            $table->text('notes')->nullable(); // Customer notes
            $table->text('admin_notes')->nullable(); // Internal admin notes
            $table->string('receipt_number')->nullable(); // Receipt/invoice number
            $table->json('payment_details')->nullable(); // Additional payment information
            $table->foreignId('processed_by')->nullable(); // Admin who processed the payment
            
            $table->timestamps();
            
            // Indexes
            $table->index(['payment_type', 'status']);
            $table->index(['status', 'payment_method']);
            $table->index(['transaction_id']);
            $table->index(['gateway_payment_id']);
            $table->index(['payment_date']);
            $table->index(['created_by']);
            $table->index(['email_address', 'status']); // For payment lookups
            $table->index(['mobile', 'status']); // For payment lookups
            $table->index(['ip_address', 'created_at']); // For rate limiting
            
            // Note: Application-level validation will ensure proper payment_type handling:
            // - When payment_type = 'custom_payment': customer fields should be filled
            
            // Note: Foreign key constraints removed - validation handled at application level
        });
        DB::statement("ALTER TABLE payments AUTO_INCREMENT = 100000;");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};