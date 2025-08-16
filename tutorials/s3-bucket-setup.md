# AWS S3 Bucket Setup Tutorial

This comprehensive guide walks you through setting up two AWS S3 buckets for Laravel Backup and Media Library with conditional folder structure based on environment.

## 📋 Overview

We'll create two S3 buckets:
- **`polodev-local-backup-private`** - For storing Laravel backups (private)  
- **`polodev-local-backup`** - For storing media files (public)

**Conditional Folder Structure:**
- **Production**: Media files stored in `media/` folder
- **Staging/Local**: Media files stored in `media-staging/` folder

## 🚀 Step 1: Create AWS Account & Access IAM

1. **Sign in to AWS Console**: https://console.aws.amazon.com/
2. **Navigate to IAM**: Search for "IAM" in the services menu
3. **Create IAM User** (recommended instead of using root account):
   - Go to "Users" → "Add users"
   - Username: `polodev-local-backup-s3-user`
   - Select "Programmatic access"
   - Click "Next: Permissions"

## 🔐 Step 2: Create IAM Policy

1. **Create Custom Policy**:
   - In IAM, go to "Policies" → "Create policy"
   - Click "JSON" tab
   - Paste the following policy:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "S3BucketAccess",
            "Effect": "Allow",
            "Action": [
                "s3:ListBucket",
                "s3:GetBucketLocation",
                "s3:ListBucketMultipartUploads"
            ],
            "Resource": [
                "arn:aws:s3:::polodev-local-backup-private",
                "arn:aws:s3:::polodev-local-backup"
            ]
        },
        {
            "Sid": "S3ObjectAccess",
            "Effect": "Allow",
            "Action": [
                "s3:GetObject",
                "s3:PutObject",
                "s3:DeleteObject",
                "s3:GetObjectAcl",
                "s3:PutObjectAcl",
                "s3:AbortMultipartUpload",
                "s3:ListMultipartUploadParts"
            ],
            "Resource": [
                "arn:aws:s3:::polodev-local-backup-private/*",
                "arn:aws:s3:::polodev-local-backup/*"
            ]
        }
    ]
}
```

2. **Name the Policy**: `polodev-local-backup-S3-Access-Policy`
3. **Add Description**: "Policy for Laravel backup and media library S3 access"
4. **Click "Create policy"**

## 👤 Step 3: Attach Policy to User

1. **Go back to your IAM user**
2. **Click "Add permissions"** → "Attach existing policies directly"
3. **Search and select** `polodev-local-backup-S3-Access-Policy`
4. **Click "Next: Review"** → "Add permissions"

## 🔑 Step 4: Generate Access Keys

1. **In your IAM user details**, click "Security credentials" tab
2. **Click "Create access key"**
3. **Select "Application running outside AWS"**
4. **Add description tag**: "Laravel S3 Integration"
5. **Click "Create access key"**
6. **⚠️ IMPORTANT**: Copy both `Access Key ID` and `Secret Access Key` immediately
7. **Store them securely** - you won't be able to see the secret key again

## 🪣 Step 5: Create S3 Buckets

### Bucket 1: Private Backup Bucket

1. **Navigate to S3**: Search for "S3" in AWS Console
2. **Click "Create bucket"**
3. **Bucket Configuration**:
   - **Bucket name**: `polodev-local-backup-private`
   - **AWS Region**: Choose your preferred region (e.g., `us-east-1`)
   - **Object Ownership**: ACLs disabled (recommended)

4. **Block Public Access Settings**: ✅ **Keep all 4 options CHECKED**
   - ✅ Block all public access
   - ✅ Block public access to buckets and objects granted through new ACLs
   - ✅ Block public access to buckets and objects granted through any ACLs
   - ✅ Block public access to buckets and objects granted through new public bucket or access point policies
   - ✅ Block public access to buckets and objects granted through any public bucket or access point policies

5. **Bucket Versioning**: ✅ **Enable** (recommended for backups)

6. **Default Encryption**:
   - ✅ **Enable** Server-side encryption
   - **Encryption type**: Amazon S3 managed keys (SSE-S3)

7. **Click "Create bucket"**

### Bucket 2: Public Media Bucket

1. **Click "Create bucket"** again
2. **Bucket Configuration**:
   - **Bucket name**: `polodev-local-backup`
   - **AWS Region**: Same region as the backup bucket
   - **Object Ownership**: ACLs disabled (recommended)

3. **Block Public Access Settings**: ❌ **UNCHECK all options**
   - ❌ Block all public access
   - ❌ Block public access to buckets and objects granted through new ACLs
   - ❌ Block public access to buckets and objects granted through any ACLs
   - ❌ Block public access to buckets and objects granted through new public bucket or access point policies
   - ❌ Block public access to buckets and objects granted through any public bucket or access point policies
   - ✅ **Acknowledge the warning** about public access

4. **Bucket Versioning**: ⚪ **Disable** (optional for media files)

5. **Default Encryption**:
   - ✅ **Enable** Server-side encryption
   - **Encryption type**: Amazon S3 managed keys (SSE-S3)

6. **Click "Create bucket"**

## 🔧 Step 6: Configure Public Media Bucket Policy

1. **Open the `polodev-local-backup` bucket**
2. **Go to "Permissions" tab**
3. **Click "Edit" under "Bucket policy"**
4. **Paste the following policy**:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "PublicReadGetObject",
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::polodev-local-backup/media/*"
        },
        {
            "Sid": "PublicReadGetObjectStaging",
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::polodev-local-backup/media-staging/*"
        }
    ]
}
```

