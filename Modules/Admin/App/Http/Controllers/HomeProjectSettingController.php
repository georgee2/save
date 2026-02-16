<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\HomeProjectSetting;
use App\Models\HomeProjectItem;
use App\Models\EngineeringCategory;
use App\Models\Project;

class HomeProjectSettingController extends Controller
{
    /**
     * Display the home projects section settings
     */
    public function index()
    {
        // Initialize settings for any new categories
        HomeProjectSetting::initializeForAllCategories();
        
        // Get all settings with categories and project counts
        $settings = HomeProjectSetting::with(['category' => function($query) {
                $query->withCount(['projects' => function($q) {
                    $q->where('publish_status', 0)->whereNull('deleted_at');
                }]);
            }, 'selectedProjects.project'])
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
        
        return view('admin::home-project-settings.index', compact('settings'));
    }

    /**
     * Show the project selection page for a category
     */
    public function selectProjects($id)
    {
        $setting = HomeProjectSetting::with(['category', 'selectedProjects.project'])
            ->findOrFail($id);
        
        // Get all published projects for this category
        $availableProjects = Project::where('category_id', $setting->category_id)
            ->where('publish_status', 0)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get selected project IDs
        $selectedProjectIds = $setting->selectedProjects->pluck('project_id')->toArray();
        
        return view('admin::home-project-settings.select-projects', compact('setting', 'availableProjects', 'selectedProjectIds'));
    }

    /**
     * Save selected projects for a category
     */
    public function saveProjects(Request $request, $id)
    {
        $setting = HomeProjectSetting::findOrFail($id);
        
        $projectIds = $request->input('projects', []);
        
        // Delete existing selections
        HomeProjectItem::where('home_project_setting_id', $id)->delete();
        
        // Add new selections
        foreach ($projectIds as $index => $projectId) {
            HomeProjectItem::create([
                'home_project_setting_id' => $id,
                'project_id' => $projectId,
                'ordering' => $index + 1,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Projects saved successfully!',
            'count' => count($projectIds),
        ]);
    }

    /**
     * Clear selected projects for a category (use auto mode)
     */
    public function clearProjects($id)
    {
        HomeProjectItem::where('home_project_setting_id', $id)->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Switched to automatic mode (latest projects).',
        ]);
    }

    /**
     * Update settings via AJAX
     */
    public function update(Request $request, $id)
    {
        $setting = HomeProjectSetting::findOrFail($id);
        
        $data = $request->validate([
            'max_projects' => 'required|integer|min:1|max:50',
            'is_active' => 'required|boolean',
        ]);
        
        $setting->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully!',
        ]);
    }

    /**
     * Update ordering via AJAX
     */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        
        foreach ($orders as $order) {
            HomeProjectSetting::where('id', $order['id'])
                ->update(['ordering' => $order['ordering']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully!',
        ]);
    }

    /**
     * Toggle active status via AJAX
     */
    public function toggleStatus($id)
    {
        $setting = HomeProjectSetting::findOrFail($id);
        $setting->is_active = !$setting->is_active;
        $setting->save();
        
        return response()->json([
            'success' => true,
            'is_active' => $setting->is_active,
            'message' => $setting->is_active ? 'Category enabled on home!' : 'Category disabled on home!',
        ]);
    }

    /**
     * Bulk update all settings
     */
    public function bulkUpdate(Request $request)
    {
        $settings = $request->input('settings', []);
        
        foreach ($settings as $settingData) {
            if (isset($settingData['id'])) {
                HomeProjectSetting::where('id', $settingData['id'])
                    ->update([
                        'max_projects' => $settingData['max_projects'] ?? 9,
                        'is_active' => $settingData['is_active'] ?? true,
                        'ordering' => $settingData['ordering'] ?? 0,
                    ]);
            }
        }
        
        return redirect()->route('home-project-settings.index')
            ->with('success', 'All settings updated successfully!');
    }

    /**
     * Reset all settings to default
     */
    public function resetToDefault()
    {
        HomeProjectSetting::whereNull('deleted_at')
            ->update([
                'max_projects' => 9,
                'is_active' => true,
            ]);
        
        // Clear all selected projects
        HomeProjectItem::truncate();
        
        // Reset ordering based on category name
        $settings = HomeProjectSetting::with('category')
            ->whereNull('deleted_at')
            ->get()
            ->sortBy(function($setting) {
                return $setting->category->title_english ?? '';
            })
            ->values();
        
        foreach ($settings as $index => $setting) {
            $setting->update(['ordering' => $index + 1]);
        }
        
        return redirect()->route('home-project-settings.index')
            ->with('success', 'All settings reset to default!');
    }
}
