# AWS SES Email Setup Tutorial

This comprehensive guide walks you through setting up AWS SES (Simple Email Service) for Laravel email functionality including registration messages, notifications, and transactional emails.

## 📋 Overview

AWS SES is a cloud-based email service that provides a cost-effective way to send and receive emails. This tutorial will help you:

- Set up AWS SES with proper IAM permissions
- Configure Laravel to use SES as the email driver
- Create email notifications for user registration
- Implement email templates with localization support
- Test and troubleshoot email delivery
- Handle bounce and complaint notifications

**Current Laravel Setup Compatible:**
- ✅ AWS SDK already installed
- ✅ Multi-language support (English/Bengali)
- ✅ User model with Notifiable trait
- ✅ Queue system configured
- ✅ Existing AWS credentials for S3

## 🚀 Step 1: AWS SES Initial Setup

### Prerequisites
- AWS account with console access
- Existing IAM user or ability to create one
- Domain ownership (for production) or valid email address (for testing)

### 1.1 Navigate to AWS SES

1. **Sign in to AWS Console**: https://console.aws.amazon.com/
2. **Navigate to SES**: Search for "SES" or "Simple Email Service"
3. **Select Region**: Choose your preferred region (e.g., `us-east-1`, `eu-west-1`)
   - **Note**: SES is only available in specific regions
   - **Recommendation**: Use `us-east-1` for best feature availability

### 1.2 Verify Your Email Address (Sandbox Mode)

1. **In SES Console**, click "Verified identities" in the left menu
2. **Click "Create identity"**
3. **Select "Email address"**
4. **Enter your email**: Use a valid email you can access
5. **Click "Create identity"**
6. **Check your email** for verification message
7. **Click the verification link** in the email

## 🔐 Step 2: Create IAM Policy for SES

### 2.1 Create SES IAM Policy

1. **Navigate to IAM**: Search for "IAM" in AWS Console
2. **Go to "Policies"** → "Create policy"
3. **Click "JSON" tab**
4. **Paste the following policy**:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "SESv2SendingAccess",
            "Effect": "Allow",
            "Action": [
                "ses:SendEmail",
                "ses:SendRawEmail",
                "ses:SendBulkTemplatedEmail",
                "ses:SendTemplatedEmail"
            ],
            "Resource": "*"
        },
        {
            "Sid": "SESv2ConfigurationAccess",
            "Effect": "Allow",
            "Action": [
                "ses:GetSendQuota",
                "ses:GetSendStatistics",
                "ses:GetAccountSendingEnabled",
                "ses:DescribeMessageEvents",
                "ses:DescribeConfigurationSet",
                "ses:ListVerifiedEmailAddresses",
                "ses:ListIdentities",
                "ses:GetIdentityVerificationAttributes",
                "ses:GetIdentityDkimAttributes"
            ],
            "Resource": "*"
        }
    ]
}
```

5. **Name the Policy**: `Laravel-SES-Email-Policy`
6. **Add Description**: "Policy for Laravel SES email integration"
7. **Click "Create policy"**

### 2.2 Attach Policy to User

**Option A: Use Existing IAM User**
1. **Navigate to your existing IAM user** (if you have one from S3 setup)
2. **Go to "Permissions" tab**
3. **Click "Add permissions"** → "Attach policies directly"
4. **Search and select** `Laravel-SES-Email-Policy`
5. **Click "Add permissions"**

**Option B: Create New IAM User**
1. **Go to "Users"** → "Create user"
2. **Username**: `laravel-ses-user`
3. **Select "Programmatic access"**
4. **Click "Next"**
5. **Attach policy**: `Laravel-SES-Email-Policy`
6. **Click "Create user"**
7. **Save the Access Key ID and Secret Access Key**

## 📧 Step 3: Configure SES Settings

### 3.1 Set Up Configuration Set (Optional but Recommended)

1. **In SES Console**, go to "Configuration sets"
2. **Click "Create configuration set"**
3. **Name**: `laravel-emails`
4. **Click "Create configuration set"**

### 3.2 Configure Bounce and Complaint Handling

1. **In your configuration set**, go to "Event destinations"
2. **Click "Add destination"**
3. **Select "SNS"** (Simple Notification Service)
4. **Configure for "Bounce" and "Complaint" events**
5. **Create SNS topics** for monitoring (optional for development)

### 3.3 Request Production Access (When Ready)

**Note**: By default, SES starts in "Sandbox" mode with limitations:
- Can only send emails to verified addresses
- Limited to 200 emails per day
- Maximum 1 email per second

To remove these limitations:
1. **Go to "Account dashboard"** in SES
2. **Click "Request production access"**
3. **Fill out the form** with:
   - **Use case description**: "Transactional emails for Laravel web application"
   - **Website URL**: Your application URL
   - **Email types**: Transactional
   - **Expected volume**: Your estimated daily email volume
4. **Submit request** (approval typically takes 24-48 hours)

## ⚙️ Step 4: Update Laravel Configuration

### 4.1 Update Environment Variables

Add the following to your `.env` file:

```env
# Email Configuration
MAIL_MAILER=ses
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"

