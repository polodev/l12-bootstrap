# Payment Module

## Auto-Payment Creation Feature

When creating custom payments, the system can automatically create a corresponding payment record to reduce operator workload.

### Configuration

Add to your `.env` file:

```env
# Auto-create payment records for custom payments (true/false)
PAYMENT_AUTO_CREATE=true
```

### How it works

1. When a custom payment is created, if `PAYMENT_AUTO_CREATE=true`:
   - A payment record is automatically created
   - Amount: Same as the custom payment amount
   - Payment Method: SSL Commerce (sslcommerz)
   - Status: Pending
   - Notes: "Auto-created payment record for custom payment processing"

2. Operators can then:
   - Modify the payment amount if needed
   - Change the payment method
   - Update the status (pending → completed)
   - Add transaction IDs and other details

### Toggle the feature

To disable auto-payment creation:

```env
PAYMENT_AUTO_CREATE=false
```

Or modify the config file after publishing:

```bash
php artisan vendor:publish --tag=payment-config
```

Then edit `config/payment.php`:

```php
'auto_create_payment' => false,
```

### Benefits

- **Reduces operator workload**: Every custom payment typically needs at least one payment record
- **Consistent workflow**: Ensures all custom payments have payment tracking
- **Easily toggleable**: Can be disabled via environment variable
- **Operator friendly**: Pre-populates with sensible defaults that can be modified