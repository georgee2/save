# Memory Optimization Guide for SmartVision

## Problem
**Error:** `Allowed memory size of 134217728 bytes exhausted (tried to allocate 28672 bytes)`

This means your PHP memory limit (128MB) has been reached.

---

## ✅ IMMEDIATE FIXES (Already Applied)

### 1. Application-Level Memory Increase
**File:** `public/index.php`
- Added `ini_set('memory_limit', '512M');` at the top
- This increases memory limit for web requests to 512MB

---

## 🔧 RECOMMENDED FIXES (Do These Next)

### 2. PHP Configuration (WAMP)

**Location:** `C:\wamp64\bin\php\php8.2.26\php.ini`

**Steps:**
1. Open WAMP Tray Icon → PHP → php.ini
2. Search for `memory_limit`
3. Change: `memory_limit = 128M` → `memory_limit = 512M`
4. Save and restart WAMP

**For CLI scripts (Artisan commands):**
Also check: `C:\wamp64\bin\php\php8.2.26\php.ini-development`

### 3. Apache Configuration (Optional)

**File:** `C:\wamp64\bin\apache\apache2.x.x\bin\php.ini`

If you have a separate Apache PHP configuration, update it too.

---

## 🚀 PERFORMANCE OPTIMIZATIONS

### 4. Database Query Optimization

**Problem Areas Identified:**

#### A. News Model - `blogs()` method
**File:** `app/Models/News.php` (Line 137-157)

**Issue:** Loads ALL news without pagination
```php
// Current - loads everything
public function blogs()
{
    $news = DB::select('SELECT * FROM news ...');
    return $news;
}
```

**Fix:** Add pagination
```php
public function blogs($perPage = 15)
{
    return DB::table('news')
        ->join('newscategories', 'newscategories.id', '=', 'news.category_code')
        ->select(
            'news.id',
            'news.title_english',
            'news.title_arabic',
            'news.bio_english',
            'news.bio_arabic',
            'news.image',
            'newscategories.name_english AS caten',
            'newscategories.name_arabic AS catar',
            'news.category_code',
            'news.created_at',
            'news.slug'
        )
        ->orderBy('news.created_at', 'DESC')
        ->paginate($perPage);
}
```

#### B. Service Model - Multiple Methods
**File:** `app/Models/Service.php`

**Methods to optimize:**
- `getservices()` - loads all services
- `serviceshome()` - should limit to featured only
- `getMainServices()` - might be okay if limited

**Add LIMIT clauses:**
```sql
-- For homepage services
LIMIT 6

-- For service listings
LIMIT 50
```

### 5. Eager Loading for Relationships

**Problem:** N+1 query issues

**Example Fix in Controllers:**
```php
// Bad - causes N+1 queries
$projects = Project::all();
foreach ($projects as $project) {
    echo $project->category->name; // Extra query per project
}

// Good - eager loading
$projects = Project::with(['category', 'type', 'style'])->get();
```

### 6. Chunk Large Datasets

**For processing large datasets:**
```php
// Instead of
$projects = Project::all(); // Loads everything into memory

// Use chunking
Project::chunk(100, function ($projects) {
    foreach ($projects as $project) {
        // Process project
    }
});
```

### 7. Select Only Needed Columns

**Current pattern in many models:**
```php
DB::table('projects')->get(); // Gets ALL columns
```

**Better:**
```php
DB::table('projects')
    ->select('id', 'title_english', 'title_arabic', 'status')
    ->get();
```

---

## 📊 MONITORING & DEBUGGING

### Check Memory Usage in Controllers

Add this to problematic controllers:
```php
public function index()
{
    $startMemory = memory_get_usage();
    
    // Your code here
    $data = Model::list();
    
    $endMemory = memory_get_usage();
    \Log::info('Memory used: ' . (($endMemory - $startMemory) / 1024 / 1024) . ' MB');
    
    return view('...', compact('data'));
}
```

### Laravel Debugbar (Recommended)

