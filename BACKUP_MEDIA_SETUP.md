# AWS S3 Backup & Media Library Setup

This document outlines the complete setup for Spatie Laravel Backup and Media Library with AWS S3 storage.

## 📦 Installed Packages

- **spatie/laravel-backup** (v9.3.3) - Database and file backups
- **spatie/laravel-medialibrary** (v11.13.0) - File management and media handling
- **league/flysystem-aws-s3-v3** (v3.29.0) - AWS S3 filesystem driver

## 🔧 Configuration

### AWS S3 Environment Variables

Add these to your `.env` file:

```env
# S3-Specific AWS Configuration
AWS_S3_ACCESS_KEY_ID=your_access_key_here
AWS_S3_SECRET_ACCESS_KEY=your_secret_key_here
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_default_bucket_name

# S3 Backup Configuration (Optional - will use AWS_BUCKET if not set)
AWS_BACKUP_BUCKET=your_backup_bucket_name
AWS_BACKUP_ROOT=backups

# S3 Media Library Configuration (Optional - will use AWS_BUCKET if not set)
AWS_MEDIA_BUCKET=your_media_bucket_name
MEDIA_DISK=s3-media
```

### Filesystem Disks

Three S3 disks are configured in `config/filesystems.php`:

1. **s3** - Default S3 disk (existing)
2. **s3-backup** - Dedicated for backups (private visibility)
3. **s3-media** - Dedicated for media files (public visibility)

## 📁 Backup Configuration

### What Gets Backed Up

**Files:**
- Entire application codebase
- Configuration files
- Module files

**Excluded from Backup:**
- `vendor/` directory
- `node_modules/`
- `.git/` directory
- Framework cache files
- Log files
- Environment files (.env)
- Public vendor assets

**Database:**
- All configured database connections
- Uses current `DB_CONNECTION` from .env

### Backup Storage

- **Location**: AWS S3 bucket specified by `AWS_BACKUP_BUCKET`
- **Root Path**: `backups/` directory in the bucket
- **Visibility**: Private (not publicly accessible)
- **Compression**: Maximum compression (level 9)

## 🖼️ Media Library Configuration

### Storage Location

- **Disk**: `s3-media`
- **Bucket**: AWS S3 bucket specified by `AWS_MEDIA_BUCKET`
- **Root Path**: Environment-based (`media/` for production, `media-staging/` for non-production)
- **Visibility**: Public (accessible via URLs)

### File Handling

- **Max File Size**: 10MB
- **Queue Processing**: Enabled for image conversions
- **Database**: Uses `media` table for metadata

## 🚀 Usage

### Running Backups

```bash
# Run a complete backup (files + database)
php artisan backup:run

# Run only database backup
php artisan backup:run --only-db

# Run only files backup
php artisan backup:run --only-files

# List all backups
php artisan backup:list

# Clean old backups (keeps configured retention)
php artisan backup:clean

# Monitor backup health
php artisan backup:monitor
```

### Using Media Library

Add the trait to your models:

```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class YourModel extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    // Your model code
}
```

Upload and manage files:

```php
// Add a file to a model
$model->addMediaFromRequest('file')
    ->toMediaCollection('images');

// Get media files
$mediaFiles = $model->getMedia('images');

// Get file URLs
$url = $model->getFirstMediaUrl('images');
```

## 🔐 AWS S3 Bucket Configuration

### Recommended Bucket Setup

**For Backups (Private):**
- Enable versioning
- Enable server-side encryption
- Configure lifecycle rules for cost optimization
- Block all public access

**For Media (Public):**
- Configure CORS for web access
- Enable public read access for the media path
- Consider CloudFront CDN for performance

### Sample CORS Configuration

```json
[
    {
        "AllowedHeaders": ["*"],
        "AllowedMethods": ["GET", "PUT", "POST", "DELETE"],
        "AllowedOrigins": ["https://yourdomain.com"],
        "ExposeHeaders": []
    }
]
```

## 📋 Scheduled Backups

Add to your `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('backup:clean')->daily()->at('01:00');
    $schedule->command('backup:run')->daily()->at('02:00');
}
```

## ⚠️ Important Notes

1. **Security**: Never commit AWS credentials to version control
2. **Testing**: Test backup/restore process in staging environment
3. **Monitoring**: Set up monitoring for backup success/failure
4. **Costs**: Monitor S3 storage costs and configure lifecycle rules
5. **Access**: Ensure Laravel has proper AWS permissions

## 📊 Required AWS Permissions

Minimum IAM permissions needed:

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": [
                "s3:ListBucket",
                "s3:GetObject",
                "s3:PutObject",
                "s3:DeleteObject"
            ],
            "Resource": [
                "arn:aws:s3:::your-bucket-name",
                "arn:aws:s3:::your-bucket-name/*"
            ]
        }
    ]
}
```

## 🔍 Troubleshooting

**Common Issues:**

1. **AWS Credentials**: Verify AWS_S3_ACCESS_KEY_ID and AWS_S3_SECRET_ACCESS_KEY
2. **Bucket Permissions**: Ensure bucket exists and Laravel has access
3. **Region Mismatch**: Verify AWS_DEFAULT_REGION matches bucket region
4. **File Size Limits**: Check S3 and Laravel upload limits
5. **Queue Issues**: Ensure queue workers are running for media processing

**Logs**: Check `storage/logs/laravel.log` for detailed error messages.