# AWS SES Configuration
AWS_ACCESS_KEY_ID=your_access_key_id
AWS_SECRET_ACCESS_KEY=your_secret_access_key
AWS_DEFAULT_REGION=us-east-1
SES_REGION=us-east-1
SES_CONFIGURATION_SET=laravel-emails
```

**Important Notes:**
- Replace `your_access_key_id` and `your_secret_access_key` with your actual credentials
- Update `noreply@yourdomain.com` with your verified email address
- If you created a new IAM user, use those credentials
- If using existing S3 credentials, ensure SES policy is attached

### 4.2 Update Mail Configuration

Verify your `config/mail.php` has the SES configuration:

```php
'ses' => [
    'transport' => 'ses',
],
```

### 4.3 Update Services Configuration

Add SES configuration to `config/services.php`:

```php
'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('SES_REGION', env('AWS_DEFAULT_REGION', 'us-east-1')),
    'configuration_set' => env('SES_CONFIGURATION_SET'),
],
```

## 📨 Step 5: Create Email Notification Classes

### 5.1 Create Welcome Email Notification

```bash
php artisan make:notification WelcomeNotification
```

Update `app/Notifications/WelcomeNotification.php`:

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;
    private $locale;

    public function __construct($user, $locale = null)
    {
        $this->user = $user;
        $this->locale = $locale ?? App::getLocale();
        
        // Set queue for better performance
        $this->onQueue('emails');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Set locale for this notification
        $previousLocale = App::getLocale();
        App::setLocale($this->locale);

        $message = (new MailMessage)
            ->subject(__('messages.welcome_subject'))
            ->greeting(__('messages.welcome_greeting', ['name' => $this->user->name]))
            ->line(__('messages.welcome_message'))
            ->line(__('messages.welcome_getting_started'))
            ->action(__('messages.welcome_action'), url('/dashboard'))
            ->line(__('messages.welcome_thank_you'))
            ->salutation(__('messages.welcome_salutation', ['app_name' => config('app.name')]));

        // Set custom view if needed
        $message->view('emails.welcome', [
            'user' => $this->user,
            'locale' => $this->locale
        ]);

        // Restore previous locale
        App::setLocale($previousLocale);

        return $message;
    }

    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'locale' => $this->locale,
        ];
    }
}
```

### 5.2 Create Email Templates

Create email view directory:
```bash
mkdir -p resources/views/emails
```

Create `resources/views/emails/welcome.blade.php`:

```blade
@component('mail::message')
# {{ __('messages.welcome_subject') }}

{{ __('messages.welcome_greeting', ['name' => $user->name]) }}

{{ __('messages.welcome_message') }}

{{ __('messages.welcome_getting_started') }}

@component('mail::button', ['url' => url('/dashboard')])
{{ __('messages.welcome_action') }}
@endcomponent

{{ __('messages.welcome_thank_you') }}

{{ __('messages.welcome_salutation', ['app_name' => config('app.name')]) }}
@endcomponent
```

### 5.3 Add Email Translations

Update `resources/lang/en/messages.php`:

```php
// Add these to your existing messages array
'welcome_subject' => 'Welcome to :app_name',
'welcome_greeting' => 'Hello :name!',
'welcome_message' => 'Thank you for creating an account with us. We\'re excited to have you on board!',
'welcome_getting_started' => 'To get started, please click the button below to access your dashboard.',
'welcome_action' => 'Go to Dashboard',
'welcome_thank_you' => 'Thank you for using our application!',
'welcome_salutation' => 'Best regards,<br>The :app_name Team',
```

