<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Display site settings page
     */
    public function index()
    {
        // Read current status from .env file directly (not from config cache)
        $underConstruction = $this->getUnderConstructionStatus();
        
        return view('admin::site-settings.index', compact('underConstruction'));
    }
    
    /**
     * Update under construction mode
     */
    public function updateUnderConstruction(Request $request)
    {
        try {
            $request->validate([
                'under_construction' => 'required|in:true,false'
            ]);
            
            $status = $request->under_construction === 'true' ? 'true' : 'false';
            
            // Update .env file with file locking to prevent corruption
            $success = $this->setEnvValue('UNDER_CONSTRUCTION', $status);
            
            if (!$success) {
                return redirect()->back()->with('error', 'Failed to update under construction mode. Please try again.');
            }
            
            // Clear config cache file if it exists
            $this->clearConfigCache();
            
            $message = $status === 'true' 
                ? 'Under Construction mode has been enabled. The site is now in maintenance mode.' 
                : 'Under Construction mode has been disabled. The site is now live.';
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Error updating under construction mode: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    
    /**
     * Get under construction status from .env file
     */
    private function getUnderConstructionStatus(): bool
    {
        try {
            $envPath = base_path('.env');
            if (file_exists($envPath)) {
                $envContent = @file_get_contents($envPath);
                if ($envContent !== false && preg_match('/UNDER_CONSTRUCTION=(\S*)/', $envContent, $matches)) {
                    return strtolower(trim($matches[1])) === 'true';
                }
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Error reading under construction status: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Set a value in the .env file with proper file locking
     */
    private function setEnvValue(string $key, string $value): bool
    {
        try {
            $envPath = base_path('.env');
            
            // Read current content
            $envContent = @file_get_contents($envPath);
            if ($envContent === false) {
                \Log::error('Could not read .env file');
                return false;
            }
            
            // Check if key already exists
            $pattern = "/^{$key}=.*/m";
            if (preg_match($pattern, $envContent)) {
                // Replace existing value
                $envContent = preg_replace($pattern, "{$key}={$value}", $envContent);
            } else {
                // Add new line at the end
                $envContent .= "\n{$key}={$value}";
            }
            
            // Write with exclusive lock
            $result = @file_put_contents($envPath, $envContent, LOCK_EX);
            
            if ($result === false) {
                \Log::error('Could not write to .env file');
                return false;
            }
            
            // Give the file system a moment to sync
            clearstatcache(true, $envPath);
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error('Error setting env value: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Clear config cache without using Artisan (to avoid potential issues)
     */
    private function clearConfigCache(): void
    {
        try {
            // Delete cached config file if it exists
            $cachedConfigPath = base_path('bootstrap/cache/config.php');
            if (file_exists($cachedConfigPath)) {
                @unlink($cachedConfigPath);
            }
            
            // Also try to clear the general cache
            $cacheDir = storage_path('framework/cache/data');
            if (is_dir($cacheDir)) {
                $files = glob($cacheDir . '/*');
                if (is_array($files)) {
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            @unlink($file);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently fail - cache will be refreshed on next request anyway
            \Log::warning('Failed to clear cache: ' . $e->getMessage());
        }
    }
}

