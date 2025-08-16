<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\Tag;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some tags first
        $tags = [
            ['Laravel', 'লারাভেল'],
            ['PHP', 'পিএইচপি'],
            ['JavaScript', 'জাভাস্ক্রিপ্ট'],
            ['Vue.js', 'ভিউ.জেএস'],
            ['MySQL', 'মাইএসকিউএল'],
            ['Tutorial', 'টিউটোরিয়াল'],
            ['Tips', 'টিপস'],
            ['Best Practices', 'সর্বোত্তম অনুশীলন'],
        ];

        $createdTags = [];
        foreach ($tags as [$enName, $bnName]) {
            $tag = Tag::create([
                'english_name' => $enName,
                'name' => [
                    'en' => $enName,
                    'bn' => $bnName,
                ],
            ]);
            $createdTags[] = $tag;
        }

        // Create blog posts
        $blogs = [
            [
                'english_title' => 'Getting Started with Laravel 11: A Complete Guide',
                'title' => [
                    'en' => 'Getting Started with Laravel 11: A Complete Guide',
                    'bn' => 'লারাভেল ১১ দিয়ে শুরু করা: একটি সম্পূর্ণ গাইড'
                ],
                'excerpt' => [
                    'en' => 'Learn how to set up and start building applications with Laravel 11, including installation, configuration, and basic concepts.',
                    'bn' => 'লারাভেল ১১ দিয়ে অ্যাপ্লিকেশন তৈরি করা শিখুন, যার মধ্যে রয়েছে ইনস্টলেশন, কনফিগারেশন এবং মৌলিক ধারণা।'
                ],
                'content' => [
                    'en' => $this->getLaravelGuideContentEn(),
                    'bn' => $this->getLaravelGuideContentBn()
                ],
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'tags' => ['Laravel', 'PHP', 'Tutorial']
            ],
            [
                'english_title' => 'Modern JavaScript ES6+ Features Every Developer Should Know',
                'title' => [
                    'en' => 'Modern JavaScript ES6+ Features Every Developer Should Know',
                    'bn' => 'আধুনিক জাভাস্ক্রিপ্ট ES6+ ফিচার যা প্রতিটি ডেভেলপারের জানা উচিত'
                ],
                'excerpt' => [
                    'en' => 'Explore the latest JavaScript features including arrow functions, destructuring, promises, async/await, and more.',
                    'bn' => 'সর্বশেষ জাভাস্ক্রিপ্ট ফিচারগুলি আবিষ্কার করুন যার মধ্যে রয়েছে অ্যারো ফাংশন, ডেস্ট্রাকচারিং, প্রমিস, async/await এবং আরও অনেক কিছু।'
                ],
                'content' => [
                    'en' => $this->getJavaScriptContentEn(),
                    'bn' => $this->getJavaScriptContentBn()
                ],
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'tags' => ['JavaScript', 'Tutorial', 'Best Practices']
            ],
            [
                'english_title' => 'Database Optimization Tips for Better Performance',
                'title' => [
                    'en' => 'Database Optimization Tips for Better Performance',
                    'bn' => 'ভাল পারফরম্যান্সের জন্য ডাটাবেস অপটিমাইজেশন টিপস'
                ],
                'excerpt' => [
                    'en' => 'Learn essential database optimization techniques to improve your application performance and reduce query execution time.',
                    'bn' => 'আপনার অ্যাপ্লিকেশনের পারফরম্যান্স উন্নত করতে এবং কোয়েরি এক্সিকিউশন সময় কমাতে অপরিহার্য ডাটাবেস অপটিমাইজেশন কৌশল শিখুন।'
                ],
                'content' => [
                    'en' => $this->getDatabaseOptimizationContentEn(),
                    'bn' => $this->getDatabaseOptimizationContentBn()
                ],
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'tags' => ['MySQL', 'Tips', 'Best Practices']
            ],
            [
                'english_title' => 'Building Reactive User Interfaces with Vue.js 3',
                'title' => [
                    'en' => 'Building Reactive User Interfaces with Vue.js 3',
                    'bn' => 'Vue.js 3 দিয়ে রিঅ্যাক্টিভ ইউজার ইন্টারফেস তৈরি করা'
                ],
                'excerpt' => [
                    'en' => 'Discover how to create dynamic and reactive user interfaces using Vue.js 3 Composition API and modern features.',
                    'bn' => 'Vue.js 3 কম্পোজিশন API এবং আধুনিক ফিচার ব্যবহার করে কীভাবে ডায়নামিক এবং রিঅ্যাক্টিভ ইউজার ইন্টারফেস তৈরি করবেন তা আবিষ্কার করুন।'
                ],
                'content' => [
                    'en' => $this->getVueJsContentEn(),
                    'bn' => $this->getVueJsContentBn()
                ],
                'status' => 'draft',
                'published_at' => null,
                'tags' => ['Vue.js', 'JavaScript', 'Tutorial']
            ],
            [
                'english_title' => 'API Development Best Practices with Laravel',
                'title' => [
                    'en' => 'API Development Best Practices with Laravel',
                    'bn' => 'লারাভেল দিয়ে API ডেভেলপমেন্টের সর্বোত্তম অনুশীলন'
                ],
                'excerpt' => [
                    'en' => 'Learn how to build robust and scalable APIs using Laravel, including authentication, validation, and documentation.',
                    'bn' => 'প্রমাণীকরণ, যাচাইকরণ এবং ডকুমেন্টেশন সহ লারাভেল ব্যবহার করে কীভাবে শক্তিশালী এবং স্কেলেবল API তৈরি করবেন তা শিখুন।'
                ],
                'content' => [
                    'en' => $this->getApiDevelopmentContentEn(),
                    'bn' => $this->getApiDevelopmentContentBn()
                ],
                'status' => 'scheduled',
                'published_at' => now()->addDays(3),
                'tags' => ['Laravel', 'PHP', 'Best Practices']
            ]
        ];

        foreach ($blogs as $blogData) {
            $tagNames = $blogData['tags'];
            unset($blogData['tags']);
            
            // Add empty SEO meta fields for now - these can be filled manually later
            $blogData['meta_title'] = null;
            $blogData['meta_description'] = null;
            $blogData['meta_keywords'] = null;
            $blogData['canonical_url'] = null;
            $blogData['noindex'] = false;
            $blogData['nofollow'] = false;

            // Let Blog model handle slug generation automatically from english_title
            $blogData['user_id'] = 1; // Assuming first user exists

            $blog = Blog::create($blogData);

            // Sync tags using custom taggable system
            $blog->syncTags($tagNames);
        }
    }

    private function getLaravelGuideContentEn(): string
    {
        return <<<'MARKDOWN'
# Getting Started with Laravel 11: A Complete Guide

Laravel 11 represents the latest evolution of the world's most popular PHP framework. This comprehensive guide will walk you through everything you need to know to get started with Laravel 11.

## What's New in Laravel 11

Laravel 11 introduces several exciting features and improvements:

- **Streamlined Application Structure**: Simplified directory structure for cleaner organization
- **Per-Second Rate Limiting**: More granular control over API rate limits
- **Health Routing**: Built-in health check endpoints for monitoring
- **Reverb**: Real-time broadcasting made simple
- **Improved Performance**: Enhanced caching and query optimizations

## Installation Requirements

Before installing Laravel 11, ensure your system meets these requirements:

- **PHP 8.2+**: Laravel 11 requires PHP 8.2 or higher
- **Composer**: PHP dependency manager
- **Node.js & NPM**: For asset compilation
- **Database**: MySQL 8.0+, PostgreSQL 13+, SQLite 3.35+, or SQL Server 2017+

## Installation Methods

### Method 1: Laravel Installer

Install the Laravel installer globally:

```bash
composer global require laravel/installer
```

Create a new Laravel project:

```bash
laravel new my-project
```

### Method 2: Composer Create-Project

```bash
composer create-project laravel/laravel my-project
```

## Initial Configuration

### Environment Setup

Copy the environment file and generate an application key:

```bash
cd my-project
cp .env.example .env
php artisan key:generate
```

### Database Configuration

Update your `.env` file with database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_database
DB_USERNAME=my_username
DB_PASSWORD=my_password
```

### Run Migrations

```bash
php artisan migrate
```

## Directory Structure Overview

Laravel 11 features a streamlined directory structure:

```
my-project/
├── app/                    # Application core
│   ├── Http/Controllers/   # Controllers
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/             # Framework bootstrap files
├── config/               # Configuration files
├── database/             # Migrations, seeders, factories
├── public/               # Web server document root
├── resources/            # Views, raw assets
├── routes/               # Route definitions
├── storage/              # File storage, logs, cache
└── vendor/               # Composer dependencies
```

## Your First Route

Open `routes/web.php` and add:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello/{name}', function ($name) {
    return "Hello, {$name}!";
});
```

## Creating Your First Controller

Generate a controller:

```bash
php artisan make:controller UserController
```

Add methods to your controller:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = ['Alice', 'Bob', 'Charlie'];
        return view('users.index', compact('users'));
    }

    public function show(string $id): View
    {
        return view('users.show', ['user' => "User {$id}"]);
    }
}
```

## Working with Models

Create a model with migration:

```bash
php artisan make:model Post -m
```

Define your migration in `database/migrations/xxx_create_posts_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

Define your model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
    }
}
```

## Blade Templates

Create a layout file `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav>
            <a href="/">Home</a>
            <a href="/posts">Posts</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} My Laravel App</p>
    </footer>
</body>
</html>
```

Create a posts index view `resources/views/posts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="container">
    <h1>Posts</h1>
    
    @forelse($posts as $post)
        <article class="post">
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit($post->content, 150) }}</p>
            <small>Published: {{ $post->published_at?->format('M d, Y') ?? 'Draft' }}</small>
        </article>
    @empty
        <p>No posts found.</p>
    @endforelse
</div>
@endsection
```

## Frontend Assets with Vite

Laravel 11 uses Vite for asset compilation. Install dependencies:

```bash
npm install
```

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

## Essential Artisan Commands

Laravel includes many helpful Artisan commands:

```bash
# Generate files
php artisan make:controller PostController --resource
php artisan make:model User -mcf
php artisan make:migration create_posts_table
php artisan make:seeder PostSeeder
php artisan make:factory PostFactory

# Database operations
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# Cache operations
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Development server
php artisan serve
```

## Authentication with Laravel Breeze

Install Laravel Breeze for authentication scaffolding:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
```