Install for development:
```bash
composer require barryvdh/laravel-debugbar --dev
```

This shows:
- Memory usage per request
- Query count and execution time
- N+1 query detection

---

## 🎯 SPECIFIC FIXES NEEDED

### Priority 1: High Memory Consumers

1. **Feasibility Study Calculations**
   - File: `Modules/Admin/App/Http/Controllers/FeasibilityStudyController.php`
   - Method: `calculateStudy()` - likely loads lots of related data
   - **Fix:** Optimize calculations, use chunking

2. **Project Show Pages**
   - Loads projects with all relationships
   - **Fix:** Lazy load relationships only when needed

3. **Image Processing**
   - Intervention Image can use lots of memory
   - **Fix:** Process images in queue jobs

### Priority 2: Query Optimization

Files to update:
- `app/Models/News.php` - Add pagination to `blogs()`
- `app/Models/Service.php` - Add limits to listing methods
- `app/Models/Project.php` - Already optimized (good!)

---

## 🔍 FIND MEMORY LEAKS

### Artisan Command to Test

Create: `app/Console/Commands/TestMemory.php`
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;

class TestMemory extends Command
{
    protected $signature = 'test:memory';
    protected $description = 'Test memory usage of models';

    public function handle()
    {
        $this->info('Starting memory: ' . $this->formatBytes(memory_get_usage()));
        
        // Test each model
        $projects = Project::all();
        $this->info('After loading projects: ' . $this->formatBytes(memory_get_usage()));
        
        unset($projects);
        gc_collect_cycles();
        
        $this->info('After cleanup: ' . $this->formatBytes(memory_get_usage()));
    }
    
    private function formatBytes($bytes)
    {
        return round($bytes / 1024 / 1024, 2) . ' MB';
    }
}
```

Run: `php artisan test:memory`

---

## ⚡ QUICK WINS

### 1. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2. Optimize Composer Autoloader
```bash
composer dump-autoload --optimize
```

### 3. Enable OPcache

In `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
```

---

## 📝 ENVIRONMENT VARIABLES

Add to `.env`:
```env
# Memory Settings
PAGINATION_PER_PAGE=50
ADMIN_PAGINATION_PER_PAGE=25

# Image Processing
IMAGE_MAX_WIDTH=1920
IMAGE_MAX_HEIGHT=1080
IMAGE_QUALITY=85
```

---

## 🚨 WHEN TO INCREASE MEMORY

**Good Reasons:**
- Processing large images (already doing this)
- Complex calculations (feasibility studies)
- Temporary spike during imports

**Bad Reasons:**
- Loading all records without pagination
- N+1 query problems
- Memory leaks in code

**Rule of Thumb:**
- Development: 512MB is fine
- Production: 256MB-512MB (with optimizations)
- If you need > 1GB regularly, there's a code problem

---

## ✅ CHECKLIST

- [x] Increased memory in `public/index.php` to 512M
- [ ] Update `php.ini` memory_limit to 512M
- [ ] Restart WAMP services
- [ ] Add pagination to News::blogs()
- [ ] Add pagination to Service listing methods
- [ ] Test memory usage with debugbar
- [ ] Optimize image processing
- [ ] Review feasibility study calculations
- [ ] Clear all caches
- [ ] Monitor production logs

---

## 📞 NEED MORE HELP?

If memory issues persist after these fixes:

1. **Check logs:** `storage/logs/laravel.log`
2. **Profile the request:** Use Laravel Debugbar
3. **Identify the exact query/operation** causing the issue
4. **Consider using queues** for heavy operations

---

## 🎓 BEST PRACTICES GOING FORWARD

1. **Always paginate** listings in controllers
2. **Use eager loading** for relationships
3. **Select only needed columns** in queries
4. **Process large datasets** in chunks
5. **Move heavy operations** to queue jobs
6. **Monitor memory usage** in development
7. **Test with production-like data** volumes

---

**Last Updated:** November 2, 2025
**Applied Fixes:** Memory limit increased to 512M in public/index.php

