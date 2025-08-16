# Custom Environment Keys Reference

## AWS Configuration
AWS_ACCESS_KEY_ID: AWS access key for S3, SES and other AWS services  
AWS_SECRET_ACCESS_KEY: AWS secret key for authentication  
AWS_DEFAULT_REGION: AWS region for services (ap-southeast-1)  
AWS_BUCKET: Main S3 bucket for public assets (devauthor-com-public)  
AWS_BACKUP_BUCKET: Private S3 bucket for backups (devauthor-com-private)  
AWS_BACKUP_ROOT: Root directory for backup files in S3  
AWS_MEDIA_BUCKET: S3 bucket for media library files  
MEDIA_DISK: Laravel filesystem disk for media storage

## Social Authentication
SOCIAL_LOGIN_GOOGLE_ENABLED: Enable/disable Google OAuth login  
GOOGLE_CLIENT_ID: Google OAuth application client ID  
GOOGLE_CLIENT_SECRET: Google OAuth application secret  
GOOGLE_REDIRECT_URI: Callback URL for Google OAuth  
SOCIAL_LOGIN_FACEBOOK_ENABLED: Enable/disable Facebook OAuth login  
FACEBOOK_CLIENT_ID: Facebook app ID for OAuth  
FACEBOOK_CLIENT_SECRET: Facebook app secret for OAuth  
FACEBOOK_REDIRECT_URI: Callback URL for Facebook OAuth

## Security & Validation
RECAPTCHA_ENABLED: Enable/disable reCAPTCHA validation on forms  
RECAPTCHA_SITE_KEY: Google reCAPTCHA public site key  
RECAPTCHA_SECRET_KEY: Google reCAPTCHA private secret key

## Administration
ADMIN_USER_EMAIL: Email address for admin access to Log Viewer

## Application Settings
APP_LOCALE: Default application language (en)  
APP_FALLBACK_LOCALE: Fallback language when translation missing  
PHP_CLI_SERVER_WORKERS: Number of PHP workers for development server  
BCRYPT_ROUNDS: Password hashing rounds for security