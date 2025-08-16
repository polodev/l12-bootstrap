# Payment Module Documentation

## Overview

The Payment module handles all financial transactions for the Eco Travel platform. It provides secure payment processing, multi-currency support, payment gateway integration, and comprehensive transaction tracking with support for refunds, partial payments, and various payment methods.

## Module Structure

```
app-modules/payment/
├── src/
│   ├── Models/
│   │   ├── Payment.php
│   │   ├── PaymentGateway.php
│   │   └── Transaction.php
│   ├── Http/Controllers/
│   │   ├── PaymentController.php
│   │   ├── PaymentGatewayController.php
│   │   └── TransactionController.php
│   ├── Services/
│   │   ├── PaymentService.php
│   │   ├── GatewayService.php
│   │   └── RefundService.php
│   └── Providers/
│       └── PaymentServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/
└── routes/
```

## Database Schema

### Payment Gateways Table
```sql
CREATE TABLE payment_gateways (
    id BIGINT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,               -- 'Stripe', 'PayPal', 'Square'
    slug VARCHAR(50) UNIQUE NOT NULL,         -- 'stripe', 'paypal', 'square'
    provider VARCHAR(50) NOT NULL,            -- Technical identifier
    description TEXT,
    
    -- Configuration
    configuration JSON,                       -- Gateway-specific settings
    credentials JSON,                         -- Encrypted credentials
    
    -- Supported features
    supports_cards BOOLEAN DEFAULT true,
    supports_bank_transfer BOOLEAN DEFAULT false,
    supports_digital_wallets BOOLEAN DEFAULT false,
    supports_recurring BOOLEAN DEFAULT false,
    supports_refunds BOOLEAN DEFAULT true,
    supports_partial_refunds BOOLEAN DEFAULT true,
    
    -- Supported currencies
    supported_currencies JSON,               -- ['USD', 'EUR', 'GBP', 'BDT']
    
    -- Fees and limits
    fixed_fee DECIMAL(10,2) DEFAULT 0.00,   -- Fixed fee per transaction
    percentage_fee DECIMAL(5,4) DEFAULT 0.00, -- Percentage fee (e.g., 2.9% = 0.029)
    min_amount DECIMAL(10,2) DEFAULT 1.00,
    max_amount DECIMAL(12,2) DEFAULT 999999.99,
    
    -- Status and settings
    is_active BOOLEAN DEFAULT true,
    is_default BOOLEAN DEFAULT false,
    priority INTEGER DEFAULT 0,              -- Display order
    
    -- Environment
    environment ENUM('sandbox', 'live') DEFAULT 'sandbox',
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX idx_provider (provider),
    INDEX idx_active (is_active),
    INDEX idx_priority (priority)
);
```

### Payments Table
```sql
CREATE TABLE payments (
    id BIGINT PRIMARY KEY,
    booking_id BIGINT NOT NULL,
    payment_gateway_id BIGINT NOT NULL,
    
    -- Payment identification
    payment_reference VARCHAR(50) UNIQUE NOT NULL, -- PY-2024-001234
    gateway_transaction_id VARCHAR(255),     -- Gateway's transaction ID
    gateway_reference VARCHAR(255),          -- Gateway's reference
    
    -- Payment details
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(3) NOT NULL DEFAULT 'USD',
    exchange_rate DECIMAL(10,6),             -- If currency conversion applied
    amount_in_base_currency DECIMAL(12,2),  -- Amount in system base currency
    
    -- Payment method
    payment_method ENUM('credit_card', 'debit_card', 'bank_transfer', 'digital_wallet', 'cash', 'cheque') NOT NULL,
    payment_submethod VARCHAR(50),           -- 'visa', 'mastercard', 'paypal', 'apple_pay'
    
    -- Card details (if applicable, encrypted)
    card_last_four VARCHAR(4),
    card_brand VARCHAR(20),                  -- 'visa', 'mastercard', 'amex'
    card_expiry_month INTEGER,
    card_expiry_year INTEGER,
    
    -- Status and processing
    status ENUM('pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded', 'partially_refunded') DEFAULT 'pending',
    
    -- Timing
    initiated_at DATETIME NOT NULL,
    processed_at DATETIME NULL,
    failed_at DATETIME NULL,
    
    -- Gateway response
    gateway_response JSON,                   -- Full gateway response
    failure_reason TEXT,                     -- Failure description
    failure_code VARCHAR(50),                -- Gateway failure code
    
    -- Fee breakdown
    gateway_fee DECIMAL(10,2) DEFAULT 0.00,
    platform_fee DECIMAL(10,2) DEFAULT 0.00,
    net_amount DECIMAL(12,2),                -- Amount after fees
    
    -- Refund tracking
    refunded_amount DECIMAL(12,2) DEFAULT 0.00,
    refund_count INTEGER DEFAULT 0,
    
    -- Metadata
    payment_metadata JSON,                   -- Additional payment data
    customer_ip VARCHAR(45),                 -- Customer IP for security
    user_agent TEXT,                         -- Browser/app info
    
    -- Reconciliation
    reconciled BOOLEAN DEFAULT false,
    reconciled_at DATETIME NULL,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (payment_gateway_id) REFERENCES payment_gateways(id),
    
    INDEX idx_booking (booking_id),
    INDEX idx_gateway (payment_gateway_id),
    INDEX idx_reference (payment_reference),
    INDEX idx_status (status),
    INDEX idx_processed_date (processed_at),
    INDEX idx_amount_currency (amount, currency)
);
```