Update `resources/lang/bn/messages.php`:

```php
// Add these to your existing messages array
'welcome_subject' => ':app_name এ স্বাগতম',
'welcome_greeting' => 'হ্যালো :name!',
'welcome_message' => 'আমাদের সাথে অ্যাকাউন্ট তৈরি করার জন্য ধন্যবাদ। আপনাকে আমাদের সাথে পেয়ে আমরা উত্সাহিত!',
'welcome_getting_started' => 'শুরু করতে, আপনার ড্যাশবোর্ড অ্যাক্সেস করতে নিচের বোতামে ক্লিক করুন।',
'welcome_action' => 'ড্যাশবোর্ডে যান',
'welcome_thank_you' => 'আমাদের অ্যাপ্লিকেশন ব্যবহার করার জন্য ধন্যবাদ!',
'welcome_salutation' => 'শুভেচ্ছা,<br>:app_name টিম',
```

## 🔌 Step 6: Integrate with User Registration

### 6.1 Update User Model

Your `User` model already has the `Notifiable` trait, so no changes needed. However, you can add a helper method:

```php
// Add this method to your User model
public function sendWelcomeNotification($locale = null)
{
    $this->notify(new \App\Notifications\WelcomeNotification($this, $locale));
}
```

### 6.2 Update Registration Logic

If you're using Laravel's built-in registration, update your registration controller or listener:

**Option A: Event Listener Approach**

Create an event listener:
```bash
php artisan make:listener SendWelcomeNotification --event="Illuminate\Auth\Events\Registered"
```

Update `app/Listeners/SendWelcomeNotification.php`:

```php
<?php

namespace App\Listeners;

use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;

class SendWelcomeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(Registered $event)
    {
        // Get current locale or determine from user preferences
        $locale = App::getLocale();
        
        // Send welcome notification
        $event->user->notify(new WelcomeNotification($event->user, $locale));
    }
}
```

Register the listener in `app/Providers/EventServiceProvider.php`:

```php
protected $listen = [
    \Illuminate\Auth\Events\Registered::class => [
        \App\Listeners\SendWelcomeNotification::class,
    ],
];
```

**Option B: Direct Integration**

If you have a custom registration method, add this after user creation:

```php
// After user is created and saved
$user->sendWelcomeNotification($locale);

// Or directly:
$user->notify(new WelcomeNotification($user, $locale));
```

## 🧪 Step 7: Testing Email Functionality

### 7.1 Create Test Route

Add a test route to `routes/web.php`:

```php
use App\Models\User;
use App\Notifications\WelcomeNotification;

Route::get('/test-email', function () {
    $user = User::first();
    
    if (!$user) {
        return 'No user found. Please create a user first.';
    }
    
    try {
        $user->notify(new WelcomeNotification($user, 'en'));
        return 'Email sent successfully to ' . $user->email;
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
})->name('test.email');
```

### 7.2 Test Email Sending

1. **Visit the test route**: http://l12-bootstrap.test/test-email
2. **Check the response** for success/error messages
3. **Check your email** for the welcome message
4. **Check Laravel logs** (`storage/logs/laravel.log`) for any errors

### 7.3 Test Queue Processing

If using queues (recommended):

```bash
# Start queue worker
php artisan queue:work

# Or run a single job
php artisan queue:work --once
```

### 7.4 Test with Different Locales

Create locale-specific test routes:

```php
Route::get('/test-email-en', function () {
    $user = User::first();
    $user->notify(new WelcomeNotification($user, 'en'));
    return 'English email sent to ' . $user->email;
});

Route::get('/test-email-bn', function () {
    $user = User::first();
    $user->notify(new WelcomeNotification($user, 'bn'));
    return 'Bengali email sent to ' . $user->email;
});
```

## 📊 Step 8: Monitor and Debug

### 8.1 Check SES Sending Statistics

1. **In AWS SES Console**, go to "Reputation metrics"
2. **View sending statistics**: Deliveries, bounces, complaints
3. **Monitor quotas**: Daily sending quota and sending rate

### 8.2 Debug Email Issues

**Common Debug Commands:**

```bash
# Check mail configuration
php artisan config:show mail

# Check services configuration
php artisan config:show services

# Test mail configuration
php artisan tinker
```