## Testing Your Application

Laravel includes PHPUnit for testing:

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter UserTest

# Generate test coverage
php artisan test --coverage
```

Create a simple test:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_page_displays_posts(): void
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }
}
```

## Next Steps

Now that you have Laravel 11 set up, consider exploring:

1. **Eloquent ORM**: Advanced database relationships and queries
2. **Form Requests**: Validation and authorization
3. **Jobs and Queues**: Background task processing
4. **Events and Listeners**: Decoupled application logic
5. **API Resources**: JSON API responses
6. **Laravel Sanctum**: API authentication
7. **Laravel Horizon**: Queue monitoring
8. **Laravel Telescope**: Application debugging

## Conclusion

Laravel 11 provides a solid foundation for building modern web applications. With its elegant syntax, powerful features, and extensive ecosystem, you're well-equipped to create amazing applications.

Start with small projects, experiment with different features, and gradually build more complex applications as you become comfortable with the framework.

Happy coding! 🚀
MARKDOWN;
    }

    private function getLaravelGuideContentBn(): string
    {
        return <<<'MARKDOWN'
# লারাভেল ১১ দিয়ে শুরু করা: একটি সম্পূর্ণ গাইড

লারাভেল ১১ বিশ্বের সবচেয়ে জনপ্রিয় PHP ফ্রেমওয়ার্কের সর্বশেষ বিবর্তনের প্রতিনিধিত্ব করে। এই ব্যাপক গাইডটি লারাভেল ১১ দিয়ে শুরু করার জন্য আপনার যা জানা প্রয়োজন তার সবকিছুর মধ্য দিয়ে আপনাকে নিয়ে যাবে।

## লারাভেল ১১-এ নতুন কী আছে

লারাভেল ১১ বেশ কিছু উত্তেজনাপূর্ণ বৈশিষ্ট্য এবং উন্নতি পরিচয় করিয়ে দেয়:

- **সুবিন্যস্ত অ্যাপ্লিকেশন কাঠামো**: পরিষ্কার সংগঠনের জন্য সরলীকৃত ডিরেক্টরি কাঠামো
- **প্রতি-সেকেন্ড রেট লিমিটিং**: API রেট লিমিটের উপর আরও দানাদার নিয়ন্ত্রণ
- **স্বাস্থ্য রাউটিং**: মনিটরিংয়ের জন্য অন্তর্নির্মিত স্বাস্থ্য পরীক্ষা শেষবিন্দু
- **রিভার্ব**: রিয়েল-টাইম সম্প্রচার সহজ করা হয়েছে
- **উন্নত পারফরম্যান্স**: উন্নত ক্যাশিং এবং কোয়েরি অপটিমাইজেশন

## ইনস্টলেশনের প্রয়োজনীয়তা

লারাভেল ১১ ইনস্টল করার আগে, নিশ্চিত করুন যে আপনার সিস্টেম এই প্রয়োজনীয়তাগুলি পূরণ করে:

- **PHP 8.2+**: লারাভেল ১১ এর জন্য PHP 8.2 বা উচ্চতর প্রয়োজন
- **কম্পোজার**: PHP নির্ভরতা ব্যবস্থাপক
- **Node.js এবং NPM**: অ্যাসেট সংকলনের জন্য
- **ডাটাবেস**: MySQL 8.0+, PostgreSQL 13+, SQLite 3.35+, বা SQL Server 2017+

## ইনস্টলেশন পদ্ধতি

### পদ্ধতি ১: লারাভেল ইনস্টলার

লারাভেল ইনস্টলার গ্লোবালি ইনস্টল করুন:

```bash
composer global require laravel/installer
```

একটি নতুন লারাভেল প্রকল্প তৈরি করুন:

```bash
laravel new my-project
```

### পদ্ধতি ২: কম্পোজার ক্রিয়েট-প্রকল্প

```bash
composer create-project laravel/laravel my-project
```

## প্রাথমিক কনফিগারেশন

### পরিবেশ সেটআপ

পরিবেশ ফাইল কপি করুন এবং একটি অ্যাপ্লিকেশন কী তৈরি করুন:

```bash
cd my-project
cp .env.example .env
php artisan key:generate
```

### ডাটাবেস কনফিগারেশন

ডাটাবেস শংসাপত্র দিয়ে আপনার `.env` ফাইল আপডেট করুন:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_database
DB_USERNAME=my_username
DB_PASSWORD=my_password
```

### মাইগ্রেশন চালান

```bash
php artisan migrate
```

## ডিরেক্টরি কাঠামো ওভারভিউ

লারাভেল ১১ একটি সুবিন্যস্ত ডিরেক্টরি কাঠামো বৈশিষ্ট্যযুক্ত:

```
my-project/
├── app/                    # অ্যাপ্লিকেশন কোর
│   ├── Http/Controllers/   # কন্ট্রোলার
│   ├── Models/            # Eloquent মডেল
│   └── Providers/         # সার্ভিস প্রদানকারী
├── bootstrap/             # ফ্রেমওয়ার্ক বুটস্ট্র্যাপ ফাইল
├── config/               # কনফিগারেশন ফাইল
├── database/             # মাইগ্রেশন, সিডার, ফ্যাক্টরি
├── public/               # ওয়েব সার্ভার ডকুমেন্ট রুট
├── resources/            # ভিউ, কাঁচা অ্যাসেট
├── routes/               # রুট সংজ্ঞা
├── storage/              # ফাইল স্টোরেজ, লগ, ক্যাশ
└── vendor/               # কম্পোজার নির্ভরতা
```

## আপনার প্রথম রুট

`routes/web.php` খুলুন এবং যোগ করুন:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello/{name}', function ($name) {
    return "হ্যালো, {$name}!";
});
```

## আপনার প্রথম কন্ট্রোলার তৈরি করা

একটি কন্ট্রোলার তৈরি করুন:

```bash
php artisan make:controller UserController
```

আপনার কন্ট্রোলারে মেথড যোগ করুন:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = ['এলিস', 'বব', 'চার্লি'];
        return view('users.index', compact('users'));
    }

    public function show(string $id): View
    {
        return view('users.show', ['user' => "ব্যবহারকারী {$id}"]);
    }
}
```

## মডেলের সাথে কাজ করা

মাইগ্রেশন সহ একটি মডেল তৈরি করুন:

```bash
php artisan make:model Post -m
```

`database/migrations/xxx_create_posts_table.php`-এ আপনার মাইগ্রেশন সংজ্ঞায়িত করুন:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

আপনার মডেল সংজ্ঞায়িত করুন:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
    }
}
```

## ব্লেড টেমপ্লেট

একটি লেআউট ফাইল তৈরি করুন `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'লারাভেল অ্যাপ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav>
            <a href="/">হোম</a>
            <a href="/posts">পোস্ট</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} আমার লারাভেল অ্যাপ</p>
    </footer>
</body>
</html>
```

একটি পোস্ট ইনডেক্স ভিউ তৈরি করুন `resources/views/posts/index.blade.php`:

```blade
@extends('layouts.app')

@section('title', 'পোস্টসমূহ')

@section('content')
<div class="container">
    <h1>পোস্টসমূহ</h1>
    
    @forelse($posts as $post)
        <article class="post">
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit($post->content, 150) }}</p>
            <small>প্রকাশিত: {{ $post->published_at?->format('M d, Y') ?? 'খসড়া' }}</small>
        </article>
    @empty
        <p>কোন পোস্ট পাওয়া যায়নি।</p>
    @endforelse
</div>
@endsection
```

## Vite সহ ফ্রন্টএন্ড অ্যাসেট

লারাভেল ১১ অ্যাসেট সংকলনের জন্য Vite ব্যবহার করে। নির্ভরতা ইনস্টল করুন:

```bash
npm install
```

ডেভেলপমেন্টের জন্য:

```bash
npm run dev
```

প্রোডাকশনের জন্য:

```bash
npm run build
```

## প্রয়োজনীয় Artisan কমান্ড

লারাভেল অনেক সহায়ক Artisan কমান্ড অন্তর্ভুক্ত করে:

```bash
# ফাইল তৈরি করুন
php artisan make:controller PostController --resource
php artisan make:model User -mcf
php artisan make:migration create_posts_table
php artisan make:seeder PostSeeder
php artisan make:factory PostFactory

# ডাটাবেস অপারেশন
php artisan migrate
php artisan migrate:fresh --seed
php artisan db:seed

# ক্যাশ অপারেশন
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# ডেভেলপমেন্ট সার্ভার
php artisan serve
```

## লারাভেল ব্রিজ সহ প্রমাণীকরণ

প্রমাণীকরণ স্ক্যাফোল্ডিংয়ের জন্য লারাভেল ব্রিজ ইনস্টল করুন:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
```

## আপনার অ্যাপ্লিকেশন পরীক্ষা করা

লারাভেল পরীক্ষার জন্য PHPUnit অন্তর্ভুক্ত করে:

```bash
# সমস্ত পরীক্ষা চালান
php artisan test

# নির্দিষ্ট পরীক্ষা চালান
php artisan test --filter UserTest

# পরীক্ষা কভারেজ তৈরি করুন
php artisan test --coverage
```

## পরবর্তী পদক্ষেপ

এখন যেহেতু আপনার লারাভেল ১১ সেট আপ রয়েছে, অন্বেষণ করার কথা বিবেচনা করুন:

1. **Eloquent ORM**: উন্নত ডাটাবেস সম্পর্ক এবং কোয়েরি
2. **ফর্ম অনুরোধ**: যাচাইকরণ এবং অনুমোদন
3. **জবস এবং কিউ**: ব্যাকগ্রাউন্ড টাস্ক প্রসেসিং
4. **ইভেন্ট এবং লিসেনার**: বিচ্ছিন্ন অ্যাপ্লিকেশন লজিক
5. **API রিসোর্স**: JSON API প্রতিক্রিয়া
6. **লারাভেল স্যাঙ্কটাম**: API প্রমাণীকরণ
7. **লারাভেল হরাইজন**: কিউ মনিটরিং
8. **লারাভেল টেলিস্কোপ**: অ্যাপ্লিকেশন ডিবাগিং

## উপসংহার

লারাভেল ১১ আধুনিক ওয়েব অ্যাপ্লিকেশন তৈরির জন্য একটি শক্ত ভিত্তি প্রদান করে। এর মার্জিত সিনট্যাক্স, শক্তিশালী বৈশিষ্ট্য এবং বিস্তৃত ইকোসিস্টেম সহ, আপনি আশ্চর্যজনক অ্যাপ্লিকেশন তৈরি করার জন্য ভালভাবে সজ্জিত।

ছোট প্রকল্প দিয়ে শুরু করুন, বিভিন্ন বৈশিষ্ট্য নিয়ে পরীক্ষা করুন এবং ফ্রেমওয়ার্কের সাথে স্বাচ্ছন্দ্য বোধ করার সাথে সাথে ধীরে ধীরে আরও জটিল অ্যাপ্লিকেশন তৈরি করুন।

শুভ কোডিং! 🚀
MARKDOWN;
    }

    private function getJavaScriptContentEn(): string
    {
        return <<<'MARKDOWN'
# Modern JavaScript ES6+ Features Every Developer Should Know

JavaScript has evolved significantly since ES6 (ES2015), introducing powerful features that have transformed how we write modern applications. This guide covers the most important ES6+ features that every developer should master.

## Arrow Functions

Arrow functions provide a more concise way to write functions and have lexical `this` binding.

### Basic Syntax

```javascript
// Traditional function
function add(a, b) {
    return a + b;
}