### Transactions Table (Refunds, Adjustments, etc.)
```sql
CREATE TABLE transactions (
    id BIGINT PRIMARY KEY,
    payment_id BIGINT NOT NULL,
    
    -- Transaction identification
    transaction_reference VARCHAR(50) UNIQUE NOT NULL, -- TX-2024-001234
    gateway_transaction_id VARCHAR(255),     -- Gateway's refund/adjustment ID
    
    -- Transaction details
    type ENUM('refund', 'partial_refund', 'chargeback', 'adjustment', 'fee') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    currency VARCHAR(3) NOT NULL,
    
    -- Status
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    
    -- Details
    reason TEXT,                             -- Reason for transaction
    notes TEXT,                              -- Internal notes
    
    -- Processing
    initiated_by ENUM('customer', 'admin', 'system', 'gateway') NOT NULL,
    initiated_by_user_id BIGINT NULL,        -- Admin user if applicable
    processed_at DATETIME NULL,
    
    -- Gateway response
    gateway_response JSON,
    failure_reason TEXT,
    
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (payment_id) REFERENCES payments(id),
    
    INDEX idx_payment (payment_id),
    INDEX idx_type_status (type, status),
    INDEX idx_processed_date (processed_at)
);
```

## Model Relationships

### Payment Model
```php
class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'payment_gateway_id', 'payment_reference',
        'gateway_transaction_id', 'gateway_reference', 'amount',
        'currency', 'exchange_rate', 'amount_in_base_currency',
        'payment_method', 'payment_submethod', 'card_last_four',
        'card_brand', 'card_expiry_month', 'card_expiry_year',
        'status', 'initiated_at', 'processed_at', 'failed_at',
        'gateway_response', 'failure_reason', 'failure_code',
        'gateway_fee', 'platform_fee', 'net_amount',
        'refunded_amount', 'refund_count', 'payment_metadata',
        'customer_ip', 'user_agent', 'reconciled', 'reconciled_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'exchange_rate' => 'decimal:6',
        'amount_in_base_currency' => 'decimal:2',
        'gateway_fee' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'gateway_response' => 'array',
        'payment_metadata' => 'array',
        'reconciled' => 'boolean',
        'initiated_at' => 'datetime',
        'processed_at' => 'datetime',
        'failed_at' => 'datetime',
        'reconciled_at' => 'datetime',
    ];

    // Relationships
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
    
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }
    
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function refunds(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', 'refund');
    }
    
    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
    
    public function scopeByDateRange($query, Carbon $start, Carbon $end)
    {
        return $query->whereBetween('processed_at', [$start, $end]);
    }
    
    public function scopeByCurrency($query, string $currency)
    {
        return $query->where('currency', $currency);
    }
    
    // Methods
    public function generateReference(): string
    {
        $year = now()->year;
        $lastPayment = static::whereYear('created_at', $year)
                           ->orderBy('id', 'desc')
                           ->first();
        
        $number = $lastPayment ? 
            intval(substr($lastPayment->payment_reference, -6)) + 1 : 
            1;
        
        return sprintf('PY-%d-%06d', $year, $number);
    }
    
    public function markAsCompleted(array $gatewayResponse = []): void
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => now(),
            'gateway_response' => $gatewayResponse,
            'net_amount' => $this->amount - $this->gateway_fee - $this->platform_fee,
        ]);
        
        // Update booking payment status
        $this->booking->increment('paid_amount', $this->amount);
        $this->updateBookingPaymentStatus();
    }
    
    public function markAsFailed(string $reason, string $code = null): void
    {
        $this->update([
            'status' => 'failed',
            'failed_at' => now(),
            'failure_reason' => $reason,
            'failure_code' => $code,
        ]);
    }
    
    public function canBeRefunded(): bool
    {
        return $this->status === 'completed' 
            && $this->gateway->supports_refunds
            && $this->refunded_amount < $this->amount;
    }
    
    public function getRefundableAmountAttribute(): float
    {
        return $this->amount - $this->refunded_amount;
    }
    
    public function processRefund(float $amount, string $reason = null): Transaction
    {
        if (!$this->canBeRefunded()) {
            throw new PaymentException('Payment cannot be refunded');
        }
        
        if ($amount > $this->refundable_amount) {
            throw new PaymentException('Refund amount exceeds refundable amount');
        }
        
        return Transaction::create([
            'payment_id' => $this->id,
            'transaction_reference' => $this->generateTransactionReference(),
            'type' => $amount >= $this->amount ? 'refund' : 'partial_refund',
            'amount' => $amount,
            'currency' => $this->currency,
            'reason' => $reason,
            'initiated_by' => 'admin', // or get from auth
            'status' => 'pending',
        ]);
    }
    
    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'yellow',
            'processing' => 'blue',
            'completed' => 'green',
            'failed' => 'red',
            'cancelled' => 'gray',
            'refunded' => 'purple',
            'partially_refunded' => 'orange'
        ];
        
        $color = $colors[$this->status];
        $label = ucwords(str_replace('_', ' ', $this->status));
        
        return "<span class='badge badge-{$color}'>{$label}</span>";
    }
    
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }
    
    public function getMaskedCardNumberAttribute(): string
    {
        if (!$this->card_last_four) {
            return 'N/A';
        }
        
        return '**** **** **** ' . $this->card_last_four;
    }
    
    private function updateBookingPaymentStatus(): void
    {
        $booking = $this->booking;
        $totalPaid = $booking->payments()->completed()->sum('amount');
        
        if ($totalPaid >= $booking->total_amount) {
            $booking->update(['payment_status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $booking->update(['payment_status' => 'partial']);
        } else {
            $booking->update(['payment_status' => 'pending']);
        }
    }
}
```

