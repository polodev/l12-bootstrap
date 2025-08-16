<?php

namespace Modules\Documentation\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Documentation\Models\WebsiteDocumentation;

class DocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentations = [
            [
                'title' => 'How to Get Google OAuth Credentials',
                'section' => 'configuration',
                'difficulty' => 'intermediate',
                'position' => 1,
                'is_published' => true,
                'content' => $this->getGoogleOAuthContent(),
            ],
            [
                'title' => 'AWS SES Email Setup Tutorial',
                'section' => 'configuration',
                'difficulty' => 'intermediate',
                'position' => 2,
                'is_published' => true,
                'content' => $this->getAwsSesContent(),
            ],
            [
                'title' => 'AWS S3 Bucket Setup Tutorial',
                'section' => 'configuration',
                'difficulty' => 'intermediate',
                'position' => 3,
                'is_published' => true,
                'content' => $this->getAwsS3Content(),
            ],
            [
                'title' => 'Getting Started with Laravel Application',
                'section' => 'getting-started',
                'difficulty' => 'beginner',
                'position' => 1,
                'is_published' => true,
                'content' => $this->getLaravelStartedContent(),
            ],
            [
                'title' => 'Environment Variables Configuration',
                'section' => 'configuration',
                'difficulty' => 'beginner',
                'position' => 4,
                'is_published' => true,
                'content' => $this->getEnvConfigContent(),
            ],
        ];

        foreach ($documentations as $doc) {
            WebsiteDocumentation::create($doc);
        }
    }

    private function getGoogleOAuthContent(): string
    {
        return <<<'MARKDOWN'
# How to Get Google OAuth Credentials

This guide will walk you through obtaining Google OAuth credentials for your Laravel application to enable Google authentication.

## Prerequisites

- A Google account
- Access to Google Cloud Console
- Basic understanding of OAuth 2.0

## Step 1: Create a Google Cloud Project

1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Click on the project dropdown at the top of the page
3. Click **"New Project"**
4. Enter your project name (e.g., "MyApp OAuth")
5. Click **"Create"**

## Step 2: Enable Google+ API

1. In the Google Cloud Console, navigate to **APIs & Services > Library**
2. Search for **"Google+ API"**
3. Click on it and press **"Enable"**

Alternatively, you can enable the **Google Identity API** for newer implementations.

## Step 3: Configure OAuth Consent Screen

1. Go to **APIs & Services > OAuth consent screen**
2. Choose **External** user type (unless you're using Google Workspace)
3. Fill in the required information:
   - **App name**: Your application name
   - **User support email**: Your email address
   - **Developer contact information**: Your email address
4. Click **"Save and Continue"**
5. On the Scopes page, click **"Save and Continue"** (no changes needed for basic auth)
6. On the Test users page, add test email addresses if needed
7. Click **"Save and Continue"**

## Step 4: Create OAuth 2.0 Credentials

1. Go to **APIs & Services > Credentials**
2. Click **"Create Credentials"** and select **"OAuth 2.0 Client IDs"**
3. Choose **"Web application"** as the application type
4. Enter a name for your OAuth client (e.g., "Laravel App")
5. Add authorized redirect URIs:
   ```
   http://localhost:8000/auth/google/callback
   https://yourdomain.com/auth/google/callback
   ```
6. Click **"Create"**

## Step 5: Get Your Credentials

After creating the OAuth client, you'll see a popup with:
- **Client ID**: A long string ending in `.apps.googleusercontent.com`
- **Client Secret**: A shorter alphanumeric string

**Important**: Copy these values immediately and store them securely.

## Step 6: Configure Laravel Application

Add the following to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

## Step 7: Install Laravel Socialite

Install the Laravel Socialite package:

```bash
composer require laravel/socialite
```

Add Google driver to `config/services.php`:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],
```

## Step 8: Create Authentication Routes

Add these routes to your `web.php`:

```php
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();
    // Handle user authentication logic here
    return redirect('/dashboard');
})->name('google.callback');
```

## Testing Your Integration

1. Visit `/auth/google` in your browser
2. You should be redirected to Google's OAuth consent screen
3. After authorization, you'll be redirected back to your callback URL

## Common Issues

### Invalid Redirect URI
Make sure your redirect URI in Google Console exactly matches the one in your Laravel routes.

### Credential Mismatch
Double-check that your Client ID and Client Secret are correctly copied to your `.env` file.

### Consent Screen Not Configured
Ensure you've completed the OAuth consent screen configuration before testing.

## Security Best Practices

- Never commit your Google credentials to version control
- Use environment variables for all sensitive data
- Regularly rotate your client secrets
- Implement proper user data handling according to Google's policies

## Next Steps

- Implement user registration/login logic in your callback handler
- Add error handling for failed OAuth attempts
- Consider implementing refresh tokens for long-term access

For more advanced implementations, refer to the [Laravel Socialite documentation](https://laravel.com/docs/socialite) and [Google's OAuth 2.0 documentation](https://developers.google.com/identity/protocols/oauth2).
MARKDOWN;
    }

    private function getAwsSesContent(): string
    {
        return <<<'MARKDOWN'
# AWS SES Email Setup Tutorial

This comprehensive guide will help you set up Amazon Simple Email Service (SES) for sending emails from your Laravel application.

## Prerequisites

- An AWS account
- AWS CLI installed (optional but recommended)
- Basic understanding of AWS services
- A verified domain or email address

## Step 1: Create AWS SES Service

1. Sign in to the [AWS Management Console](https://console.aws.amazon.com/)
2. Navigate to **Simple Email Service (SES)**
3. Select your preferred AWS region (e.g., us-east-1, eu-west-1)

> **Note**: Choose a region close to your users for better performance.

## Step 2: Verify Your Email Address or Domain

### Option A: Verify Email Address (Quick Setup)

1. In SES Console, go to **Configuration > Verified identities**
2. Click **"Create identity"**
3. Select **"Email address"**
4. Enter your email address
5. Click **"Create identity"**
6. Check your email and click the verification link

### Option B: Verify Domain (Recommended for Production)

1. Click **"Create identity"**
2. Select **"Domain"**
3. Enter your domain name (e.g., `example.com`)
4. Choose **"Easy DKIM"** for authentication
5. Click **"Create identity"**
6. Add the provided DNS records to your domain:
   - CNAME records for DKIM
   - MX record (if receiving emails)

## Step 3: Request Production Access

By default, SES starts in **Sandbox mode** with limitations:
- Can only send to verified email addresses
- Limited to 200 emails per 24 hours
- Maximum 1 email per second

To remove these limitations:

1. Go to **Account dashboard**
2. Click **"Request production access"**
3. Fill out the form:
   - **Use case description**: Describe your email sending needs
   - **Website URL**: Your application URL
   - **Contact details**: Your contact information
4. Submit the request and wait for approval (usually 24-48 hours)

## Step 4: Create IAM User for SES

1. Go to **IAM Console > Users**
2. Click **"Create user"**
3. Enter username (e.g., `ses-smtp-user`)
4. Select **"Programmatic access"**
5. Attach the policy **"AmazonSESFullAccess"** or create a custom policy:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "ses:SendEmail",
                "ses:SendRawEmail"
            ],
            "Resource": "*"
        }
    ]
}
```