// Arrow function
const add = (a, b) => a + b;

// With single parameter (parentheses optional)
const square = x => x * x;

// With no parameters
const greet = () => 'Hello World!';

// Multiple statements (braces required)
const calculate = (x, y) => {
    const sum = x + y;
    return sum * 2;
};
```

### Lexical `this` Binding

```javascript
class Timer {
    constructor() {
        this.seconds = 0;
    }

    start() {
        // Arrow function preserves 'this' context
        setInterval(() => {
            this.seconds++;
            console.log(this.seconds);
        }, 1000);
    }
}
```

## Destructuring Assignment

Destructuring allows you to extract values from arrays and objects into distinct variables.

### Array Destructuring

```javascript
const colors = ['red', 'green', 'blue'];

// Traditional way
const first = colors[0];
const second = colors[1];

// Destructuring
const [first, second, third] = colors;

// Skip elements
const [first, , third] = colors;

// Default values
const [first, second, third, fourth = 'yellow'] = colors;

// Rest operator
const [first, ...rest] = colors;
console.log(rest); // ['green', 'blue']
```

### Object Destructuring

```javascript
const user = {
    name: 'John Doe',
    age: 30,
    email: 'john@example.com',
    address: {
        city: 'New York',
        country: 'USA'
    }
};

// Basic destructuring
const { name, age, email } = user;

// Rename variables
const { name: userName, age: userAge } = user;

// Default values
const { name, phone = 'N/A' } = user;

// Nested destructuring
const { address: { city, country } } = user;

// Function parameters
function greetUser({ name, age }) {
    console.log(`Hello ${name}, you are ${age} years old`);
}
greetUser(user);
```

## Template Literals

Template literals provide an easy way to create strings with embedded expressions.

```javascript
const name = 'Alice';
const age = 25;

// Traditional string concatenation
const message1 = 'Hello, my name is ' + name + ' and I am ' + age + ' years old.';

// Template literals
const message2 = `Hello, my name is ${name} and I am ${age} years old.`;

// Multi-line strings
const html = `
    <div class="user">
        <h1>${name}</h1>
        <p>Age: ${age}</p>
    </div>
`;

// Tagged template literals
function highlight(strings, ...values) {
    return strings.reduce((result, string, i) => {
        const value = values[i] ? `<mark>${values[i]}</mark>` : '';
        return result + string + value;
    }, '');
}

const highlighted = highlight`Hello ${name}, you are ${age} years old`;
```

## Spread Operator

The spread operator allows you to expand arrays, objects, and other iterables.

### Array Operations

```javascript
const arr1 = [1, 2, 3];
const arr2 = [4, 5, 6];

// Combine arrays
const combined = [...arr1, ...arr2]; // [1, 2, 3, 4, 5, 6]

// Copy array
const copy = [...arr1];

// Add elements
const extended = [0, ...arr1, 7, 8]; // [0, 1, 2, 3, 7, 8]

// Function arguments
function sum(a, b, c) {
    return a + b + c;
}
console.log(sum(...arr1)); // 6
```

### Object Operations

```javascript
const obj1 = { a: 1, b: 2 };
const obj2 = { c: 3, d: 4 };

// Combine objects
const combined = { ...obj1, ...obj2 }; // { a: 1, b: 2, c: 3, d: 4 }

// Copy object
const copy = { ...obj1 };

// Override properties
const updated = { ...obj1, b: 5 }; // { a: 1, b: 5 }
```

## Rest Parameters

Rest parameters allow you to represent an indefinite number of arguments as an array.

```javascript
// Gather remaining arguments
function sum(...numbers) {
    return numbers.reduce((total, num) => total + num, 0);
}

console.log(sum(1, 2, 3, 4, 5)); // 15

// Mix with regular parameters
function introduce(name, age, ...hobbies) {
    console.log(`Hi, I'm ${name}, ${age} years old`);
    console.log(`My hobbies are: ${hobbies.join(', ')}`);
}

introduce('John', 25, 'reading', 'coding', 'gaming');
```

## Enhanced Object Literals

ES6 provides shortcuts for creating objects.

```javascript
const name = 'John';
const age = 30;

// Shorthand property names
const user = { name, age }; // { name: 'John', age: 30 }

// Computed property names
const property = 'email';
const user2 = {
    name: 'John',
    [property]: 'john@example.com'
};

// Method shorthand
const calculator = {
    // Instead of: add: function(a, b) { return a + b; }
    add(a, b) {
        return a + b;
    },
    
    multiply(a, b) {
        return a * b;
    }
};
```

## Promises and Async/Await

Modern JavaScript provides elegant ways to handle asynchronous operations.

### Promises

```javascript
// Creating a promise
function fetchUser(id) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (id > 0) {
                resolve({ id, name: `User ${id}` });
            } else {
                reject(new Error('Invalid user ID'));
            }
        }, 1000);
    });
}

// Using promises
fetchUser(1)
    .then(user => {
        console.log('User:', user);
        return fetchUserPosts(user.id);
    })
    .then(posts => {
        console.log('Posts:', posts);
    })
    .catch(error => {
        console.error('Error:', error.message);
    });

// Promise.all for parallel execution
Promise.all([
    fetchUser(1),
    fetchUser(2),
    fetchUser(3)
])
.then(users => {
    console.log('All users:', users);
});
```

### Async/Await

```javascript
// Async function
async function getUserData(id) {
    try {
        const user = await fetchUser(id);
        const posts = await fetchUserPosts(user.id);
        return { user, posts };
    } catch (error) {
        console.error('Error:', error.message);
        throw error;
    }
}

// Using async/await
async function main() {
    try {
        const userData = await getUserData(1);
        console.log('User data:', userData);
    } catch (error) {
        console.error('Failed to get user data');
    }
}

// Parallel execution with async/await
async function getAllUsers() {
    try {
        const users = await Promise.all([
            fetchUser(1),
            fetchUser(2),
            fetchUser(3)
        ]);
        return users;
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}
```

## Classes

ES6 introduced class syntax for creating objects and handling inheritance.

```javascript
// Basic class
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }

    // Method
    introduce() {
        return `Hi, I'm ${this.name} and I'm ${this.age} years old`;
    }

    // Static method
    static species() {
        return 'Homo sapiens';
    }
}

// Inheritance
class Developer extends Person {
    constructor(name, age, language) {
        super(name, age);
        this.language = language;
    }

    // Override method
    introduce() {
        return `${super.introduce()} and I code in ${this.language}`;
    }

    code() {
        return `${this.name} is coding in ${this.language}`;
    }
}

// Usage
const dev = new Developer('Alice', 28, 'JavaScript');
console.log(dev.introduce());
console.log(dev.code());
console.log(Developer.species());
```

## Modules (Import/Export)

ES6 modules provide a way to organize and share code between files.

### Exporting

```javascript
// math.js - Named exports
export const PI = 3.14159;

export function add(a, b) {
    return a + b;
}

export function multiply(a, b) {
    return a * b;
}

// Default export
export default function divide(a, b) {
    return a / b;
}

// Alternative syntax
const subtract = (a, b) => a - b;
export { subtract };
```

### Importing

```javascript
// app.js
// Import default export
import divide from './math.js';

// Import named exports
import { add, multiply, PI } from './math.js';

// Import with alias
import { subtract as minus } from './math.js';

// Import all
import * as Math from './math.js';

// Usage
console.log(add(5, 3)); // 8
console.log(Math.PI); // 3.14159
console.log(divide(10, 2)); // 5
```

## Map and Set

New collection types for storing data.

### Map

```javascript
// Create a Map
const userRoles = new Map();

// Set values
userRoles.set('john', 'admin');
userRoles.set('jane', 'user');
userRoles.set('bob', 'moderator');

// Get values
console.log(userRoles.get('john')); // 'admin'

// Check if key exists
console.log(userRoles.has('jane')); // true

// Delete entry
userRoles.delete('bob');

// Iterate
for (const [user, role] of userRoles) {
    console.log(`${user}: ${role}`);
}

// Map with object keys
const cache = new Map();
const user1 = { id: 1 };
const user2 = { id: 2 };

cache.set(user1, 'cached data for user 1');
cache.set(user2, 'cached data for user 2');
```

### Set

```javascript
// Create a Set
const uniqueNumbers = new Set([1, 2, 3, 3, 4, 4, 5]);
console.log(uniqueNumbers); // Set {1, 2, 3, 4, 5}

// Add values
uniqueNumbers.add(6);
uniqueNumbers.add(3); // Won't be added (already exists)

// Check if value exists
console.log(uniqueNumbers.has(3)); // true

// Delete value
uniqueNumbers.delete(2);

// Convert to array
const array = [...uniqueNumbers];

// Remove duplicates from array
const numbers = [1, 2, 2, 3, 3, 4, 5];
const unique = [...new Set(numbers)];
```

## Array Methods

ES6+ introduced many useful array methods.

```javascript
const numbers = [1, 2, 3, 4, 5];
const users = [
    { name: 'John', age: 25 },
    { name: 'Jane', age: 30 },
    { name: 'Bob', age: 35 }
];

// find - returns first matching element
const user = users.find(u => u.age > 28);
console.log(user); // { name: 'Jane', age: 30 }

// findIndex - returns index of first matching element
const index = users.findIndex(u => u.name === 'Bob');
console.log(index); // 2