### PaymentGateway Model
```php
class PaymentGateway extends Model
{
    protected $fillable = [
        'name', 'slug', 'provider', 'description', 'configuration',
        'credentials', 'supports_cards', 'supports_bank_transfer',
        'supports_digital_wallets', 'supports_recurring', 'supports_refunds',
        'supports_partial_refunds', 'supported_currencies', 'fixed_fee',
        'percentage_fee', 'min_amount', 'max_amount', 'is_active',
        'is_default', 'priority', 'environment'
    ];

    protected $casts = [
        'configuration' => 'encrypted:array',
        'credentials' => 'encrypted:array',
        'supported_currencies' => 'array',
        'supports_cards' => 'boolean',
        'supports_bank_transfer' => 'boolean',
        'supports_digital_wallets' => 'boolean',
        'supports_recurring' => 'boolean',
        'supports_refunds' => 'boolean',
        'supports_partial_refunds' => 'boolean',
        'fixed_fee' => 'decimal:2',
        'percentage_fee' => 'decimal:4',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    // Relationships
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeForCurrency($query, string $currency)
    {
        return $query->whereJsonContains('supported_currencies', $currency);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('priority')->orderBy('name');
    }
    
    // Methods
    public function calculateFees(float $amount): array
    {
        $fixedFee = $this->fixed_fee;
        $percentageFee = $amount * $this->percentage_fee;
        $totalFee = $fixedFee + $percentageFee;
        
        return [
            'fixed_fee' => $fixedFee,
            'percentage_fee' => $percentageFee,
            'total_fee' => $totalFee,
            'net_amount' => $amount - $totalFee,
        ];
    }
    
    public function supportsAmount(float $amount): bool
    {
        return $amount >= $this->min_amount && $amount <= $this->max_amount;
    }
    
    public function supportsCurrency(string $currency): bool
    {
        return in_array($currency, $this->supported_currencies ?? []);
    }
    
    public function getServiceClass(): string
    {
        return match($this->provider) {
            'stripe' => StripeGatewayService::class,
            'paypal' => PayPalGatewayService::class,
            'square' => SquareGatewayService::class,
            default => throw new PaymentException("Unsupported gateway: {$this->provider}")
        };
    }
}
```

