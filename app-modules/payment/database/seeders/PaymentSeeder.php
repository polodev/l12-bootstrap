<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CustomPaymentSeeder::class,
        ]);
    }
}

class CustomPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(20)->get();
        
        // Create custom payments (frontend form submissions) directly as payments with payment_type = 'custom_payment'
        foreach ($users as $user) {
            // 30% chance of having custom payments
            if (rand(1, 100) <= 30) {
                $numPayments = rand(1, 3);
                
                for ($i = 0; $i < $numPayments; $i++) {
                    $amount = rand(1000, 25000);
                    $status = ['pending', 'processing', 'completed', 'cancelled'][array_rand(['pending', 'processing', 'completed', 'cancelled'])];
                    $submittedAt = Carbon::now()->subDays(rand(1, 60));
                    $paymentMethod = $this->getRandomPaymentMethod();
                    
                    Payment::create([
                        'payment_type' => 'custom_payment',
                        'created_by' => $users->random()->id, // Admin who created the payment record
                        'amount' => $amount,
                        'status' => $status,
                        'payment_method' => $paymentMethod,
                        'name' => $user->name,
                        'email_address' => $user->email,
                        'mobile' => $this->generatePhoneNumber(),
                        'purpose' => $this->getPaymentPurpose(),
                        'description' => $this->getPaymentDescription(),
                        'form_data' => $this->getFormData($user, $amount),
                        'ip_address' => $this->generateIPAddress(),
                        'user_agent' => $this->generateUserAgent(),
                        'transaction_id' => $status === 'completed' ? 'CUP-' . strtoupper(uniqid()) : null,
                        'gateway_payment_id' => $status === 'completed' ? 'GPW-' . rand(100000, 999999) : null,
                        'gateway_response' => $status === 'completed' ? $this->getGatewayResponse() : null,
                        'gateway_reference' => $status === 'completed' ? 'REF-' . rand(100000, 999999) : null,
                        'payment_date' => $status === 'completed' ? $submittedAt : null,
                        'processed_at' => in_array($status, ['completed', 'failed']) ? $submittedAt->copy()->addMinutes(rand(5, 120)) : null,
                        'failed_at' => $status === 'failed' ? $submittedAt->copy()->addMinutes(rand(5, 30)) : null,
                        'notes' => $this->getAdminNotes($status),
                        'receipt_number' => $status === 'completed' ? 'CUP-' . date('Ymd') . '-' . rand(1000, 9999) : null,
                        'payment_details' => $this->getPaymentDetails($paymentMethod),
                        'processed_by' => in_array($status, ['processing', 'completed']) ? $users->random()->id : null,
                        'created_at' => $submittedAt,
                        'updated_at' => $submittedAt,
                    ]);
                }
            }
        }
    }
    
    private function generatePhoneNumber(): string
    {
        $codes = ['+880-17', '+880-19', '+880-16', '+880-18', '+880-15'];
        return $codes[array_rand($codes)] . rand(10000000, 99999999);
    }
    
    private function getPaymentPurpose(): string
    {
        $purposes = [
            'Tour booking payment',
            'Flight ticket payment',
            'Hotel reservation payment',
            'Service payment',
            'Package booking payment',
            'Additional services',
            'Visa processing fee',
            'Travel insurance'
        ];
        return $purposes[array_rand($purposes)];
    }
    
    private function getPaymentDescription(): ?string
    {
        $descriptions = [
            'Payment for Cox\'s Bazar tour package',
            'Flight booking for Dhaka to Bangkok',
            'Hotel reservation at Sea Palace',
            'Visa processing and documentation',
            'Travel insurance and additional services',
            null, null // Some payments without description
        ];
        return $descriptions[array_rand($descriptions)];
    }
    
    private function getRandomPaymentMethod(): string
    {
        $methods = ['sslcommerz', 'bkash', 'nagad', 'city_bank', 'brac_bank', 'bank_transfer', 'cash', 'other'];
        return $methods[array_rand($methods)];
    }
    
    private function getFormData($user, $amount): array
    {
        return [
            'name' => $user->name,
            'email_address' => $user->email,
            'amount' => $amount,
            'currency' => 'BDT',
            'form_type' => 'custom_payment',
            'browser_info' => [
                'user_agent' => $this->generateUserAgent(),
                'language' => 'en-US',
                'screen_resolution' => '1920x1080'
            ]
        ];
    }
    
    private function generateIPAddress(): string
    {
        return rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255);
    }
    
    private function generateUserAgent(): string
    {
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1'
        ];
        return $agents[array_rand($agents)];
    }
    
    private function getAdminNotes(?string $status): ?string
    {
        switch ($status) {
            case 'processing':
                return 'Payment verification in progress';
            case 'completed':
                return 'Payment completed successfully';
            case 'cancelled':
                return 'Payment cancelled by customer request';
            default:
                return null;
        }
    }
    
    private function getGatewayResponse(): array
    {
        return [
            'status' => 'success',
            'transaction_id' => 'CUP-' . strtoupper(uniqid()),
            'amount' => rand(1000, 25000),
            'currency' => 'BDT',
            'gateway_fee' => rand(50, 200),
            'response_code' => '00',
            'response_message' => 'Transaction successful'
        ];
    }
    
    private function getPaymentDetails(string $method): ?array
    {
        switch ($method) {
            case 'bkash':
                return [
                    'sender_number' => '+880-17' . rand(10000000, 99999999),
                    'transaction_type' => 'send_money'
                ];
            case 'nagad':
                return [
                    'sender_number' => '+880-19' . rand(10000000, 99999999),
                    'transaction_type' => 'send_money'
                ];
            case 'bank_transfer':
                return [
                    'bank_name' => 'Dutch Bangla Bank',
                    'account_number' => 'DBL-' . rand(1000000, 9999999)
                ];
            default:
                return null;
        }
    }
}