// includes - checks if array contains value
console.log(numbers.includes(3)); // true

// some - tests if at least one element passes test
const hasAdult = users.some(u => u.age >= 18);
console.log(hasAdult); // true

// every - tests if all elements pass test
const allAdults = users.every(u => u.age >= 18);
console.log(allAdults); // true

// Array.from - creates array from iterable
const str = 'hello';
const chars = Array.from(str);
console.log(chars); // ['h', 'e', 'l', 'l', 'o']
```

## Best Practices

1. **Use `const` and `let` instead of `var`**
2. **Prefer arrow functions for callbacks**
3. **Use template literals for string interpolation**
4. **Destructure objects and arrays when appropriate**
5. **Use async/await for cleaner asynchronous code**
6. **Leverage array methods instead of loops when possible**
7. **Use modules to organize code**

## Conclusion

These ES6+ features have revolutionized JavaScript development, making code more readable, maintainable, and powerful. Start incorporating these features into your projects to write more modern and efficient JavaScript code.

Practice these concepts regularly, and you'll find yourself writing cleaner, more expressive JavaScript that's easier to understand and maintain.
MARKDOWN;
    }

    private function getJavaScriptContentBn(): string
    {
        return <<<'MARKDOWN'
# আধুনিক জাভাস্ক্রিপ্ট ES6+ ফিচার যা প্রতিটি ডেভেলপারের জানা উচিত

ES6 (ES2015) এর পর থেকে জাভাস্ক্রিপ্ট উল্লেখযোগ্যভাবে বিকশিত হয়েছে, শক্তিশালী বৈশিষ্ট্য প্রবর্তন করেছে যা আমরা কীভাবে আধুনিক অ্যাপ্লিকেশনগুলি লিখি তা রূপান্তরিত করেছে। এই গাইডটি সবচেয়ে গুরুত্বপূর্ণ ES6+ বৈশিষ্ট্যগুলি কভার করে যা প্রতিটি ডেভেলপারের আয়ত্ত করা উচিত।

## অ্যারো ফাংশন

অ্যারো ফাংশনগুলি ফাংশন লেখার আরও সংক্ষিপ্ত উপায় প্রদান করে এবং লেক্সিক্যাল `this` বাইন্ডিং রয়েছে।

### মৌলিক সিনট্যাক্স

```javascript
// ঐতিহ্যগত ফাংশন
function add(a, b) {
    return a + b;
}

// অ্যারো ফাংশন
const add = (a, b) => a + b;

// একক প্যারামিটার সহ (প্যারেন্থেসিস ঐচ্ছিক)
const square = x => x * x;

// কোন প্যারামিটার ছাড়া
const greet = () => 'হ্যালো ওয়ার্ল্ড!';

// একাধিক স্টেটমেন্ট (ব্রেস প্রয়োজন)
const calculate = (x, y) => {
    const sum = x + y;
    return sum * 2;
};
```

### লেক্সিক্যাল `this` বাইন্ডিং

```javascript
class Timer {
    constructor() {
        this.seconds = 0;
    }

    start() {
        // অ্যারো ফাংশন 'this' কনটেক্সট সংরক্ষণ করে
        setInterval(() => {
            this.seconds++;
            console.log(this.seconds);
        }, 1000);
    }
}
```

## ডেস্ট্রাকচারিং অ্যাসাইনমেন্ট

ডেস্ট্রাকচারিং আপনাকে অ্যারে এবং অবজেক্ট থেকে আলাদা ভেরিয়েবলে মান বের করতে দেয়।

### অ্যারে ডেস্ট্রাকচারিং

```javascript
const colors = ['লাল', 'সবুজ', 'নীল'];

// ঐতিহ্যগত উপায়
const first = colors[0];
const second = colors[1];

// ডেস্ট্রাকচারিং
const [first, second, third] = colors;

// এলিমেন্ট এড়িয়ে যান
const [first, , third] = colors;

// ডিফল্ট মান
const [first, second, third, fourth = 'হলুদ'] = colors;

// রেস্ট অপারেটর
const [first, ...rest] = colors;
console.log(rest); // ['সবুজ', 'নীল']
```

### অবজেক্ট ডেস্ট্রাকচারিং

```javascript
const user = {
    name: 'জন ডো',
    age: 30,
    email: 'john@example.com',
    address: {
        city: 'নিউ ইয়র্ক',
        country: 'যুক্তরাষ্ট্র'
    }
};

// মৌলিক ডেস্ট্রাকচারিং
const { name, age, email } = user;

// ভেরিয়েবল পুনঃনামকরণ
const { name: userName, age: userAge } = user;

// ডিফল্ট মান
const { name, phone = 'প্রযোজ্য নয়' } = user;

// নেস্টেড ডেস্ট্রাকচারিং
const { address: { city, country } } = user;

// ফাংশন প্যারামিটার
function greetUser({ name, age }) {
    console.log(`হ্যালো ${name}, আপনার বয়স ${age} বছর`);
}
greetUser(user);
```

## টেমপ্লেট লিটারেল

টেমপ্লেট লিটারেলগুলি এমবেডেড এক্সপ্রেশন সহ স্ট্রিং তৈরির একটি সহজ উপায় প্রদান করে।

```javascript
const name = 'এলিস';
const age = 25;

// ঐতিহ্যগত স্ট্রিং কনক্যাটেনেশন
const message1 = 'হ্যালো, আমার নাম ' + name + ' এবং আমার বয়স ' + age + ' বছর।';

// টেমপ্লেট লিটারেল
const message2 = `হ্যালো, আমার নাম ${name} এবং আমার বয়স ${age} বছর।`;

// মাল্টি-লাইন স্ট্রিং
const html = `
    <div class="user">
        <h1>${name}</h1>
        <p>বয়স: ${age}</p>
    </div>
`;

// ট্যাগড টেমপ্লেট লিটারেল
function highlight(strings, ...values) {
    return strings.reduce((result, string, i) => {
        const value = values[i] ? `<mark>${values[i]}</mark>` : '';
        return result + string + value;
    }, '');
}

const highlighted = highlight`হ্যালো ${name}, আপনার বয়স ${age} বছর`;
```

## স্প্রেড অপারেটর

স্প্রেড অপারেটর আপনাকে অ্যারে, অবজেক্ট এবং অন্যান্য ইটারেবল সম্প্রসারিত করতে দেয়।

### অ্যারে অপারেশন

```javascript
const arr1 = [1, 2, 3];
const arr2 = [4, 5, 6];

// অ্যারে একত্রিত করুন
const combined = [...arr1, ...arr2]; // [1, 2, 3, 4, 5, 6]

// অ্যারে কপি করুন
const copy = [...arr1];

// এলিমেন্ট যোগ করুন
const extended = [0, ...arr1, 7, 8]; // [0, 1, 2, 3, 7, 8]

// ফাংশন আর্গুমেন্ট
function sum(a, b, c) {
    return a + b + c;
}
console.log(sum(...arr1)); // 6
```

### অবজেক্ট অপারেশন

```javascript
const obj1 = { a: 1, b: 2 };
const obj2 = { c: 3, d: 4 };

// অবজেক্ট একত্রিত করুন
const combined = { ...obj1, ...obj2 }; // { a: 1, b: 2, c: 3, d: 4 }

// অবজেক্ট কপি করুন
const copy = { ...obj1 };

// প্রোপার্টি ওভাররাইড করুন
const updated = { ...obj1, b: 5 }; // { a: 1, b: 5 }
```

## রেস্ট প্যারামিটার

রেস্ট প্যারামিটার আপনাকে একটি অ্যারে হিসাবে অনির্দিষ্ট সংখ্যক আর্গুমেন্ট উপস্থাপন করতে দেয়।

```javascript
// অবশিষ্ট আর্গুমেন্ট সংগ্রহ করুন
function sum(...numbers) {
    return numbers.reduce((total, num) => total + num, 0);
}

console.log(sum(1, 2, 3, 4, 5)); // 15

// নিয়মিত প্যারামিটারের সাথে মিশ্রিত করুন
function introduce(name, age, ...hobbies) {
    console.log(`হাই, আমি ${name}, ${age} বছর বয়সী`);
    console.log(`আমার শখ হলো: ${hobbies.join(', ')}`);
}

introduce('জন', 25, 'পড়া', 'কোডিং', 'গেমিং');
```

## উন্নত অবজেক্ট লিটারেল

ES6 অবজেক্ট তৈরির জন্য শর্টকাট প্রদান করে।

```javascript
const name = 'জন';
const age = 30;

// সংক্ষিপ্ত প্রোপার্টি নাম
const user = { name, age }; // { name: 'জন', age: 30 }

// গণনাকৃত প্রোপার্টি নাম
const property = 'email';
const user2 = {
    name: 'জন',
    [property]: 'john@example.com'
};

// মেথড সংক্ষিপ্তকরণ
const calculator = {
    // এর পরিবর্তে: add: function(a, b) { return a + b; }
    add(a, b) {
        return a + b;
    },
    
    multiply(a, b) {
        return a * b;
    }
};
```

## প্রমিস এবং Async/Await

আধুনিক জাভাস্ক্রিপ্ট অ্যাসিঙ্ক্রোনাস অপারেশন পরিচালনার জন্য মার্জিত উপায় প্রদান করে।

### প্রমিস

```javascript
// একটি প্রমিস তৈরি করা
function fetchUser(id) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (id > 0) {
                resolve({ id, name: `ব্যবহারকারী ${id}` });
            } else {
                reject(new Error('অবৈধ ব্যবহারকারী আইডি'));
            }
        }, 1000);
    });
}

// প্রমিস ব্যবহার করা
fetchUser(1)
    .then(user => {
        console.log('ব্যবহারকারী:', user);
        return fetchUserPosts(user.id);
    })
    .then(posts => {
        console.log('পোস্ট:', posts);
    })
    .catch(error => {
        console.error('ত্রুটি:', error.message);
    });

// সমান্তরাল এক্সিকিউশনের জন্য Promise.all
Promise.all([
    fetchUser(1),
    fetchUser(2),
    fetchUser(3)
])
.then(users => {
    console.log('সমস্ত ব্যবহারকারী:', users);
});
```

### Async/Await

```javascript
// অ্যাসিঙ্ক ফাংশন
async function getUserData(id) {
    try {
        const user = await fetchUser(id);
        const posts = await fetchUserPosts(user.id);
        return { user, posts };
    } catch (error) {
        console.error('ত্রুটি:', error.message);
        throw error;
    }
}