### Transaction Model
```php
class Transaction extends Model
{
    protected $fillable = [
        'payment_id', 'transaction_reference', 'gateway_transaction_id',
        'type', 'amount', 'currency', 'status', 'reason', 'notes',
        'initiated_by', 'initiated_by_user_id', 'processed_at',
        'gateway_response', 'failure_reason'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_response' => 'array',
        'processed_at' => 'datetime',
    ];

    // Relationships
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
    
    // Scopes
    public function scopeRefunds($query)
    {
        return $query->whereIn('type', ['refund', 'partial_refund']);
    }
    
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    // Methods
    public function markAsCompleted(array $gatewayResponse = []): void
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => now(),
            'gateway_response' => $gatewayResponse,
        ]);
        
        // Update payment refunded amount if this is a refund
        if (in_array($this->type, ['refund', 'partial_refund'])) {
            $this->payment->increment('refunded_amount', $this->amount);
            $this->payment->increment('refund_count');
            
            // Update payment status
            if ($this->payment->refunded_amount >= $this->payment->amount) {
                $this->payment->update(['status' => 'refunded']);
            } else {
                $this->payment->update(['status' => 'partially_refunded']);
            }
        }
    }
}
```

## Services

### Payment Service
```php
class PaymentService
{
    public function processPayment(Booking $booking, array $paymentData): Payment
    {
        $gateway = PaymentGateway::findOrFail($paymentData['gateway_id']);
        
        // Validate payment
        $this->validatePayment($booking, $gateway, $paymentData);
        
        // Create payment record
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'payment_gateway_id' => $gateway->id,
            'payment_reference' => $this->generateReference(),
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'],
            'payment_method' => $paymentData['method'],
            'payment_submethod' => $paymentData['submethod'] ?? null,
            'initiated_at' => now(),
            'customer_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        // Process with gateway
        $gatewayService = app($gateway->getServiceClass());
        
        try {
            $response = $gatewayService->processPayment($payment, $paymentData);
            
            if ($response['success']) {
                $payment->markAsCompleted($response['data']);
            } else {
                $payment->markAsFailed($response['message'], $response['code'] ?? null);
            }
        } catch (Exception $e) {
            $payment->markAsFailed($e->getMessage());
            throw $e;
        }
        
        return $payment;
    }
    
    public function processRefund(Payment $payment, float $amount, string $reason = null): Transaction
    {
        if (!$payment->canBeRefunded()) {
            throw new PaymentException('Payment cannot be refunded');
        }
        
        $transaction = $payment->processRefund($amount, $reason);
        
        // Process with gateway
        $gatewayService = app($payment->gateway->getServiceClass());
        
        try {
            $response = $gatewayService->processRefund($payment, $transaction);
            
            if ($response['success']) {
                $transaction->markAsCompleted($response['data']);
            } else {
                $transaction->update([
                    'status' => 'failed',
                    'failure_reason' => $response['message'],
                ]);
            }
        } catch (Exception $e) {
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => $e->getMessage(),
            ]);
            throw $e;
        }
        
        return $transaction;
    }
    
    private function validatePayment(Booking $booking, PaymentGateway $gateway, array $data): void
    {
        // Validate gateway supports currency
        if (!$gateway->supportsCurrency($data['currency'])) {
            throw new PaymentException("Gateway does not support currency: {$data['currency']}");
        }
        
        // Validate amount
        if (!$gateway->supportsAmount($data['amount'])) {
            throw new PaymentException("Amount outside gateway limits");
        }
        
        // Validate booking is payable
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            throw new PaymentException("Booking cannot be paid in current status");
        }
    }
}
```