6. Download the CSV file with Access Key ID and Secret Access Key

## Step 5: Get SMTP Credentials

1. In SES Console, go to **Configuration > SMTP settings**
2. Click **"Create SMTP credentials"**
3. Enter IAM user name (e.g., `ses-smtp-user`)
4. Click **"Create user"**
5. Download the SMTP credentials (username and password)

**Important SMTP Endpoints by Region:**
- US East (N. Virginia): `email-smtp.us-east-1.amazonaws.com`
- US West (Oregon): `email-smtp.us-west-2.amazonaws.com`
- Europe (Ireland): `email-smtp.eu-west-1.amazonaws.com`

## Step 6: Configure Laravel Application

Add the following to your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=email-smtp.us-east-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Alternative: Use SES API instead of SMTP
# MAIL_MAILER=ses
# AWS_ACCESS_KEY_ID=your_access_key
# AWS_SECRET_ACCESS_KEY=your_secret_key
# AWS_DEFAULT_REGION=us-east-1
```

## Step 7: Install AWS SDK (If Using SES API)

If you prefer using the SES API instead of SMTP:

```bash
composer require aws/aws-sdk-php
```

Update `config/mail.php`:

```php
'mailers' => [
    'ses' => [
        'transport' => 'ses',
    ],
],
```

## Step 8: Test Email Sending

Create a test route to verify your setup:

```php
// routes/web.php
Route::get('/test-email', function () {
    try {
        Mail::raw('This is a test email from SES!', function ($message) {
            $message->to('test@example.com')
                   ->subject('SES Test Email');
        });
        
        return 'Email sent successfully!';
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
```

## Step 9: Configure Bounce and Complaint Handling

1. In SES Console, go to **Configuration > Configuration sets**
2. Create a configuration set
3. Add event destinations for:
   - **Bounces**: Hard bounces that should remove emails from your list
   - **Complaints**: Spam reports that should unsubscribe users
   - **Deliveries**: Successful delivery confirmations

## Step 10: Monitor Your Sending

1. Check **Reputation metrics** in SES Console
2. Monitor bounce and complaint rates (keep below 5% and 0.1% respectively)
3. Set up CloudWatch alarms for high bounce/complaint rates

## Best Practices

### Email Authentication
- Always use DKIM signing
- Set up SPF records: `v=spf1 include:amazonses.com ~all`
- Configure DMARC policy

### Content Guidelines
- Avoid spam trigger words
- Include unsubscribe links
- Use proper HTML structure
- Test emails across different clients

### Rate Limiting
- Respect SES sending limits
- Implement queue system for bulk emails
- Use SES sending statistics to monitor usage

## Common Issues

### High Bounce Rate
- Clean your email list regularly
- Use double opt-in for subscriptions
- Remove hard bounces immediately

### Emails Going to Spam
- Warm up your IP gradually
- Maintain good sender reputation
- Use authentication (SPF, DKIM, DMARC)

### Account Suspension
- Monitor bounce and complaint rates
- Respond to AWS support quickly
- Implement proper list management

## Cost Optimization

- SES pricing: $0.10 per 1,000 emails
- Additional charges for dedicated IPs
- Use SES configuration sets to track costs per application

## Troubleshooting

### SMTP Authentication Failed
- Verify SMTP credentials are correct
- Check region-specific SMTP endpoint
- Ensure IAM user has SES permissions

### Message Not Delivered
- Check sender reputation
- Verify recipient email is not blacklisted
- Review SES sending statistics

For more detailed information, refer to the [AWS SES Developer Guide](https://docs.aws.amazon.com/ses/).
MARKDOWN;
    }

    private function getAwsS3Content(): string
    {
        return <<<'MARKDOWN'
# AWS S3 Bucket Setup Tutorial

This guide will walk you through setting up an Amazon S3 bucket for file storage in your Laravel application, including proper security configurations and Laravel integration.

## Prerequisites

- An AWS account
- Basic understanding of cloud storage concepts
- Laravel application ready for integration

## Step 1: Create an S3 Bucket

1. Sign in to the [AWS Management Console](https://console.aws.amazon.com/)
2. Navigate to **Amazon S3**
3. Click **"Create bucket"**
4. Configure your bucket:
   - **Bucket name**: Choose a globally unique name (e.g., `myapp-files-2024`)
   - **Region**: Select the region closest to your users
   - **Object Ownership**: Choose **"ACLs disabled (recommended)"**

## Step 2: Configure Bucket Settings

### Block Public Access Settings

For security, it's recommended to block public access by default:

- ✅ **Block all public ACLs**
- ✅ **Ignore public ACLs**
- ✅ **Block public bucket policies**
- ✅ **Block public and cross-account access**

> **Note**: You can selectively enable public access later for specific use cases.

### Versioning

- **Enable versioning** if you need to keep multiple versions of files
- **Disable** for cost optimization if versioning isn't needed

### Encryption

- Choose **"Server-side encryption with Amazon S3 managed keys (SSE-S3)"**
- Or use **"Server-side encryption with AWS KMS keys (SSE-KMS)"** for additional control

Click **"Create bucket"** to finalize.

## Step 3: Create IAM User for S3 Access

1. Go to **IAM Console > Users**
2. Click **"Create user"**
3. Enter username (e.g., `s3-laravel-user`)
4. Select **"Programmatic access"**
5. Create and attach a custom policy:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:GetObject",
                "s3:PutObject",
                "s3:DeleteObject",
                "s3:GetObjectAcl",
                "s3:PutObjectAcl"
            ],
            "Resource": "arn:aws:s3:::your-bucket-name/*"
        },
        {
            "Effect": "Allow",
            "Action": [
                "s3:ListBucket",
                "s3:GetBucketLocation"
            ],
            "Resource": "arn:aws:s3:::your-bucket-name"
        }
    ]
}
```

6. Complete user creation and download the **Access Key ID** and **Secret Access Key**

## Step 4: Configure Bucket Policy (Optional)

If you need public read access for certain files, create a bucket policy:

1. Go to your S3 bucket
2. Click **Permissions > Bucket policy**
3. Add policy for public read access to specific folders:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "PublicReadGetObject",
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::your-bucket-name/public/*"
        }
    ]
}
```

## Step 5: Configure CORS (For Web Uploads)

If you plan to upload files directly from the browser:

1. Go to **Permissions > Cross-origin resource sharing (CORS)**
2. Add CORS configuration:

```json
[
    {
        "AllowedHeaders": ["*"],
        "AllowedMethods": ["GET", "PUT", "POST", "DELETE"],
        "AllowedOrigins": ["https://yourdomain.com"],
        "ExposeHeaders": ["ETag"]
    }
]
```

## Step 6: Install Laravel S3 Dependencies

Install the required packages:

```bash
composer require league/flysystem-aws-s3-v3 "^3.0"
```

## Step 7: Configure Laravel Environment

Add the following to your `.env` file:

```env
AWS_ACCESS_KEY_ID=your_access_key_id
AWS_SECRET_ACCESS_KEY=your_secret_access_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_USE_PATH_STYLE_ENDPOINT=false
```

## Step 8: Update Filesystem Configuration

In `config/filesystems.php`, ensure the S3 disk is properly configured:

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
],
```

Set S3 as your default filesystem (optional):

```php
'default' => env('FILESYSTEM_DISK', 's3'),
```

## Step 9: Test S3 Integration

Create a test route to verify your setup:

```php
// routes/web.php
Route::get('/test-s3', function () {
    try {
        // Test file upload
        Storage::disk('s3')->put('test.txt', 'Hello from S3!');
        
        // Test file retrieval
        $content = Storage::disk('s3')->get('test.txt');
        
        // Test file URL generation
        $url = Storage::disk('s3')->url('test.txt');
        
        return response()->json([
            'success' => true,
            'content' => $content,
            'url' => $url
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
});
```

## Step 10: Common Usage Examples

### Upload Files

```php
// Store uploaded file
$path = $request->file('avatar')->store('avatars', 's3');

// Store with custom name
$path = $request->file('document')->storeAs(
    'documents', 
    'custom-name.pdf', 
    's3'
);

// Store with public visibility
$path = Storage::disk('s3')->putFileAs(
    'public/images',
    $request->file('image'),
    'image.jpg',
    'public'
);
```

### Generate Signed URLs

```php
// Generate signed URL (expires in 1 hour)
$url = Storage::disk('s3')->temporaryUrl(
    'private/document.pdf',
    now()->addHour()
);

// Generate permanent public URL
$url = Storage::disk('s3')->url('public/image.jpg');
```

### File Operations

```php
// Check if file exists
if (Storage::disk('s3')->exists('file.txt')) {
    // File exists
}

// Delete file
Storage::disk('s3')->delete('file.txt');

// Copy file
Storage::disk('s3')->copy('old-file.txt', 'new-file.txt');

// Get file size
$size = Storage::disk('s3')->size('file.txt');

// List files in directory
$files = Storage::disk('s3')->files('uploads');
```

## Best Practices

### Security
- Use IAM roles instead of access keys when possible
- Implement least privilege access principles
- Enable S3 bucket logging for audit trails
- Use signed URLs for private content

### Performance
- Use CloudFront CDN for global file distribution
- Implement proper caching headers
- Consider S3 Transfer Acceleration for global uploads
- Use multipart uploads for large files

### Cost Optimization
- Use appropriate storage classes (Standard, IA, Glacier)
- Implement lifecycle policies to automatically transition old files
- Monitor storage usage and costs regularly
- Use S3 Intelligent Tiering for automatic cost optimization

## Troubleshooting

### Access Denied Errors
- Verify IAM user permissions
- Check bucket policy configuration
- Ensure correct region is specified

### File Not Found
- Verify file path and bucket name
- Check if file was uploaded successfully
- Ensure proper URL generation

### Slow Upload/Download
- Consider using CloudFront
- Check network connectivity
- Verify region selection

## Advanced Configuration

### Enable Versioning
```bash
aws s3api put-bucket-versioning \
    --bucket your-bucket-name \
    --versioning-configuration Status=Enabled
```

### Set up Lifecycle Policy
```json
{
    "Rules": [
        {
            "ID": "DeleteOldVersions",
            "Status": "Enabled",
            "NoncurrentVersionExpiration": {
                "NoncurrentDays": 30
            }
        }
    ]
}
```

### Monitor with CloudWatch
- Set up alarms for unusual access patterns
- Monitor storage usage and costs
- Track error rates and performance metrics

For more advanced features and configurations, refer to the [AWS S3 Developer Guide](https://docs.aws.amazon.com/s3/) and [Laravel Filesystem documentation](https://laravel.com/docs/filesystem).
MARKDOWN;
    }

    private function getLaravelStartedContent(): string
    {
        return <<<'MARKDOWN'
# Getting Started with Laravel Application

Welcome to your Laravel application! This guide will help you understand the basic structure and get you started with development.

## What is Laravel?

Laravel is a powerful PHP web framework designed for rapid application development. It follows the Model-View-Controller (MVC) architectural pattern and provides elegant syntax along with rich features.

## Prerequisites

Before you begin, ensure you have:

- **PHP 8.1 or higher**
- **Composer** (dependency manager for PHP)
- **Node.js and NPM** (for asset compilation)
- **Database** (MySQL, PostgreSQL, SQLite, or SQL Server)

## Application Structure

Your Laravel application follows a specific directory structure:

```
/your-app
├── app/                    # Application core files
│   ├── Http/Controllers/   # Request handling logic
│   ├── Models/            # Database models
│   └── Providers/         # Service providers
├── config/                # Configuration files
├── database/              # Migrations, seeders, factories
├── public/                # Web server document root
├── resources/             # Views, raw assets
├── routes/                # Route definitions
├── storage/               # File storage, logs, cache
└── vendor/                # Composer dependencies
```

## Environment Configuration

Your application uses environment variables for configuration:

1. **Copy the environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

3. **Configure your database in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

## Running Your Application

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

Your application will be available at `http://localhost:8000`

### Database Setup

1. **Run migrations:**
   ```bash
   php artisan migrate
   ```

2. **Seed the database (optional):**
   ```bash
   php artisan db:seed
   ```

## Key Concepts

### Routes

Routes define how your application responds to client requests. They're defined in `routes/web.php`:

```php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);
```

### Controllers

Controllers handle request logic and return responses:

```php
<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
}
```

### Models

Models represent database tables and handle data operations:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email'];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

### Views

Views contain your application's HTML and are stored in `resources/views/`:

```blade
{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
<h1>Users</h1>
@foreach($users as $user)
    <p>{{ $user->name }}</p>
@endforeach
@endsection
```

## Common Artisan Commands

Laravel includes Artisan, a command-line tool for common tasks:

```bash
# Generate files
php artisan make:controller UserController
php artisan make:model Post -m
php artisan make:migration create_posts_table

# Database operations
php artisan migrate
php artisan migrate:rollback
php artisan db:seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Queue management
php artisan queue:work
php artisan queue:restart

# Maintenance mode
php artisan down
php artisan up
```

## Frontend Assets

### Vite Integration

Laravel uses Vite for asset compilation:

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Development:**
   ```bash
   npm run dev
   ```

3. **Production build:**
   ```bash
   npm run build
   ```

### Including Assets in Views

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

## Database Migrations

Migrations provide version control for your database:

```bash
# Create migration
php artisan make:migration create_posts_table

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback
```

Example migration:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
```

## Authentication

Laravel provides built-in authentication:

```bash
# Install authentication scaffolding
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
```

Or use Laravel Breeze for a more modern approach:

```bash
composer require laravel/breeze
php artisan breeze:install
npm install && npm run dev
php artisan migrate
```

## Testing

Laravel includes PHPUnit for testing:

```bash
# Run tests
php artisan test

# Create test
php artisan make:test UserTest
```

Example test:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                         ->get('/profile');
                         
        $response->assertStatus(200);
    }
}
```

## Next Steps

Now that you understand the basics:

1. **Explore the documentation:** [Laravel Documentation](https://laravel.com/docs)
2. **Learn Eloquent ORM:** For database interactions
3. **Understand Blade templating:** For creating dynamic views
4. **Practice with tutorials:** Build small projects to reinforce learning
5. **Join the community:** Laravel has an active and helpful community

## Common Patterns

### Resource Controllers

```bash
php artisan make:controller PostController --resource
```

Creates controller with CRUD methods: index, create, store, show, edit, update, destroy.

### Form Requests

```bash
php artisan make:request StorePostRequest
```

Handle form validation in dedicated classes.

### Factories and Seeders

```bash
php artisan make:factory PostFactory
php artisan make:seeder PostSeeder
```

Generate test data for development and testing.

## Helpful Resources

- **Official Documentation:** [laravel.com/docs](https://laravel.com/docs)
- **Laracasts:** Video tutorials for Laravel
- **Laravel News:** Stay updated with Laravel ecosystem
- **GitHub:** [github.com/laravel/laravel](https://github.com/laravel/laravel)

Happy coding with Laravel! 🚀
MARKDOWN;
    }

    private function getEnvConfigContent(): string
    {
        return <<<'MARKDOWN'
# Environment Variables Configuration

Environment variables are crucial for configuring your Laravel application across different environments (development, staging, production) without hardcoding sensitive information.

## What are Environment Variables?

Environment variables are key-value pairs that store configuration data outside your application code. They help you:

- Keep sensitive data (passwords, API keys) secure
- Configure different settings per environment
- Follow the 12-factor app methodology
- Maintain clean, version-controllable code

## The .env File

Laravel uses the `.env` file to store environment variables:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

## Core Application Settings

### Application Configuration

```env
# Application name (used in notifications, emails, etc.)
APP_NAME="My Laravel App"

# Environment: local, staging, production
APP_ENV=local

# Application key (encrypt sessions, cookies, etc.)
APP_KEY=base64:generated_key_here

# Debug mode (NEVER true in production)
APP_DEBUG=true

# Application URL
APP_URL=http://localhost:8000

# Application timezone
APP_TIMEZONE=UTC
```

### Database Configuration

```env
# Database driver: mysql, pgsql, sqlite, sqlsrv
DB_CONNECTION=mysql

# Database server details
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password

# Alternative database URL format
# DATABASE_URL=mysql://user:password@host:port/database
```

### Cache Configuration

```env
# Cache driver: file, database, redis, memcached
CACHE_DRIVER=file

# Cache prefix (useful for shared cache servers)
CACHE_PREFIX=myapp_cache
```

### Session Configuration

```env
# Session driver: file, cookie, database, redis, memcached
SESSION_DRIVER=file

# Session lifetime in minutes
SESSION_LIFETIME=120

# Session encryption
SESSION_ENCRYPT=false

# Session cookie path
SESSION_PATH=/

# Session cookie domain
SESSION_DOMAIN=null

# Secure cookies (HTTPS only)
SESSION_SECURE_COOKIE=false

# HTTP-only cookies
SESSION_HTTP_ONLY=true

# SameSite cookie attribute
SESSION_SAME_SITE=lax
```

## Mail Configuration

```env
# Mail driver: smtp, ses, mailgun, postmark, log, array
MAIL_MAILER=smtp

# SMTP settings
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

# From address and name
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Queue Configuration

```env
# Queue driver: sync, database, redis, sqs, beanstalkd
QUEUE_CONNECTION=sync

# Redis configuration (if using redis queues)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## File Storage Configuration

```env
# Default filesystem disk: local, public, s3
FILESYSTEM_DISK=local

# AWS S3 configuration
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
AWS_USE_PATH_STYLE_ENDPOINT=false
```

## Third-Party Services

### Social Authentication

```env
# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URL=http://localhost:8000/auth/facebook/callback

# GitHub OAuth
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URL=http://localhost:8000/auth/github/callback
```

### Payment Services

```env
# Stripe
STRIPE_KEY=pk_test_your_stripe_public_key
STRIPE_SECRET=sk_test_your_stripe_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

# PayPal
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_CLIENT_SECRET=your_paypal_client_secret
PAYPAL_MODE=sandbox  # or live for production
```

### External APIs

```env
# API Keys
OPENAI_API_KEY=your_openai_api_key
TWILIO_SID=your_twilio_sid
TWILIO_TOKEN=your_twilio_token
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=mt1
```

## Security Best Practices

### 1. Never Commit .env Files

Add `.env` to your `.gitignore`:

```gitignore
.env
.env.backup
.env.production
```

### 2. Use Strong Application Keys

Generate a secure application key:

```bash
php artisan key:generate
```

### 3. Environment-Specific Files

Create separate environment files:

- `.env.local` - Local development
- `.env.staging` - Staging environment
- `.env.production` - Production environment

### 4. Secure Production Settings

Production `.env` example:

```env
APP_NAME="My App"
APP_ENV=production
APP_KEY=base64:secure_production_key
APP_DEBUG=false
APP_URL=https://myapp.com

DB_CONNECTION=mysql
DB_HOST=your_production_db_host
DB_PORT=3306
DB_DATABASE=production_db
DB_USERNAME=production_user
DB_PASSWORD=very_secure_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=ses
```

## Accessing Environment Variables

### In Configuration Files

```php
// config/database.php
'default' => env('DB_CONNECTION', 'mysql'),

'connections' => [
    'mysql' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', 'forge'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
    ],
],
```

### In Application Code

```php
// Get environment variable with default
$apiKey = env('API_KEY', 'default_value');

// Better: Use config values instead of env() directly
$apiKey = config('services.api.key');
```

### In Configuration Files

```php
// config/services.php
return [
    'stripe' => [
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],
];
```

## Environment Detection

Check the current environment:

```php
// In code
if (app()->environment('local')) {
    // Local environment specific code
}

if (app()->environment(['staging', 'production'])) {
    // Staging or production code
}

// Via Artisan command
php artisan env
```

## Configuration Caching

In production, cache your configuration:

```bash
# Cache configuration (production)
php artisan config:cache

# Clear configuration cache
php artisan config:clear
```

## Troubleshooting

### Common Issues

1. **Environment variables not loading:**
   - Check `.env` file exists in project root
   - Ensure no spaces around `=` in `.env` file
   - Restart development server after changes

2. **Configuration not updating:**
   - Clear configuration cache: `php artisan config:clear`
   - Check if you're using `env()` in cached config files

3. **Sensitive data exposure:**
   - Never use `env()` directly in application code
   - Always use configuration files
   - Keep `.env` files out of version control

### Environment Validation

Create a validation rule for required environment variables:

```php
// In a service provider
public function boot()
{
    $required = ['DB_DATABASE', 'MAIL_FROM_ADDRESS', 'APP_KEY'];
    
    foreach ($required as $var) {
        if (empty(env($var))) {
            throw new Exception("Required environment variable {$var} is not set");
        }
    }
}
```

## Multiple Environment Management

For complex deployments, consider using:

- **Laravel Forge:** Automated deployment with environment management
- **Laravel Vapor:** Serverless deployment on AWS
- **Docker:** Containerized environments with environment-specific configs
- **Kubernetes:** ConfigMaps and Secrets for environment variables

Remember: Environment variables are the foundation of a secure, maintainable Laravel application. Always keep sensitive data in environment variables and never commit them to version control!
MARKDOWN;
    }
}