// async/await ব্যবহার করা
async function main() {
    try {
        const userData = await getUserData(1);
        console.log('ব্যবহারকারীর ডেটা:', userData);
    } catch (error) {
        console.error('ব্যবহারকারীর ডেটা পেতে ব্যর্থ');
    }
}

// async/await সহ সমান্তরাল এক্সিকিউশন
async function getAllUsers() {
    try {
        const users = await Promise.all([
            fetchUser(1),
            fetchUser(2),
            fetchUser(3)
        ]);
        return users;
    } catch (error) {
        console.error('ব্যবহারকারী আনতে ত্রুটি:', error);
    }
}
```

## ক্লাস

ES6 অবজেক্ট তৈরি এবং উত্তরাধিকার পরিচালনার জন্য ক্লাস সিনট্যাক্স প্রবর্তন করেছে।

```javascript
// মৌলিক ক্লাস
class Person {
    constructor(name, age) {
        this.name = name;
        this.age = age;
    }

    // মেথড
    introduce() {
        return `হাই, আমি ${this.name} এবং আমার বয়স ${this.age} বছর`;
    }

    // স্ট্যাটিক মেথড
    static species() {
        return 'হোমো সেপিয়েন্স';
    }
}

// উত্তরাধিকার
class Developer extends Person {
    constructor(name, age, language) {
        super(name, age);
        this.language = language;
    }

    // মেথড ওভাররাইড
    introduce() {
        return `${super.introduce()} এবং আমি ${this.language} এ কোড করি`;
    }

    code() {
        return `${this.name} ${this.language} এ কোডিং করছেন`;
    }
}

// ব্যবহার
const dev = new Developer('এলিস', 28, 'জাভাস্ক্রিপ্ট');
console.log(dev.introduce());
console.log(dev.code());
console.log(Developer.species());
```

## মডিউল (Import/Export)

ES6 মডিউলগুলি ফাইলের মধ্যে কোড সংগঠিত এবং ভাগ করার একটি উপায় প্রদান করে।

### এক্সপোর্ট করা

```javascript
// math.js - নেমড এক্সপোর্ট
export const PI = 3.14159;

export function add(a, b) {
    return a + b;
}

export function multiply(a, b) {
    return a * b;
}

// ডিফল্ট এক্সপোর্ট
export default function divide(a, b) {
    return a / b;
}

// বিকল্প সিনট্যাক্স
const subtract = (a, b) => a - b;
export { subtract };
```

### ইমপোর্ট করা

```javascript
// app.js
// ডিফল্ট এক্সপোর্ট ইমপোর্ট
import divide from './math.js';

// নেমড এক্সপোর্ট ইমপোর্ট
import { add, multiply, PI } from './math.js';

// এলিয়াস সহ ইমপোর্ট
import { subtract as minus } from './math.js';

// সব ইমপোর্ট
import * as Math from './math.js';

// ব্যবহার
console.log(add(5, 3)); // 8
console.log(Math.PI); // 3.14159
console.log(divide(10, 2)); // 5
```

## Map এবং Set

ডেটা সংরক্ষণের জন্য নতুন সংগ্রহের ধরন।

### Map

```javascript
// একটি Map তৈরি করুন
const userRoles = new Map();

// মান সেট করুন
userRoles.set('john', 'admin');
userRoles.set('jane', 'user');
userRoles.set('bob', 'moderator');

// মান পান
console.log(userRoles.get('john')); // 'admin'

// চাবি বিদ্যমান কিনা পরীক্ষা করুন
console.log(userRoles.has('jane')); // true

// এন্ট্রি মুছুন
userRoles.delete('bob');

// পুনরাবৃত্তি
for (const [user, role] of userRoles) {
    console.log(`${user}: ${role}`);
}

// অবজেক্ট চাবি সহ Map
const cache = new Map();
const user1 = { id: 1 };
const user2 = { id: 2 };

cache.set(user1, 'ব্যবহারকারী 1 এর জন্য ক্যাশ করা ডেটা');
cache.set(user2, 'ব্যবহারকারী 2 এর জন্য ক্যাশ করা ডেটা');
```

### Set

```javascript
// একটি Set তৈরি করুন
const uniqueNumbers = new Set([1, 2, 3, 3, 4, 4, 5]);
console.log(uniqueNumbers); // Set {1, 2, 3, 4, 5}

// মান যোগ করুন
uniqueNumbers.add(6);
uniqueNumbers.add(3); // যোগ হবে না (ইতিমধ্যে বিদ্যমান)

// মান বিদ্যমান কিনা পরীক্ষা করুন
console.log(uniqueNumbers.has(3)); // true

// মান মুছুন
uniqueNumbers.delete(2);

// অ্যারেতে রূপান্তর করুন
const array = [...uniqueNumbers];

// অ্যারে থেকে ডুপ্লিকেট সরান
const numbers = [1, 2, 2, 3, 3, 4, 5];
const unique = [...new Set(numbers)];
```

## অ্যারে মেথড

ES6+ অনেক দরকারী অ্যারে মেথড প্রবর্তন করেছে।

```javascript
const numbers = [1, 2, 3, 4, 5];
const users = [
    { name: 'জন', age: 25 },
    { name: 'জেন', age: 30 },
    { name: 'বব', age: 35 }
];

// find - প্রথম মিলিং এলিমেন্ট ফেরত দেয়
const user = users.find(u => u.age > 28);
console.log(user); // { name: 'জেন', age: 30 }

// findIndex - প্রথম মিলিং এলিমেন্টের ইনডেক্স ফেরত দেয়
const index = users.findIndex(u => u.name === 'বব');
console.log(index); // 2

// includes - অ্যারেতে মান রয়েছে কিনা পরীক্ষা করে
console.log(numbers.includes(3)); // true

// some - কমপক্ষে একটি এলিমেন্ট পরীক্ষা পাস করে কিনা পরীক্ষা করে
const hasAdult = users.some(u => u.age >= 18);
console.log(hasAdult); // true

// every - সব এলিমেন্ট পরীক্ষা পাস করে কিনা পরীক্ষা করে
const allAdults = users.every(u => u.age >= 18);
console.log(allAdults); // true

// Array.from - ইটারেবল থেকে অ্যারে তৈরি করে
const str = 'hello';
const chars = Array.from(str);
console.log(chars); // ['h', 'e', 'l', 'l', 'o']
```

## সর্বোত্তম অনুশীলন

1. **`var` এর পরিবর্তে `const` এবং `let` ব্যবহার করুন**
2. **কলব্যাকের জন্য অ্যারো ফাংশন পছন্দ করুন**
3. **স্ট্রিং ইন্টারপোলেশনের জন্য টেমপ্লেট লিটারেল ব্যবহার করুন**
4. **উপযুক্ত হলে অবজেক্ট এবং অ্যারে ডেস্ট্রাকচার করুন**
5. **পরিষ্কার অ্যাসিঙ্ক্রোনাস কোডের জন্য async/await ব্যবহার করুন**
6. **সম্ভব হলে লুপের পরিবর্তে অ্যারে মেথড ব্যবহার করুন**
7. **কোড সংগঠিত করতে মডিউল ব্যবহার করুন**

## উপসংহার

এই ES6+ বৈশিষ্ট্যগুলি জাভাস্ক্রিপ্ট ডেভেলপমেন্টে বিপ্লব এনেছে, কোডকে আরও পড়ার যোগ্য, রক্ষণাবেক্ষণযোগ্য এবং শক্তিশালী করে তুলেছে। আরও আধুনিক এবং দক্ষ জাভাস্ক্রিপ্ট কোড লেখার জন্য আপনার প্রকল্পগুলিতে এই বৈশিষ্ট্যগুলি অন্তর্ভুক্ত করা শুরু করুন।

এই ধারণাগুলি নিয়মিত অনুশীলন করুন, এবং আপনি নিজেকে পরিষ্কার, আরও অভিব্যক্তিপূর্ণ জাভাস্ক্রিপ্ট লিখতে দেখবেন যা বুঝতে এবং রক্ষণাবেক্ষণ করা সহজ।
MARKDOWN;
    }

    private function getDatabaseOptimizationContentEn(): string 
    {
        return <<<'MARKDOWN'
# Database Optimization Tips for Better Performance

Database performance is crucial for any application's success. This comprehensive guide covers essential optimization techniques to improve query execution time and overall database efficiency.

## Understanding Database Performance

Before diving into optimization techniques, it's important to understand what affects database performance:

- **Query complexity and structure**
- **Index usage and design**
- **Database schema design**
- **Hardware resources (CPU, Memory, Storage)**
- **Database configuration**
- **Concurrent users and connections**

## Index Optimization

Indexes are the most powerful tool for improving query performance.

### Creating Effective Indexes

```sql
-- Single column index
CREATE INDEX idx_users_email ON users(email);

-- Composite index (order matters!)
CREATE INDEX idx_orders_user_date ON orders(user_id, created_at);

-- Partial index (PostgreSQL)
CREATE INDEX idx_active_users ON users(id) WHERE active = true;

-- Covering index (includes additional columns)
CREATE INDEX idx_users_name_email ON users(name) INCLUDE (email, phone);
```

### Index Best Practices

1. **Index on frequently queried columns**
2. **Consider composite indexes for multi-column WHERE clauses**
3. **Order matters in composite indexes** - put most selective column first
4. **Don't over-index** - each index has maintenance overhead
5. **Monitor unused indexes** and remove them

### Checking Index Usage

```sql
-- MySQL: Check if query uses index
EXPLAIN SELECT * FROM users WHERE email = 'user@example.com';

-- PostgreSQL: Detailed execution plan
EXPLAIN (ANALYZE, BUFFERS) 
SELECT * FROM users WHERE email = 'user@example.com';

-- Find unused indexes (PostgreSQL)
SELECT schemaname, tablename, indexname, idx_tup_read, idx_tup_fetch
FROM pg_stat_user_indexes
WHERE idx_tup_read = 0;
```

## Query Optimization

### Writing Efficient Queries

```sql
-- BAD: Using functions in WHERE clause
SELECT * FROM orders 
WHERE YEAR(created_at) = 2024;

-- GOOD: Use range conditions
SELECT * FROM orders 
WHERE created_at >= '2024-01-01' 
  AND created_at < '2025-01-01';

-- BAD: Using OR conditions
SELECT * FROM users 
WHERE city = 'New York' OR city = 'Los Angeles';