5. **Click "Save changes"**

## 🌐 Step 7: Configure CORS for Media Bucket

1. **In the `polodev-local-backup` bucket, go to "Permissions" tab**
2. **Scroll down to "Cross-origin resource sharing (CORS)"**
3. **Click "Edit"**
4. **Paste the following CORS configuration**:

```json
[
    {
        "AllowedHeaders": [
            "*"
        ],
        "AllowedMethods": [
            "GET",
            "PUT",
            "POST",
            "DELETE",
            "HEAD"
        ],
        "AllowedOrigins": [
            "http://rajib.test",
            "https://yourdomain.com"
        ],
        "ExposeHeaders": [
            "ETag",
            "x-amz-server-side-encryption",
            "x-amz-request-id",
            "x-amz-id-2"
        ],
        "MaxAgeSeconds": 3000
    }
]
```

5. **Update the `AllowedOrigins`** with your actual domain(s)
6. **Click "Save changes"**

## ⚙️ Step 8: Update Laravel Environment Configuration

1. **Open your `.env` file**
2. **Add/Update the following variables**:

```env
# S3-Specific AWS Configuration
AWS_S3_ACCESS_KEY_ID=your_access_key_from_step_4
AWS_S3_SECRET_ACCESS_KEY=your_secret_key_from_step_4
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=polodev-local-backup

# S3 Backup Configuration
AWS_BACKUP_BUCKET=polodev-local-backup-private
AWS_BACKUP_ROOT=backups

# S3 Media Library Configuration
AWS_MEDIA_BUCKET=polodev-local-backup
MEDIA_DISK=s3-media

# Note: Media folder is automatically set based on environment:
# Production: media/
# Non-production: media-staging/
```

## 🎯 Step 9: Environment-Based Folder Configuration

The folder structure is automatically set based on your `APP_ENV` environment variable:

- **Production** (`APP_ENV=production`): Files stored in `media/` folder
- **Non-Production** (local, staging, etc.): Files stored in `media-staging/` folder

### Automatic Configuration

This is handled dynamically in `config/filesystems.php`:

```php
's3-media' => [
    'driver' => 's3',
    'key' => env('AWS_S3_ACCESS_KEY_ID'),
    'secret' => env('AWS_S3_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_MEDIA_BUCKET', env('AWS_BUCKET')),
    'root' => env('APP_ENV') === 'production' ? 'media' : 'media-staging',
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'visibility' => 'public',
    'throw' => false,
    'report' => false,
],
```

## 🧪 Step 10: Test Your Configuration

### Test S3 Connection
```bash
# Test backup functionality
php artisan backup:run --only-db

# Test media library (if you have a model with media)
php artisan tinker
```

