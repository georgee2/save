<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeProjectSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'max_projects',
        'ordering',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the category for this setting
     */
    public function category()
    {
        return $this->belongsTo(EngineeringCategory::class, 'category_id');
    }

    /**
     * Get the selected projects for this setting
     */
    public function selectedProjects()
    {
        return $this->hasMany(HomeProjectItem::class, 'home_project_setting_id')
            ->orderBy('ordering', 'asc');
    }

    /**
     * Get active settings ordered by ordering
     */
    public static function getActiveSettings()
    {
        return self::with('category')
            ->where('is_active', true)
            ->whereNull('deleted_at')
            ->whereHas('category', function($query) {
                $query->whereNull('deleted_at');
            })
            ->orderBy('ordering', 'asc')
            ->get();
    }

    /**
     * Get all settings with categories
     */
    public static function getAllWithCategories()
    {
        return self::with('category')
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
    }

    /**
     * Initialize settings for all categories that don't have settings yet
     */
    public static function initializeForAllCategories()
    {
        $categories = EngineeringCategory::whereNull('deleted_at')
            ->whereDoesntHave('homeProjectSetting')
            ->get();

        $maxOrder = self::max('ordering') ?? 0;

        foreach ($categories as $index => $category) {
            self::create([
                'category_id' => $category->id,
                'max_projects' => 9,
                'ordering' => $maxOrder + $index + 1,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Check if this setting has manually selected projects
     */
    public function hasSelectedProjects()
    {
        return $this->selectedProjects()->count() > 0;
    }

    /**
     * Get projects for home display - either selected or auto (latest)
     */
    public function getProjectsForHome()
    {
        // If there are manually selected projects, use them
        if ($this->hasSelectedProjects()) {
            return $this->selectedProjects()
                ->with(['project' => function($query) {
                    $query->where('publish_status', 0)
                          ->whereNull('deleted_at')
                          ->with(['category', 'subcategory', 'specifications.specification'])
                          ->withCount('images');
                }])
                ->get()
                ->pluck('project')
                ->filter() // Remove null projects (deleted or unpublished)
                ->take($this->max_projects);
        }

        // Otherwise, get latest projects from the category
        return Project::where('category_id', $this->category_id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->with(['category', 'subcategory', 'specifications.specification'])
            ->withCount('images')
            ->orderBy('created_at', 'desc')
            ->limit($this->max_projects)
            ->get();
    }
}