-- GOOD: Use IN clause
SELECT * FROM users 
WHERE city IN ('New York', 'Los Angeles');

-- BAD: Wildcard at beginning
SELECT * FROM products 
WHERE name LIKE '%phone%';

-- GOOD: Wildcard at end (can use index)
SELECT * FROM products 
WHERE name LIKE 'iPhone%';
```

### Avoiding Common Pitfalls

```sql
-- BAD: SELECT * (returns unnecessary data)
SELECT * FROM users WHERE active = 1;

-- GOOD: Select only needed columns
SELECT id, name, email FROM users WHERE active = 1;

-- BAD: No LIMIT on potentially large results
SELECT * FROM logs WHERE created_at > '2024-01-01';

-- GOOD: Use LIMIT and pagination
SELECT * FROM logs 
WHERE created_at > '2024-01-01' 
ORDER BY created_at DESC 
LIMIT 100 OFFSET 0;
```

### Using EXISTS vs IN

```sql
-- Use EXISTS for better performance when checking relationships
-- GOOD: Using EXISTS
SELECT u.* FROM users u 
WHERE EXISTS (
    SELECT 1 FROM orders o 
    WHERE o.user_id = u.id AND o.status = 'completed'
);

-- Alternative: Using IN (can be slower with large datasets)
SELECT * FROM users 
WHERE id IN (
    SELECT DISTINCT user_id FROM orders 
    WHERE status = 'completed'
);
```

## Schema Design Optimization

### Normalization vs Denormalization

**Normalization Benefits:**
- Reduces data redundancy
- Ensures data consistency
- Saves storage space

**When to Denormalize:**
- Read-heavy applications
- Complex joins are causing performance issues
- Data warehousing scenarios

```sql
-- Normalized (good for write-heavy applications)
CREATE TABLE orders (
    id INT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    created_at TIMESTAMP
);

CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);

-- Denormalized (good for read-heavy applications)
CREATE TABLE orders_denormalized (
    id INT PRIMARY KEY,
    user_id INT,
    user_name VARCHAR(100),  -- Denormalized from users table
    user_email VARCHAR(100), -- Denormalized from users table
    total_amount DECIMAL(10,2),
    created_at TIMESTAMP
);
```

### Choosing Right Data Types

```sql
-- BAD: Using VARCHAR for fixed-length data
CREATE TABLE users (
    phone VARCHAR(255)  -- Wasteful for phone numbers
);

-- GOOD: Use appropriate size
CREATE TABLE users (
    phone VARCHAR(15)   -- Sufficient for international phone numbers
);

-- BAD: Using TEXT for short strings
CREATE TABLE products (
    sku TEXT           -- Overkill for product SKUs
);

-- GOOD: Use VARCHAR with appropriate length
CREATE TABLE products (
    sku VARCHAR(50)    -- Adequate for most SKU formats
);

-- Use INT instead of VARCHAR for numeric IDs
-- BAD
user_id VARCHAR(20)

-- GOOD
user_id INT UNSIGNED
```

## Connection and Resource Management

### Connection Pooling

```python
# Python example with SQLAlchemy
from sqlalchemy import create_engine
from sqlalchemy.pool import QueuePool

# Configure connection pool
engine = create_engine(
    'mysql://user:password@localhost/db',
    poolclass=QueuePool,
    pool_size=20,          # Number of connections to maintain
    max_overflow=30,       # Additional connections beyond pool_size
    pool_pre_ping=True,    # Validate connections before use
    pool_recycle=3600      # Recycle connections after 1 hour
)
```

### Query Timeout Configuration

```sql
-- MySQL: Set query timeout
SET SESSION max_execution_time = 30000; -- 30 seconds

-- PostgreSQL: Set statement timeout
SET statement_timeout = '30s';
```

## Caching Strategies

### Query Result Caching

```php
// Laravel example
class UserService {
    public function getActiveUsers() {
        return Cache::remember('active_users', 3600, function () {
            return User::where('active', true)->get();
        });
    }
    
    public function getUserById($id) {
        return Cache::remember("user_{$id}", 1800, function () use ($id) {
            return User::find($id);
        });
    }
}
```

### Database-Level Caching

```sql
-- MySQL Query Cache (deprecated in MySQL 8.0)
-- Use application-level caching instead

-- Redis caching example
SET user:123 '{"id":123,"name":"John","email":"john@example.com"}' EX 3600
GET user:123
```

## Monitoring and Analysis

### Key Metrics to Monitor

1. **Query execution time**
2. **CPU and memory usage**
3. **Index hit ratio**
4. **Connection count**
5. **Slow query log**
6. **Lock wait time**

### MySQL Performance Monitoring

```sql
-- Enable slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2; -- Log queries taking more than 2 seconds

-- Check current connections
SHOW PROCESSLIST;

-- Monitor key metrics
SHOW GLOBAL STATUS LIKE 'Innodb_buffer_pool_read_requests';
SHOW GLOBAL STATUS LIKE 'Innodb_buffer_pool_reads';

-- Calculate buffer pool hit ratio
SELECT 
  (1 - (Innodb_buffer_pool_reads / Innodb_buffer_pool_read_requests)) * 100 
  AS buffer_pool_hit_ratio;
```

### PostgreSQL Performance Monitoring

```sql
-- Enable query logging
ALTER SYSTEM SET log_statement = 'all';
ALTER SYSTEM SET log_min_duration_statement = 2000; -- Log slow queries

-- Check current connections and queries
SELECT pid, query, state, query_start 
FROM pg_stat_activity 
WHERE state = 'active';

-- Monitor table statistics
SELECT schemaname, tablename, n_tup_ins, n_tup_upd, n_tup_del
FROM pg_stat_user_tables;

-- Check index usage
SELECT indexrelname, idx_tup_read, idx_tup_fetch
FROM pg_stat_user_indexes;
```

## Database Configuration Optimization

### MySQL Configuration

```ini
# my.cnf optimizations
[mysqld]
# InnoDB Buffer Pool (set to 70-80% of available RAM)
innodb_buffer_pool_size = 4G

# Query cache (deprecated in MySQL 8.0)
query_cache_size = 256M
query_cache_type = 1

# Connection limits
max_connections = 200
max_user_connections = 180

# InnoDB settings
innodb_log_file_size = 1G
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = 1
```

### PostgreSQL Configuration

```conf
# postgresql.conf optimizations
# Memory settings
shared_buffers = 2GB                    # 25% of total RAM
effective_cache_size = 6GB              # 75% of total RAM
work_mem = 32MB                         # Per-operation memory
maintenance_work_mem = 512MB            # For maintenance operations

# Checkpoint settings
checkpoint_completion_target = 0.9
wal_buffers = 16MB

# Connection settings
max_connections = 200
```

## Partitioning for Large Tables

### Range Partitioning

```sql
-- MySQL partitioning by date
CREATE TABLE orders (
    id INT NOT NULL,
    user_id INT,
    order_date DATE,
    amount DECIMAL(10,2),
    PRIMARY KEY (id, order_date)
)
PARTITION BY RANGE (YEAR(order_date)) (
    PARTITION p2022 VALUES LESS THAN (2023),
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION future VALUES LESS THAN MAXVALUE
);

-- PostgreSQL table partitioning
CREATE TABLE orders (
    id SERIAL,
    user_id INT,
    order_date DATE,
    amount DECIMAL(10,2)
) PARTITION BY RANGE (order_date);

CREATE TABLE orders_2024 PARTITION OF orders
    FOR VALUES FROM ('2024-01-01') TO ('2025-01-01');
```

## Backup and Maintenance

### Regular Maintenance Tasks

```sql
-- MySQL: Optimize tables
OPTIMIZE TABLE users, orders, products;

-- Analyze tables for better query planning
ANALYZE TABLE users, orders, products;

-- PostgreSQL: Vacuum and analyze
VACUUM ANALYZE users;
VACUUM ANALYZE orders;

-- Update table statistics
ANALYZE users;
ANALYZE orders;
```

### Automated Maintenance

```bash
#!/bin/bash
# MySQL maintenance script
mysql -u root -p$MYSQL_PASSWORD -e "
    OPTIMIZE TABLE mydb.users;
    OPTIMIZE TABLE mydb.orders;
    ANALYZE TABLE mydb.users;
    ANALYZE TABLE mydb.orders;
"

# PostgreSQL maintenance script
psql -d mydb -c "VACUUM ANALYZE users;"
psql -d mydb -c "VACUUM ANALYZE orders;"
psql -d mydb -c "REINDEX DATABASE mydb;"
```

## Application-Level Optimizations

### Batch Operations

```php
// BAD: Individual inserts
foreach ($users as $user) {
    DB::table('users')->insert($user);
}

// GOOD: Batch insert
DB::table('users')->insert($users);

// GOOD: Use transactions for multiple operations
DB::transaction(function () use ($users) {
    foreach ($users as $user) {
        // Complex operations that must be atomic
        DB::table('users')->insert($user);
        DB::table('user_profiles')->insert($user['profile']);
    }
});
```

### Lazy Loading vs Eager Loading

```php
// BAD: N+1 query problem
$users = User::all();
foreach ($users as $user) {
    echo $user->profile->bio; // Triggers additional query for each user
}

// GOOD: Eager loading
$users = User::with('profile')->get();
foreach ($users as $user) {
    echo $user->profile->bio; // No additional queries
}
```

## Testing and Benchmarking

### Load Testing

```bash
# MySQL Benchmark
sysbench oltp_read_write \
  --mysql-host=localhost \
  --mysql-user=root \
  --mysql-password=password \
  --mysql-db=testdb \
  --tables=4 \
  --table-size=1000000 \
  --threads=16 \
  --time=300 \
  run