**In Tinker:**
```php
// Test basic email sending
Mail::raw('Test email', function ($message) {
    $message->to('your-email@example.com')->subject('Test');
});

// Test SES connection
use Aws\Ses\SesClient;
$client = new SesClient([
    'version' => 'latest',
    'region' => 'us-east-1',
    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ],
]);

// Check sending quota
$result = $client->getSendQuota();
var_dump($result);
```

### 8.3 Enable Email Logging

For development, you can log emails instead of sending them:

```env
# In .env for development
MAIL_MAILER=log
```

Emails will be logged to `storage/logs/laravel.log`.

## 🚀 Step 9: Production Deployment

### 9.1 Environment-Specific Configuration

**Production `.env`:**
```env
MAIL_MAILER=ses
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Your App Name"
AWS_ACCESS_KEY_ID=your_production_access_key
AWS_SECRET_ACCESS_KEY=your_production_secret_key
AWS_DEFAULT_REGION=us-east-1
SES_REGION=us-east-1
SES_CONFIGURATION_SET=laravel-emails
```

**Staging `.env`:**
```env
MAIL_MAILER=ses
MAIL_FROM_ADDRESS="staging@yourdomain.com"
MAIL_FROM_NAME="Your App Name (Staging)"
# Use separate SES identity for staging
```

### 9.2 Domain Verification (Production)

For production, verify your domain instead of individual emails:

1. **In SES Console**, click "Create identity"
2. **Select "Domain"**
3. **Enter your domain**: `yourdomain.com`
4. **Add DNS records** provided by AWS to your domain
5. **Wait for verification** (can take up to 72 hours)

### 9.3 DKIM Setup

1. **In your domain identity**, go to "DKIM"
2. **Enable DKIM signing**
3. **Add DKIM DNS records** to your domain
4. **Verify DKIM status** shows "Verified"

## 🔒 Step 10: Security and Best Practices

### 10.1 Email Security

**SPF Record:**
Add to your domain's DNS:
```
v=spf1 include:amazonses.com ~all
```

**DMARC Record:**
Add to your domain's DNS:
```
v=DMARC1; p=quarantine; rua=mailto:dmarc@yourdomain.com
```

### 10.2 Rate Limiting

Implement rate limiting for email sending:

```php
// In your notification class
public function __construct($user, $locale = null)
{
    $this->user = $user;
    $this->locale = $locale ?? App::getLocale();
    
    // Delay emails to prevent rate limiting
    $this->delay(now()->addSeconds(rand(1, 10)));
}
```

### 10.3 Bounce and Complaint Handling

Create handlers for bounces and complaints:

```php
// Create notification for bounce handling
php artisan make:notification EmailBounceNotification

// Create handler for webhook
php artisan make:controller SESWebhookController
```

### 10.4 Environment Variables Security

**Never commit sensitive data:**
```gitignore
# Already in .gitignore
.env
.env.backup
.env.production
```

**Use encrypted environment files for production:**
```bash
# Encrypt sensitive environment variables
php artisan env:encrypt --env=production
```

## 📈 Step 11: Performance Optimization

### 11.1 Queue Configuration

Update `config/queue.php` for email queue:

```php
'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
    ],
    
    // Add dedicated email queue
    'emails' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'emails',
        'retry_after' => 90,
        'after_commit' => false,
    ],
],
```

### 11.2 Queue Worker Configuration

```bash
# Run dedicated email worker
php artisan queue:work --queue=emails --tries=3 --timeout=90

# Or use supervisor for production
sudo supervisorctl start laravel-worker:*
```

### 11.3 Email Template Optimization

**Use email-specific CSS:**
```blade
{{-- In your email template --}}
<style>
    .email-container {
        max-width: 600px;
        margin: 0 auto;
        font-family: Arial, sans-serif;
    }
    
    .email-header {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
    }
    
    .email-content {
        padding: 30px;
        line-height: 1.6;
    }
    
    .email-button {
        display: inline-block;
        padding: 12px 24px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        margin: 20px 0;
    }
</style>
```

## 🚨 Step 12: Troubleshooting

### 12.1 Common Issues

**"Email address not verified" Error:**
- Solution: Verify your sending email address in SES Console
- Check: Ensure `MAIL_FROM_ADDRESS` matches verified identity

**"Access Denied" Error:**
- Solution: Check IAM policy permissions
- Verify: AWS credentials are correct in `.env`

