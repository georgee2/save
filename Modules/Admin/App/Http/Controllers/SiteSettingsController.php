<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SiteSettingsController extends Controller
{
    /**
     * Display site settings page
     */
    public function index()
    {
        // Read current status from .env file
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        
        // Check if UNDER_CONSTRUCTION exists in .env
        if (preg_match('/UNDER_CONSTRUCTION=(.*)/', $envContent, $matches)) {
            $underConstruction = trim($matches[1]) === 'true';
        } else {
            $underConstruction = false;
        }
        
        return view('admin::site-settings.index', compact('underConstruction'));
    }
    
    /**
     * Update under construction mode
     */
    public function updateUnderConstruction(Request $request)
    {
        $request->validate([
            'under_construction' => 'required|in:true,false'
        ]);
        
        $status = $request->under_construction === 'true' ? 'true' : 'false';
        
        // Update .env file
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);
        
        // Check if UNDER_CONSTRUCTION already exists
        if (preg_match('/UNDER_CONSTRUCTION=(.*)/', $envContent)) {
            // Replace existing value
            $envContent = preg_replace(
                '/UNDER_CONSTRUCTION=(.*)/',
                'UNDER_CONSTRUCTION=' . $status,
                $envContent
            );
        } else {
            // Add new line
            $envContent .= "\nUNDER_CONSTRUCTION=" . $status;
        }
        
        // Write back to .env
        file_put_contents($envPath, $envContent);
        
        // Clear config cache
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        $message = $status === 'true' 
            ? 'Under Construction mode has been enabled.' 
            : 'Under Construction mode has been disabled.';
        
        return redirect()->back()->with('success', $message);
    }
}