### Gateway Service Interface
```php
interface GatewayServiceInterface
{
    public function processPayment(Payment $payment, array $data): array;
    public function processRefund(Payment $payment, Transaction $transaction): array;
    public function getPaymentStatus(string $gatewayTransactionId): array;
    public function webhookHandler(array $payload): void;
}

class StripeGatewayService implements GatewayServiceInterface
{
    public function processPayment(Payment $payment, array $data): array
    {
        $stripe = new \Stripe\StripeClient($payment->gateway->credentials['secret_key']);
        
        try {
            $intent = $stripe->paymentIntents->create([
                'amount' => $payment->amount * 100, // Convert to cents
                'currency' => strtolower($payment->currency),
                'payment_method' => $data['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'metadata' => [
                    'booking_id' => $payment->booking_id,
                    'payment_id' => $payment->id,
                ],
            ]);
            
            if ($intent->status === 'succeeded') {
                return [
                    'success' => true,
                    'data' => [
                        'transaction_id' => $intent->id,
                        'status' => $intent->status,
                        'charges' => $intent->charges->data,
                    ],
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Payment requires additional action',
                'data' => $intent,
            ];
            
        } catch (\Stripe\Exception\CardException $e) {
            return [
                'success' => false,
                'message' => $e->getError()->message,
                'code' => $e->getError()->code,
            ];
        }
    }
    
    public function processRefund(Payment $payment, Transaction $transaction): array
    {
        $stripe = new \Stripe\StripeClient($payment->gateway->credentials['secret_key']);
        
        try {
            $refund = $stripe->refunds->create([
                'payment_intent' => $payment->gateway_transaction_id,
                'amount' => $transaction->amount * 100,
                'reason' => 'requested_by_customer',
                'metadata' => [
                    'transaction_id' => $transaction->id,
                    'booking_id' => $payment->booking_id,
                ],
            ]);
            
            return [
                'success' => true,
                'data' => [
                    'refund_id' => $refund->id,
                    'status' => $refund->status,
                ],
            ];
            
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
```

## Controllers

### Payment Controller Features
```php
class PaymentController extends Controller
{
    // Admin operations
    public function index()           // Payment listing with filters
    public function indexJson()       // AJAX data for DataTables
    public function show()            // Payment details with transactions
    
    // Payment processing
    public function processPayment()  // Process new payment
    public function processRefund()   // Process refund
    public function capturePayment()  // Capture authorized payment
    
    // Gateway operations
    public function webhookHandler()  // Handle gateway webhooks
    public function reconcilePayments() // Reconcile with gateway
    
    // Reports
    public function transactionReport() // Transaction analytics
    public function reconciliationReport() // Reconciliation status
}
```

## Admin Interface

### Payments Management
```php
// DataTables columns
- Payment Reference (PY-2024-001234)
- Booking Reference (BK-2024-001234)
- Customer Name
- Amount ($299.99 USD)
- Payment Method (Visa **** 4242)
- Gateway (Stripe)
- Status Badge (Completed/Failed/Pending)
- Processing Date (Dec 1, 2024 14:30)
- Net Amount ($285.32)
- Actions (View, Refund, Reconcile)

// Advanced filters
- Date range (processed, initiated)
- Status filter
- Gateway filter
- Currency filter
- Amount range
- Payment method
- Customer search
```

### Payment Details View
```php
// Comprehensive payment information
- Payment reference and gateway details
- Booking information and customer
- Amount breakdown (fees, taxes, net)
- Payment method details (masked card info)
- Processing timeline
- Gateway response data
- Transaction history (refunds, adjustments)
- Reconciliation status
- Related documents
```

### Transaction History
```php
// All related transactions
- Transaction reference
- Type (Refund/Adjustment/Fee)
- Amount and currency
- Status and processing date
- Reason and notes
- Gateway response
- Initiated by (admin/customer/system)
```

## API Endpoints