**"Throttling" Error:**
- Solution: Implement exponential backoff in queue
- Check: You're not exceeding SES sending limits

**"Configuration Set does not exist":**
- Solution: Remove `SES_CONFIGURATION_SET` from `.env` if not using
- Or: Create the configuration set in SES Console

### 12.2 Debug Commands

```bash
# Check SES configuration
php artisan tinker

# Test AWS credentials
use Aws\Credentials\Credentials;
$credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

# Test SES client
use Aws\Ses\SesClient;
$client = new SesClient([
    'version' => 'latest',
    'region' => env('SES_REGION'),
    'credentials' => $credentials,
]);

# Check verified identities
$result = $client->listIdentities();
print_r($result['Identities']);

# Check sending quota
$quota = $client->getSendQuota();
print_r($quota);
```

### 12.3 Email Delivery Testing

**Test email deliverability:**
```bash
# Use mail tester services
# Send test email to: check-auth@verifier.port25.com
# Send test email to: test@mail-tester.com
```

**Monitor email metrics:**
```php
// Add to your application
public function getEmailMetrics()
{
    $client = new SesClient([
        'version' => 'latest',
        'region' => env('SES_REGION'),
        'credentials' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
    ]);
    
    $stats = $client->getSendStatistics();
    return $stats['SendDataPoints'];
}
```

## 💰 Step 13: Cost Optimization

### 13.1 SES Pricing Overview

**AWS SES Pricing (US East 1):**
- First 62,000 emails/month: $0.10 per 1,000 emails
- Beyond 62,000 emails/month: $0.10 per 1,000 emails
- Data transfer: $0.12 per GB

### 13.2 Cost Monitoring

**Set up billing alerts:**
1. **Go to AWS Billing Console**
2. **Set up budget alerts** for SES usage
3. **Monitor monthly spending**

**Track email usage:**
```php
// Add to your admin dashboard
public function getEmailUsageStats()
{
    $client = new SesClient([
        'version' => 'latest',
        'region' => env('SES_REGION'),
        'credentials' => [
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
        ],
    ]);
    
    $quota = $client->getSendQuota();
    $stats = $client->getSendStatistics();
    
    return [
        'daily_quota' => $quota['Max24HourSend'],
        'remaining_quota' => $quota['Max24HourSend'] - $quota['SentLast24Hours'],
        'rate_limit' => $quota['MaxSendRate'],
        'recent_stats' => $stats['SendDataPoints'],
    ];
}
```

### 13.3 Optimize Email Sending

**Batch emails efficiently:**
```php
// Instead of sending one by one
foreach ($users as $user) {
    $user->notify(new WelcomeNotification($user));
}

// Use batch processing
$users->chunk(100, function ($userChunk) {
    foreach ($userChunk as $user) {
        $user->notify(new WelcomeNotification($user));
    }
    sleep(1); // Rate limiting
});
```

## 🎯 Step 14: Advanced Features

### 14.1 Email Templates

**Create reusable email templates:**
```bash
php artisan make:mail WelcomeMail --markdown=emails.welcome
```

**Use Markdown for cleaner templates:**
```blade
@component('mail::message')
# Welcome to {{ config('app.name') }}

Hello {{ $user->name }},

Thank you for joining us! We're excited to have you on board.

@component('mail::button', ['url' => $loginUrl])
Get Started
@endcomponent

If you have any questions, feel free to reach out.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
```

### 14.2 Email Personalization

**Dynamic content based on user:**
```php
public function toMail($notifiable)
{
    $message = (new MailMessage)
        ->subject('Welcome to ' . config('app.name'))
        ->greeting('Hello ' . $notifiable->name . '!')
        ->line('Welcome to our platform.');
    
    // Personalize based on user role
    if ($notifiable->isAdmin()) {
        $message->line('As an admin, you have access to the admin dashboard.');
        $message->action('Go to Admin Dashboard', url('/admin'));
    } else {
        $message->action('Go to Dashboard', url('/dashboard'));
    }
    
    return $message;
}
```

### 14.3 Email Scheduling

**Schedule emails for optimal delivery:**
```php
public function __construct($user, $locale = null)
{
    $this->user = $user;
    $this->locale = $locale ?? App::getLocale();
    
    // Schedule for optimal delivery time
    $optimalTime = now()->addMinutes(rand(1, 60));
    $this->delay($optimalTime);
}
```