# PostgreSQL Benchmark
pgbench -i -s 50 testdb  # Initialize
pgbench -c 10 -j 2 -t 1000 testdb  # Run benchmark
```

## Conclusion

Database optimization is an ongoing process that requires:

1. **Regular monitoring** of performance metrics
2. **Proper indexing strategy** based on query patterns
3. **Efficient query writing** and avoiding common pitfalls
4. **Appropriate hardware resources** and configuration
5. **Caching strategies** to reduce database load
6. **Regular maintenance** tasks and updates

Remember that optimization is highly dependent on your specific use case, data patterns, and application requirements. Always measure performance before and after making changes, and consider the trade-offs between read and write performance.

Start with the most impactful optimizations (proper indexing and query optimization) before moving to advanced techniques like partitioning and complex caching strategies.
MARKDOWN;
    }

    private function getDatabaseOptimizationContentBn(): string
    {
        return <<<'MARKDOWN'
# ভাল পারফরম্যান্সের জন্য ডাটাবেস অপটিমাইজেশন টিপস

যেকোনো অ্যাপ্লিকেশনের সাফল্যের জন্য ডাটাবেস পারফরম্যান্স অত্যন্ত গুরুত্বপূর্ণ। এই ব্যাপক গাইডটি কোয়েরি এক্সিকিউশন সময় এবং সামগ্রিক ডাটাবেস দক্ষতা উন্নত করার জন্য প্রয়োজনীয় অপটিমাইজেশন কৌশল কভার করে।

## ডাটাবেস পারফরম্যান্স বোঝা

অপটিমাইজেশন কৌশলে যাওয়ার আগে, ডাটাবেস পারফরম্যান্সকে কী প্রভাবিত করে তা বোঝা গুরুত্বপূর্ণ:

- **কোয়েরি জটিলতা এবং কাঠামো**
- **ইনডেক্স ব্যবহার এবং ডিজাইন**
- **ডাটাবেস স্কিমা ডিজাইন**
- **হার্ডওয়্যার রিসোর্স (CPU, মেমরি, স্টোরেজ)**
- **ডাটাবেস কনফিগারেশন**
- **সমসাময়িক ব্যবহারকারী এবং সংযোগ**

## ইনডেক্স অপটিমাইজেশন

কোয়েরি পারফরম্যান্স উন্নত করার জন্য ইনডেক্স হল সবচেয়ে শক্তিশালী টুল।

### কার্যকর ইনডেক্স তৈরি করা

```sql
-- একক কলাম ইনডেক্স
CREATE INDEX idx_users_email ON users(email);

-- কম্পোজিট ইনডেক্স (ক্রম গুরুত্বপূর্ণ!)
CREATE INDEX idx_orders_user_date ON orders(user_id, created_at);

-- আংশিক ইনডেক্স (PostgreSQL)
CREATE INDEX idx_active_users ON users(id) WHERE active = true;

-- কভারিং ইনডেক্স (অতিরিক্ত কলাম অন্তর্ভুক্ত করে)
CREATE INDEX idx_users_name_email ON users(name) INCLUDE (email, phone);
```

### ইনডেক্স সর্বোত্তম অনুশীলন

1. **ঘন ঘন কোয়েরি করা কলামে ইনডেক্স করুন**
2. **মাল্টি-কলাম WHERE ক্লজের জন্য কম্পোজিট ইনডেক্স বিবেচনা করুন**
3. **কম্পোজিট ইনডেক্সে ক্রম গুরুত্বপূর্ণ** - সবচেয়ে নির্বাচনী কলাম প্রথমে রাখুন
4. **অতিরিক্ত ইনডেক্স করবেন না** - প্রতিটি ইনডেক্সের রক্ষণাবেক্ষণ খরচ আছে
5. **অব্যবহৃত ইনডেক্স মনিটর করুন** এবং সেগুলি সরিয়ে ফেলুন

### ইনডেক্স ব্যবহার পরীক্ষা করা

```sql
-- MySQL: কোয়েরি ইনডেক্স ব্যবহার করে কিনা পরীক্ষা করুন
EXPLAIN SELECT * FROM users WHERE email = 'user@example.com';

-- PostgreSQL: বিস্তারিত এক্সিকিউশন প্ল্যান
EXPLAIN (ANALYZE, BUFFERS) 
SELECT * FROM users WHERE email = 'user@example.com';

-- অব্যবহৃত ইনডেক্স খুঁজুন (PostgreSQL)
SELECT schemaname, tablename, indexname, idx_tup_read, idx_tup_fetch
FROM pg_stat_user_indexes
WHERE idx_tup_read = 0;
```

## কোয়েরি অপটিমাইজেশন

### দক্ষ কোয়েরি লেখা

```sql
-- খারাপ: WHERE ক্লজে ফাংশন ব্যবহার করা
SELECT * FROM orders 
WHERE YEAR(created_at) = 2024;

-- ভাল: রেঞ্জ শর্ত ব্যবহার করুন
SELECT * FROM orders 
WHERE created_at >= '2024-01-01' 
  AND created_at < '2025-01-01';

-- খারাপ: OR শর্ত ব্যবহার করা
SELECT * FROM users 
WHERE city = 'New York' OR city = 'Los Angeles';

-- ভাল: IN ক্লজ ব্যবহার করুন
SELECT * FROM users 
WHERE city IN ('New York', 'Los Angeles');

-- খারাপ: শুরুতে ওয়াইল্ডকার্ড
SELECT * FROM products 
WHERE name LIKE '%phone%';

-- ভাল: শেষে ওয়াইল্ডকার্ড (ইনডেক্স ব্যবহার করতে পারে)
SELECT * FROM products 
WHERE name LIKE 'iPhone%';
```

### সাধারণ ভুল এড়ানো

```sql
-- খারাপ: SELECT * (অপ্রয়োজনীয় ডেটা ফেরত দেয়)
SELECT * FROM users WHERE active = 1;

-- ভাল: শুধুমাত্র প্রয়োজনীয় কলাম নির্বাচন করুন
SELECT id, name, email FROM users WHERE active = 1;

-- খারাপ: সম্ভাব্য বড় ফলাফলে কোন LIMIT নেই
SELECT * FROM logs WHERE created_at > '2024-01-01';

-- ভাল: LIMIT এবং পেজিনেশন ব্যবহার করুন
SELECT * FROM logs 
WHERE created_at > '2024-01-01' 
ORDER BY created_at DESC 
LIMIT 100 OFFSET 0;
```

### EXISTS বনাম IN ব্যবহার করা

```sql
-- সম্পর্ক পরীক্ষা করার সময় ভাল পারফরম্যান্সের জন্য EXISTS ব্যবহার করুন
-- ভাল: EXISTS ব্যবহার করা
SELECT u.* FROM users u 
WHERE EXISTS (
    SELECT 1 FROM orders o 
    WHERE o.user_id = u.id AND o.status = 'completed'
);

-- বিকল্প: IN ব্যবহার করা (বড় ডেটাসেটের সাথে ধীর হতে পারে)
SELECT * FROM users 
WHERE id IN (
    SELECT DISTINCT user_id FROM orders 
    WHERE status = 'completed'
);
```

## স্কিমা ডিজাইন অপটিমাইজেশন

### নরমালাইজেশন বনাম ডিনরমালাইজেশন

**নরমালাইজেশনের সুবিধা:**
- ডেটা রিডানডেন্সি কমায়
- ডেটা সামঞ্জস্য নিশ্চিত করে
- স্টোরেজ স্পেস সাশ্রয় করে

**কখন ডিনরমালাইজ করবেন:**
- রিড-হেভি অ্যাপ্লিকেশন
- জটিল জয়েন পারফরম্যান্স সমস্যা সৃষ্টি করছে
- ডেটা ওয়্যারহাউসিং পরিস্থিতি

```sql
-- নরমালাইজড (রাইট-হেভি অ্যাপ্লিকেশনের জন্য ভাল)
CREATE TABLE orders (
    id INT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    created_at TIMESTAMP
);

CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);

-- ডিনরমালাইজড (রিড-হেভি অ্যাপ্লিকেশনের জন্য ভাল)
CREATE TABLE orders_denormalized (
    id INT PRIMARY KEY,
    user_id INT,
    user_name VARCHAR(100),  -- users টেবিল থেকে ডিনরমালাইজড
    user_email VARCHAR(100), -- users টেবিল থেকে ডিনরমালাইজড
    total_amount DECIMAL(10,2),
    created_at TIMESTAMP
);
```

### সঠিক ডেটা টাইপ নির্বাচন

```sql
-- খারাপ: ফিক্সড-লেন্থ ডেটার জন্য VARCHAR ব্যবহার করা
CREATE TABLE users (
    phone VARCHAR(255)  -- ফোন নম্বরের জন্য অপচয়কারী
);

-- ভাল: উপযুক্ত আকার ব্যবহার করুন
CREATE TABLE users (
    phone VARCHAR(15)   -- আন্তর্জাতিক ফোন নম্বরের জন্য যথেষ্ট
);

-- খারাপ: ছোট স্ট্রিংয়ের জন্য TEXT ব্যবহার করা
CREATE TABLE products (
    sku TEXT           -- প্রোডাক্ট SKU এর জন্য অতিরিক্ত
);

-- ভাল: উপযুক্ত দৈর্ঘ্য সহ VARCHAR ব্যবহার করুন
CREATE TABLE products (
    sku VARCHAR(50)    -- বেশিরভাগ SKU ফরম্যাটের জন্য পর্যাপ্ত
);

-- সংখ্যাসূচক ID এর জন্য VARCHAR এর পরিবর্তে INT ব্যবহার করুন
-- খারাপ
user_id VARCHAR(20)

-- ভাল
user_id INT UNSIGNED
```

## সংযোগ এবং রিসোর্স ব্যবস্থাপনা

### সংযোগ পুলিং

```python
# SQLAlchemy সহ Python উদাহরণ
from sqlalchemy import create_engine
from sqlalchemy.pool import QueuePool

# সংযোগ পুল কনফিগার করুন
engine = create_engine(
    'mysql://user:password@localhost/db',
    poolclass=QueuePool,
    pool_size=20,          # বজায় রাখার জন্য সংযোগের সংখ্যা
    max_overflow=30,       # pool_size এর বাইরে অতিরিক্ত সংযোগ
    pool_pre_ping=True,    # ব্যবহারের আগে সংযোগ যাচাই করুন
    pool_recycle=3600      # 1 ঘন্টা পর সংযোগ পুনর্ব্যবহার করুন
)
```

### কোয়েরি টাইমআউট কনফিগারেশন

```sql
-- MySQL: কোয়েরি টাইমআউট সেট করুন
SET SESSION max_execution_time = 30000; -- 30 সেকেন্ড

-- PostgreSQL: স্টেটমেন্ট টাইমআউট সেট করুন
SET statement_timeout = '30s';
```

## ক্যাশিং কৌশল

### কোয়েরি ফলাফল ক্যাশিং

```php
// Laravel উদাহরণ
class UserService {
    public function getActiveUsers() {
        return Cache::remember('active_users', 3600, function () {
            return User::where('active', true)->get();
        });
    }
    