### Payments API
```php
GET    /api/payments              // List payments (admin)
GET    /api/payments/{id}         // Get payment details
POST   /api/payments              // Process payment
POST   /api/payments/{id}/refund  // Process refund
POST   /api/payments/{id}/capture // Capture authorized payment

// Gateway operations
POST   /api/payments/webhook/{gateway} // Webhook handler
POST   /api/payments/reconcile    // Reconcile payments

// Customer payments
GET    /api/bookings/{id}/payments // Booking payments
```

### Gateways API
```php
GET    /api/payment-gateways      // List available gateways
GET    /api/payment-gateways/{id} // Gateway details
POST   /api/payment-gateways      // Create gateway (admin)
PUT    /api/payment-gateways/{id} // Update gateway (admin)
```

## Performance Considerations

### Database Indexing
```sql
-- Payment search optimization
CREATE INDEX idx_payments_booking_status ON payments(booking_id, status);
CREATE INDEX idx_payments_gateway_processed ON payments(payment_gateway_id, processed_at);
CREATE INDEX idx_payments_amount_currency ON payments(amount, currency);
CREATE INDEX idx_transactions_payment_type ON transactions(payment_id, type);
CREATE INDEX idx_gateways_active_priority ON payment_gateways(is_active, priority);
```

### Security Considerations
```php
// Encrypt sensitive data
protected $casts = [
    'credentials' => 'encrypted:array',
    'configuration' => 'encrypted:array',
];

// Validate webhook signatures
public function validateWebhook(Request $request, PaymentGateway $gateway): bool
{
    $signature = $request->header('Stripe-Signature');
    $payload = $request->getContent();
    
    return hash_equals(
        hash_hmac('sha256', $payload, $gateway->credentials['webhook_secret']),
        $signature
    );
}
```

## Sample Data Seeding

### Payment Gateways
```php
$gateways = [
    [
        'name' => 'Stripe',
        'slug' => 'stripe',
        'provider' => 'stripe',
        'supported_currencies' => ['USD', 'EUR', 'GBP', 'BDT'],
        'percentage_fee' => 0.029, // 2.9%
        'fixed_fee' => 0.30,
        'is_active' => true,
        'is_default' => true,
    ],
    [
        'name' => 'PayPal',
        'slug' => 'paypal',
        'provider' => 'paypal',
        'supported_currencies' => ['USD', 'EUR', 'GBP'],
        'percentage_fee' => 0.034, // 3.4%
        'fixed_fee' => 0.30,
        'is_active' => true,
    ],
];
```

### Sample Payments
```php
$payments = [
    [
        'booking_id' => 1,
        'payment_gateway_id' => 1,
        'payment_reference' => 'PY-2024-000001',
        'amount' => 1299.99,
        'currency' => 'USD',
        'payment_method' => 'credit_card',
        'status' => 'completed',
        'processed_at' => now()->subDays(5),
    ],
];
```

## Integration with Other Modules

### Booking Module Integration
```php
// Payments belong to bookings
class Payment extends Model
{
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}

// Bookings have multiple payments
class Booking extends Model
{
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->completed()->sum('amount');
    }
}
```

## Validation Rules

### Payment Validation
```php
'booking_id' => 'required|exists:bookings,id',
'payment_gateway_id' => 'required|exists:payment_gateways,id',
'amount' => 'required|numeric|min:0.01',
'currency' => 'required|string|size:3',
'payment_method' => 'required|in:credit_card,debit_card,bank_transfer,digital_wallet',
'payment_method_id' => 'required_if:payment_method,credit_card,debit_card',
```

### Gateway Validation
```php
'name' => 'required|string|max:100',
'provider' => 'required|in:stripe,paypal,square',
'supported_currencies' => 'required|array',
'supported_currencies.*' => 'string|size:3',
'percentage_fee' => 'required|numeric|between:0,1',
'fixed_fee' => 'required|numeric|min:0',
'min_amount' => 'required|numeric|min:0',
'max_amount' => 'required|numeric|gt:min_amount',
```

## Next Steps

- **[Database Schema](./08-database-schema.md)** - Complete database structure
- **[API Documentation](./09-api-documentation.md)** - REST API endpoints
- **[Admin Interface](./10-admin-interface.md)** - Backend management features

---

**Related Documentation:**
- [Booking Module](./06-booking-module.md)
- [Architecture Overview](./01-architecture-overview.md)
- [Admin Interface](./10-admin-interface.md)