### 14.4 A/B Testing

**Test different email content:**
```php
public function toMail($notifiable)
{
    $isVariantA = rand(0, 1) === 0;
    
    $message = (new MailMessage)
        ->subject($isVariantA ? 'Welcome!' : 'Welcome to ' . config('app.name'));
    
    if ($isVariantA) {
        $message->line('Short and sweet welcome message.');
    } else {
        $message->line('Detailed welcome message with more information.');
    }
    
    return $message;
}
```

## 📞 Step 15: Support and Monitoring

### 15.1 Error Monitoring

**Set up error tracking:**
```php
// In your notification class
public function failed(\Exception $exception)
{
    Log::error('Welcome email failed', [
        'user_id' => $this->user->id,
        'error' => $exception->getMessage(),
        'trace' => $exception->getTraceAsString(),
    ]);
    
    // Optional: Send to error tracking service
    // \Sentry\captureException($exception);
}
```

### 15.2 Health Checks

**Monitor email system health:**
```php
// Add to your health check endpoint
public function emailHealthCheck()
{
    try {
        $client = new SesClient([
            'version' => 'latest',
            'region' => env('SES_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        
        $client->getSendQuota();
        return ['status' => 'healthy', 'service' => 'SES'];
    } catch (\Exception $e) {
        return ['status' => 'error', 'service' => 'SES', 'error' => $e->getMessage()];
    }
}
```

### 15.3 Logging and Analytics

**Track email performance:**
```php
// Add to your notification class
public function toMail($notifiable)
{
    $message = (new MailMessage)
        ->subject(__('messages.welcome_subject'));
    
    // Log email sending attempt
    Log::info('Welcome email sent', [
        'user_id' => $notifiable->id,
        'locale' => $this->locale,
        'timestamp' => now(),
    ]);
    
    return $message;
}
```

## 🎉 Step 16: Completion Checklist

### AWS Setup
- [ ] Created/updated IAM user with SES permissions
- [ ] Created SES email identity or domain
- [ ] Verified email address or domain
- [ ] Set up configuration set (optional)
- [ ] Requested production access (if needed)

### Laravel Configuration
- [ ] Updated `.env` with SES configuration
- [ ] Configured `config/services.php` for SES
- [ ] Set mail driver to `ses`
- [ ] Added email translations (EN/BN)

### Email Implementation
- [ ] Created `WelcomeNotification` class
- [ ] Created email templates
- [ ] Integrated with user registration
- [ ] Set up queue processing
- [ ] Added localization support

### Testing and Monitoring
- [ ] Tested email sending with test routes
- [ ] Verified email delivery
- [ ] Set up error logging
- [ ] Monitored SES metrics
- [ ] Tested bounce/complaint handling

### Security and Performance
- [ ] Implemented rate limiting
- [ ] Set up SPF/DKIM/DMARC records
- [ ] Configured queue workers
- [ ] Set up monitoring and alerts
- [ ] Optimized email templates

### Production Deployment
- [ ] Environment-specific configurations
- [ ] Domain verification (if applicable)
- [ ] DKIM setup
- [ ] Supervisor configuration for queues
- [ ] Monitoring and alerting setup

## 🔗 Additional Resources

### AWS Documentation
- [AWS SES Developer Guide](https://docs.aws.amazon.com/ses/)
- [SES API Reference](https://docs.aws.amazon.com/ses/latest/APIReference/)
- [SES Best Practices](https://docs.aws.amazon.com/ses/latest/dg/best-practices.html)

### Laravel Documentation
- [Laravel Mail](https://laravel.com/docs/mail)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queues](https://laravel.com/docs/queues)

### Tools and Services
- [Mail Tester](https://www.mail-tester.com/) - Test email deliverability
- [MX Toolbox](https://mxtoolbox.com/) - DNS and email diagnostics
- [AWS SES Simulator](https://docs.aws.amazon.com/ses/latest/dg/send-email-simulator.html) - Test bounce/complaint handling

---

Your AWS SES email setup is now complete! You can send registration emails, welcome messages, and other transactional emails with proper localization support, queue processing, and monitoring. 

**Next Steps:**
1. Test the complete flow with user registration
2. Monitor email delivery and performance
3. Set up additional notification types as needed
4. Implement advanced features like email templates and A/B testing

🚀 **Happy Emailing!**