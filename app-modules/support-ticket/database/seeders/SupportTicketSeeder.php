<?php

namespace Modules\SupportTicket\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\SupportTicket\Models\SupportTicket;
use Modules\SupportTicket\Models\SupportTicketMessage;
use App\Models\User;
use Carbon\Carbon;

class SupportTicketSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for testing
        $admins = User::whereNotNull('role')->get();
        $customers = User::whereNull('role')->get();
        
        // If no customers exist, create some test customers
        if ($customers->isEmpty()) {
            $this->command->info('Creating test customer users...');
            for ($i = 1; $i <= 3; $i++) {
                $customers->push(User::create([
                    'name' => "Test Customer $i",
                    'email' => "customer$i@example.com",
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'password_set' => true,
                ]));
            }
            $customers = $customers->fresh();
        }

        if ($admins->isEmpty()) {
            $this->command->warn('No admin users found. Support ticket assignments may not work properly.');
        } else {
            $this->command->info('Found admin users: ' . $admins->pluck('name')->join(', '));
        }
        
        $this->command->info('Found customer users: ' . $customers->pluck('name')->join(', '));

        $this->command->info('Creating sample support tickets...');

        // Sample ticket data
        $sampleTickets = [
            [
                'title' => 'Cannot login to my account',
                'description' => "I've been trying to log into my account for the past hour but keep getting an 'Invalid credentials' error. I'm sure I'm using the correct email and password. Could you please help me reset my password or check if there's an issue with my account?

Steps I've tried:
1. Cleared browser cache and cookies
2. Tried different browsers (Chrome, Firefox)
3. Checked if Caps Lock was on
4. Tried password reset but didn't receive email

My email: {$customers->first()->email}
Browser: Chrome 120.0
Device: MacBook Pro",
                'category' => 'account',
                'priority' => 'high',
                'status' => 'open'
            ],
            [
                'title' => 'Payment failed but money was deducted',
                'description' => "I tried to make a payment yesterday for order #12345, but the payment failed on the website. However, the money has been deducted from my bank account. Can you please check and either process my order or refund the amount?

Transaction details:
- Amount: $99.99
- Date: " . now()->subDay()->format('Y-m-d H:i') . "
- Bank: Chase Bank
- Last 4 digits of card: 1234
- Transaction reference from bank: TXN123456789

I have screenshots of both the failed payment page and my bank statement if needed.",
                'category' => 'billing',
                'priority' => 'urgent',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Feature request: Dark mode for mobile app',
                'description' => "I love using your app, but I would really appreciate having a dark mode option, especially for nighttime use. Many users in the community have been asking for this feature.

Benefits of dark mode:
- Reduces eye strain in low light
- Saves battery on OLED screens
- Looks more modern
- Popular trend in mobile apps

I've seen similar implementations in apps like Twitter, Instagram, and WhatsApp. Would it be possible to add this to your roadmap?

Thanks for considering this request!",
                'category' => 'feature_request',
                'priority' => 'low',
                'status' => 'new'
            ],
            [
                'title' => 'Bug: Shopping cart items disappear on page refresh',
                'description' => "I've found a bug in the shopping cart functionality. When I add items to my cart and then refresh the page or navigate away and come back, all items disappear from the cart.

How to reproduce:
1. Add any product to cart
2. Navigate to cart page (items are there)
3. Refresh the page
4. Cart becomes empty

Browser: Firefox 119.0
OS: Windows 11
Cookies: Enabled
Local Storage: Enabled

This is quite frustrating as I have to re-add items every time. Please fix this issue.

Screenshots attached would show the before/after state.",
                'category' => 'bug_report',
                'priority' => 'high',
                'status' => 'resolved'
            ],
            [
                'title' => 'How to update my delivery address?',
                'description' => "I recently moved to a new apartment and need to update my delivery address for future orders. I've looked through the account settings but can't find where to edit the address.

Could you please guide me through the steps to:
1. Update my default delivery address
2. Add a secondary address for office delivery
3. Set address preferences for different order types

Current address: 123 Old Street, City A
New address: 456 New Avenue, City B

Any help would be appreciated. Thank you!",
                'category' => 'general',
                'priority' => 'normal',
                'status' => 'closed'
            ],
            [
                'title' => 'Website performance issues during peak hours',
                'description' => "I've noticed that the website becomes very slow during peak hours (typically 7-9 PM). Pages take 30+ seconds to load, and sometimes I get timeout errors.

Performance issues observed:
- Homepage takes 35-40 seconds to load
- Product pages timeout frequently
- Cart operations fail with 504 errors
- Search functionality becomes unresponsive

This seems to happen consistently between 7-9 PM EST. During other times, the website works perfectly fine.

Could you please investigate and optimize the website for high traffic periods?",
                'category' => 'technical',
                'priority' => 'high',
                'status' => 'in_progress'
            ],
            [
                'title' => 'Unable to download purchase receipt',
                'description' => "I purchased a premium plan last week but I'm unable to download the receipt for my company's expense reporting.

Order details:
- Order ID: #ORD789123
- Purchase date: " . now()->subWeek()->format('Y-m-d') . "
- Amount: $299.99
- Payment method: Credit card ending in 5678

When I click the 'Download Receipt' button in my account, nothing happens. I've tried:
- Different browsers
- Disabling ad blockers
- Clearing cache

I need this receipt for tax purposes. Could you please email me the receipt or fix the download functionality?",
                'category' => 'billing',
                'priority' => 'normal',
                'status' => 'open'
            ],
            [
                'title' => 'Integration with Google Calendar',
                'description' => "Is it possible to integrate your booking system with Google Calendar? I run a small business and use Google Calendar extensively for scheduling.

Features I'd like to see:
- Two-way sync between your platform and Google Calendar
- Automatic blocking of booked time slots
- Notifications for new bookings
- Ability to modify bookings from either platform

This would greatly improve my workflow and help avoid double bookings. Do you have any plans to implement this integration?

If there's a third-party solution or API I can use, please let me know the documentation links.",
                'category' => 'feature_request',
                'priority' => 'normal',
                'status' => 'new'
            ]
        ];

        // Create tickets
        foreach ($sampleTickets as $index => $ticketData) {
            $customer = $customers->random();
            $admin = $admins->isNotEmpty() ? $admins->random() : null;

            $ticket = SupportTicket::create([
                'user_id' => $customer->id,
                'assigned_to' => in_array($ticketData['status'], ['in_progress', 'resolved']) && $admin ? $admin->id : null,
                'title' => $ticketData['title'],
                'description' => $ticketData['description'],
                'category' => $ticketData['category'],
                'priority' => $ticketData['priority'],
                'status' => $ticketData['status'],
                'closed_at' => in_array($ticketData['status'], ['resolved', 'closed']) ? now()->subDays(rand(1, 7)) : null,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5))
            ]);

            // Create initial message from customer
            SupportTicketMessage::create([
                'support_ticket_id' => $ticket->id,
                'user_id' => $customer->id,
                'message' => $this->getInitialMessage($ticketData['category']),
                'is_internal' => false,
                'created_at' => $ticket->created_at,
                'updated_at' => $ticket->created_at
            ]);

            // Add replies based on ticket status
            $this->addReplies($ticket, $customer, $admin);

            $this->command->info("Created ticket #{$ticket->id}: {$ticket->title}");
        }

        $this->command->info('Support ticket seeding completed!');
        $this->command->info('Summary:');
        $this->command->info('- Total tickets: ' . SupportTicket::count());
        $this->command->info('- Total messages: ' . SupportTicketMessage::count());
        $this->command->table(
            ['Status', 'Count'],
            collect(['new', 'open', 'in_progress', 'resolved', 'closed'])
                ->map(fn($status) => [$status, SupportTicket::where('status', $status)->count()])
                ->toArray()
        );
    }

    /**
     * Get initial customer message based on category
     */
    private function getInitialMessage(string $category): string
    {
        $messages = [
            'account' => "Hi, I'm having trouble accessing my account. I've tried multiple times but can't seem to log in. Can someone please help me with this issue?",
            'billing' => "Hello, I have a question about my recent billing. There seems to be a discrepancy that I'd like to get resolved. Could someone from the billing team please look into this?",
            'technical' => "Hi Support Team, I'm experiencing some technical difficulties with your platform. The issue is affecting my daily workflow and I need assistance to resolve it.",
            'bug_report' => "Hello, I think I found a bug in your system. It's reproducible and affecting the user experience. Please investigate this issue.",
            'feature_request' => "Hi there, I have a suggestion for a new feature that would be really helpful for users like me. Would love to discuss this with your product team.",
            'general' => "Hello, I have a general question about your service. I couldn't find the answer in your FAQ, so I'm reaching out for assistance."
        ];

        return $messages[$category] ?? $messages['general'];
    }

    /**
     * Add realistic conversation replies to tickets
     */
    private function addReplies(SupportTicket $ticket, User $customer, ?User $admin): void
    {
        if (!$admin) {
            return;
        }

        $replyScenarios = [
            'new' => [], // No replies yet
            'open' => [
                [
                    'user' => $admin,
                    'message' => "Thank you for contacting our support team. I've received your ticket and I'm looking into this issue. I'll get back to you within 24 hours with more information.",
                    'internal' => false,
                    'delay_hours' => 2
                ]
            ],
            'in_progress' => [
                [
                    'user' => $admin,
                    'message' => "Thank you for contacting us. I've received your ticket and I'm investigating this issue. Let me gather some more information.",
                    'internal' => false,
                    'delay_hours' => 1
                ],
                [
                    'user' => $admin,
                    'message' => "Customer seems to have a legitimate issue. Need to check with the technical team about this. Priority: {$ticket->priority}",
                    'internal' => true,
                    'delay_hours' => 3
                ],
                [
                    'user' => $customer,
                    'message' => "Hi, just following up on this issue. It's still affecting me and I'd appreciate an update on the progress. Thanks!",
                    'internal' => false,
                    'delay_hours' => 24
                ],
                [
                    'user' => $admin,
                    'message' => "I've identified the root cause of the issue and I'm working on a solution. I'll have this resolved for you shortly. Thank you for your patience.",
                    'internal' => false,
                    'delay_hours' => 26
                ]
            ],
            'resolved' => [
                [
                    'user' => $admin,
                    'message' => "Thank you for reporting this issue. I've investigated and found the root cause.",
                    'internal' => false,
                    'delay_hours' => 2
                ],
                [
                    'user' => $admin,
                    'message' => "This issue has been resolved. The fix has been deployed and should be working now. Please try again and let me know if you continue to experience any problems.",
                    'internal' => false,
                    'delay_hours' => 6
                ],
                [
                    'user' => $customer,
                    'message' => "Perfect! The issue has been resolved and everything is working as expected now. Thank you for the quick response and excellent support!",
                    'internal' => false,
                    'delay_hours' => 8
                ]
            ],
            'closed' => [
                [
                    'user' => $admin,
                    'message' => "Thank you for your inquiry. I've reviewed your request and here's the information you need.",
                    'internal' => false,
                    'delay_hours' => 4
                ],
                [
                    'user' => $admin,
                    'message' => $this->getResolutionMessage($ticket->category),
                    'internal' => false,
                    'delay_hours' => 6
                ],
                [
                    'user' => $customer,
                    'message' => "Thank you so much! This answers all my questions. Great support!",
                    'internal' => false,
                    'delay_hours' => 8
                ]
            ]
        ];

        $replies = $replyScenarios[$ticket->status] ?? [];

        foreach ($replies as $reply) {
            SupportTicketMessage::create([
                'support_ticket_id' => $ticket->id,
                'user_id' => $reply['user']->id,
                'message' => $reply['message'],
                'is_internal' => $reply['internal'],
                'created_at' => $ticket->created_at->addHours($reply['delay_hours']),
                'updated_at' => $ticket->created_at->addHours($reply['delay_hours'])
            ]);
        }
    }

    /**
     * Get resolution message based on category
     */
    private function getResolutionMessage(string $category): string
    {
        $messages = [
            'account' => "I've reset your password and sent you a new temporary password via email. Please log in and change it to something secure. Your account is now accessible.",
            'billing' => "I've reviewed your billing and processed the refund. The amount will be credited back to your original payment method within 3-5 business days. You should receive a confirmation email shortly.",
            'technical' => "The technical issue has been resolved. Our development team deployed a fix that addresses the performance problems you experienced. Everything should be working smoothly now.",
            'bug_report' => "Thank you for reporting this bug! Our development team has fixed the issue and deployed the solution. The bug has been resolved and won't occur again.",
            'feature_request' => "Thank you for your feature suggestion! I've forwarded it to our product team for consideration. While I can't guarantee implementation, your feedback is valuable for our roadmap planning.",
            'general' => "I hope this information helps answer your question. If you need any clarification or have additional questions, please don't hesitate to reach out to us."
        ];

        return $messages[$category] ?? $messages['general'] . "\n\nI'm marking this ticket as resolved. If you have any other questions, please feel free to create a new support ticket.";
    }
}