In Tinker:
```php
// Test S3 connection
Storage::disk('s3-backup')->put('test.txt', 'Hello from backup disk!');
Storage::disk('s3-media')->put('test.txt', 'Hello from media disk!');

// Check if files exist
Storage::disk('s3-backup')->exists('test.txt');
Storage::disk('s3-media')->exists('test.txt');

// Clean up test files
Storage::disk('s3-backup')->delete('test.txt');
Storage::disk('s3-media')->delete('test.txt');
```

### Test Media Library
```php
// In a controller or tinker
$user = App\Models\User::first();

// This would upload to s3-media disk in the configured folder
$user->addMediaFromUrl('https://picsum.photos/200/300')
    ->toMediaCollection('avatars');

// Get the URL
$avatarUrl = $user->getFirstMediaUrl('avatars');
echo $avatarUrl; // Should be a public S3 URL
```

## 🔍 Step 11: Verify Bucket Structure

After testing, your buckets should have this structure:

### `polodev-local-backup-private` (Private)
```
backups/
├── site_name_2024-01-15_120000.zip
├── site_name_2024-01-16_120000.zip
└── ...
```

### `polodev-local-backup` (Public)
```
media/                     # Production files
├── 1/
│   ├── conversions/
│   └── original-filename.jpg
└── 2/
    └── another-file.pdf

media-staging/            # Staging/Local files
├── 1/
│   ├── conversions/
│   └── test-image.jpg
└── ...
```

## 🚨 Troubleshooting

### Common Issues:

1. **"Access Denied" Errors**
   - Verify IAM policy includes correct bucket ARNs
   - Check that AWS credentials are correct in `.env`
   - Ensure IAM user has the custom policy attached

2. **"Bucket does not exist" Error**
   - Verify bucket names match exactly in `.env`
   - Check that bucket region matches `AWS_DEFAULT_REGION`

3. **Public Access Issues**
   - Verify bucket policy allows public read access
   - Check that public access blocking is disabled
   - Ensure CORS is configured for web access

4. **Media Library Upload Fails**
   - Check `MEDIA_DISK` is set to `s3-media`
   - Verify queue is running if using queue for conversions
   - Check Laravel logs for detailed error messages

### Debug Commands:
```bash
# Check Laravel configuration
php artisan config:show filesystems
php artisan config:show backup
php artisan config:show media-library

# Clear configuration cache
php artisan config:clear

# Test backup
php artisan backup:run --only-db

# Monitor backup status
php artisan backup:list
php artisan backup:monitor
```

## 🔒 Security Best Practices

1. **Never commit AWS credentials** to version control
2. **Use environment-specific `.env` files**
3. **Enable CloudTrail** for S3 bucket access logging
4. **Set up S3 bucket notifications** for monitoring
5. **Regularly rotate AWS access keys**
6. **Use least-privilege IAM policies**
7. **Enable MFA** on your AWS account
8. **Monitor S3 costs** and set up billing alerts

## 💰 Cost Optimization

1. **Set up S3 Lifecycle Rules** for backup bucket:
   - Transition to IA (Infrequent Access) after 30 days
   - Transition to Glacier after 90 days
   - Delete after 365 days (adjust based on retention needs)

2. **Enable S3 Intelligent Tiering** for cost optimization
3. **Monitor storage usage** with CloudWatch
4. **Set up billing alerts** for unexpected costs

## 📞 Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable S3 debug mode in config
3. Use AWS CLI for bucket access testing
4. Review IAM simulator for permission issues

## 🎉 Completion Checklist

- [ ] Created IAM user with programmatic access
- [ ] Created and attached S3 access policy
- [ ] Generated and stored AWS access keys securely
- [ ] Created `polodev-local-backup-private` bucket (private)
- [ ] Created `polodev-local-backup` bucket (public)
- [ ] Configured bucket policy for public media access
- [ ] Set up CORS for media bucket
- [ ] Updated Laravel `.env` configuration
- [ ] Configured environment-based folder structure
- [ ] Tested S3 connection and file operations
- [ ] Verified backup and media library functionality

Your AWS S3 setup is now complete and ready for Laravel Backup and Media Library integration!