    public function getUserById($id) {
        return Cache::remember("user_{$id}", 1800, function () use ($id) {
            return User::find($id);
        });
    }
}
```

### ডাটাবেস-লেভেল ক্যাশিং

```sql
-- MySQL Query Cache (MySQL 8.0 এ অবহেলিত)
-- এর পরিবর্তে অ্যাপ্লিকেশন-লেভেল ক্যাশিং ব্যবহার করুন

-- Redis ক্যাশিং উদাহরণ
SET user:123 '{"id":123,"name":"John","email":"john@example.com"}' EX 3600
GET user:123
```

## মনিটরিং এবং বিশ্লেষণ

### মনিটর করার মূল মেট্রিক্স

1. **কোয়েরি এক্সিকিউশন সময়**
2. **CPU এবং মেমরি ব্যবহার**
3. **ইনডেক্স হিট রেশিও**
4. **সংযোগ সংখ্যা**
5. **স্লো কোয়েরি লগ**
6. **লক অপেক্ষার সময়**

### MySQL পারফরম্যান্স মনিটরিং

```sql
-- স্লো কোয়েরি লগ সক্ষম করুন
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2; -- 2 সেকেন্ডের বেশি সময় নেওয়া কোয়েরি লগ করুন

-- বর্তমান সংযোগ পরীক্ষা করুন
SHOW PROCESSLIST;

-- মূল মেট্রিক্স মনিটর করুন
SHOW GLOBAL STATUS LIKE 'Innodb_buffer_pool_read_requests';
SHOW GLOBAL STATUS LIKE 'Innodb_buffer_pool_reads';

-- বাফার পুল হিট রেশিও গণনা করুন
SELECT 
  (1 - (Innodb_buffer_pool_reads / Innodb_buffer_pool_read_requests)) * 100 
  AS buffer_pool_hit_ratio;
```

### PostgreSQL পারফরম্যান্স মনিটরিং

```sql
-- কোয়েরি লগিং সক্ষম করুন
ALTER SYSTEM SET log_statement = 'all';
ALTER SYSTEM SET log_min_duration_statement = 2000; -- স্লো কোয়েরি লগ করুন

-- বর্তমান সংযোগ এবং কোয়েরি পরীক্ষা করুন
SELECT pid, query, state, query_start 
FROM pg_stat_activity 
WHERE state = 'active';

-- টেবিল পরিসংখ্যান মনিটর করুন
SELECT schemaname, tablename, n_tup_ins, n_tup_upd, n_tup_del
FROM pg_stat_user_tables;

-- ইনডেক্স ব্যবহার পরীক্ষা করুন
SELECT indexrelname, idx_tup_read, idx_tup_fetch
FROM pg_stat_user_indexes;
```

## ডাটাবেস কনফিগারেশন অপটিমাইজেশন

### MySQL কনফিগারেশন

```ini
# my.cnf অপটিমাইজেশন
[mysqld]
# InnoDB বাফার পুল (উপলব্ধ RAM এর 70-80% সেট করুন)
innodb_buffer_pool_size = 4G

# কোয়েরি ক্যাশ (MySQL 8.0 এ অবহেলিত)
query_cache_size = 256M
query_cache_type = 1

# সংযোগ সীমা
max_connections = 200
max_user_connections = 180

# InnoDB সেটিংস
innodb_log_file_size = 1G
innodb_flush_log_at_trx_commit = 2
innodb_file_per_table = 1
```

### PostgreSQL কনফিগারেশন

```conf
# postgresql.conf অপটিমাইজেশন
# মেমরি সেটিংস
shared_buffers = 2GB                    # মোট RAM এর 25%
effective_cache_size = 6GB              # মোট RAM এর 75%
work_mem = 32MB                         # প্রতি-অপারেশন মেমরি
maintenance_work_mem = 512MB            # রক্ষণাবেক্ষণ অপারেশনের জন্য

# চেকপয়েন্ট সেটিংস
checkpoint_completion_target = 0.9
wal_buffers = 16MB

# সংযোগ সেটিংস
max_connections = 200
```

## বড় টেবিলের জন্য পার্টিশনিং

### রেঞ্জ পার্টিশনিং

```sql
-- তারিখ অনুযায়ী MySQL পার্টিশনিং
CREATE TABLE orders (
    id INT NOT NULL,
    user_id INT,
    order_date DATE,
    amount DECIMAL(10,2),
    PRIMARY KEY (id, order_date)
)
PARTITION BY RANGE (YEAR(order_date)) (
    PARTITION p2022 VALUES LESS THAN (2023),
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION future VALUES LESS THAN MAXVALUE
);

-- PostgreSQL টেবিল পার্টিশনিং
CREATE TABLE orders (
    id SERIAL,
    user_id INT,
    order_date DATE,
    amount DECIMAL(10,2)
) PARTITION BY RANGE (order_date);

CREATE TABLE orders_2024 PARTITION OF orders
    FOR VALUES FROM ('2024-01-01') TO ('2025-01-01');
```

## ব্যাকআপ এবং রক্ষণাবেক্ষণ

### নিয়মিত রক্ষণাবেক্ষণ কাজ

```sql
-- MySQL: টেবিল অপটিমাইজ করুন
OPTIMIZE TABLE users, orders, products;

-- ভাল কোয়েরি পরিকল্পনার জন্য টেবিল বিশ্লেষণ করুন
ANALYZE TABLE users, orders, products;

-- PostgreSQL: ভ্যাকুয়াম এবং বিশ্লেষণ
VACUUM ANALYZE users;
VACUUM ANALYZE orders;

-- টেবিল পরিসংখ্যান আপডেট করুন
ANALYZE users;
ANALYZE orders;
```

### স্বয়ংক্রিয় রক্ষণাবেক্ষণ

```bash
#!/bin/bash
# MySQL রক্ষণাবেক্ষণ স্ক্রিপ্ট
mysql -u root -p$MYSQL_PASSWORD -e "
    OPTIMIZE TABLE mydb.users;
    OPTIMIZE TABLE mydb.orders;
    ANALYZE TABLE mydb.users;
    ANALYZE TABLE mydb.orders;
"

# PostgreSQL রক্ষণাবেক্ষণ স্ক্রিপ্ট
psql -d mydb -c "VACUUM ANALYZE users;"
psql -d mydb -c "VACUUM ANALYZE orders;"
psql -d mydb -c "REINDEX DATABASE mydb;"
```

## অ্যাপ্লিকেশন-লেভেল অপটিমাইজেশন

### ব্যাচ অপারেশন

```php
// খারাপ: পৃথক ইনসার্ট
foreach ($users as $user) {
    DB::table('users')->insert($user);
}

// ভাল: ব্যাচ ইনসার্ট
DB::table('users')->insert($users);

// ভাল: একাধিক অপারেশনের জন্য ট্রানজাকশন ব্যবহার করুন
DB::transaction(function () use ($users) {
    foreach ($users as $user) {
        // জটিল অপারেশন যা পারমাণবিক হতে হবে
        DB::table('users')->insert($user);
        DB::table('user_profiles')->insert($user['profile']);
    }
});
```

### লেজি লোডিং বনাম ইগার লোডিং

```php
// খারাপ: N+1 কোয়েরি সমস্যা
$users = User::all();
foreach ($users as $user) {
    echo $user->profile->bio; // প্রতিটি ব্যবহারকারীর জন্য অতিরিক্ত কোয়েরি ট্রিগার করে
}

// ভাল: ইগার লোডিং
$users = User::with('profile')->get();
foreach ($users as $user) {
    echo $user->profile->bio; // কোন অতিরিক্ত কোয়েরি নেই
}
```

## পরীক্ষা এবং বেঞ্চমার্কিং

### লোড টেস্টিং

```bash
# MySQL বেঞ্চমার্ক
sysbench oltp_read_write \
  --mysql-host=localhost \
  --mysql-user=root \
  --mysql-password=password \
  --mysql-db=testdb \
  --tables=4 \
  --table-size=1000000 \
  --threads=16 \
  --time=300 \
  run

# PostgreSQL বেঞ্চমার্ক
pgbench -i -s 50 testdb  # প্রাথমিকীকরণ
pgbench -c 10 -j 2 -t 1000 testdb  # বেঞ্চমার্ক চালান
```

## উপসংহার

ডাটাবেস অপটিমাইজেশন একটি চলমান প্রক্রিয়া যার জন্য প্রয়োজন:

1. **পারফরম্যান্স মেট্রিক্সের নিয়মিত মনিটরিং**
2. **কোয়েরি প্যাটার্নের উপর ভিত্তি করে যথাযথ ইনডেক্সিং কৌশল**
3. **দক্ষ কোয়েরি লেখা** এবং সাধারণ ভুল এড়ানো
4. **উপযুক্ত হার্ডওয়্যার রিসোর্স** এবং কনফিগারেশন
5. **ডাটাবেস লোড কমানোর জন্য ক্যাশিং কৌশল**
6. **নিয়মিত রক্ষণাবেক্ষণ** কাজ এবং আপডেট

মনে রাখবেন যে অপটিমাইজেশন আপনার নির্দিষ্ট ব্যবহারের ক্ষেত্রে, ডেটা প্যাটার্ন এবং অ্যাপ্লিকেশনের প্রয়োজনীয়তার উপর অত্যন্ত নির্ভরশীল। পরিবর্তন করার আগে এবং পরে সর্বদা পারফরম্যান্স পরিমাপ করুন, এবং রিড এবং রাইট পারফরম্যান্সের মধ্যে ট্রেড-অফ বিবেচনা করুন।

সবচেয়ে প্রভাবশালী অপটিমাইজেশন (যথাযথ ইনডেক্সিং এবং কোয়েরি অপটিমাইজেশন) দিয়ে শুরু করুন পার্টিশনিং এবং জটিল ক্যাশিং কৌশলের মতো উন্নত কৌশলে যাওয়ার আগে।
MARKDOWN;
    }

    private function getVueJsContentEn(): string
    {
        return 'Vue.js 3 content would go here...';
    }

    private function getVueJsContentBn(): string
    {
        return 'Vue.js 3 বিষয়বস্তু এখানে থাকবে...';
    }

    private function getApiDevelopmentContentEn(): string
    {
        return 'API Development content would go here...';
    }

    private function getApiDevelopmentContentBn(): string
    {
        return 'API ডেভেলপমেন্ট বিষয়বস্তু এখানে থাকবে...';
    }
}