<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\PageBanner;

class ServiceController extends Controller
{
    public function index()
    {
        // Get all main services (is_sub_service = 0) that are published
        // SoftDeletes handles deleted_at automatically
        $mainServices = Service::where('is_sub_service', 0)
                              ->where('publish_status', 0)
                              ->with(['subServices' => function($query) {
                                  $query->where('publish_status', 0)
                                        ->orderBy('created_at', 'asc');
                              }])
                              ->orderBy('created_at', 'asc')
                              ->get();
        
        // Get page banner for services page
        $pageBanner = PageBanner::getByTarget('services');
        
        return view('pages.services.index', compact('mainServices', 'pageBanner'));
    }
    
    public function show($slug)
    {
        // Get service by slug with all related data
        $service = Service::where('slug', $slug)
                         ->where('publish_status', 0)
                         ->whereNull('deleted_at')
                         ->with([
                             'features', 
                             'values', 
                             'processes', 
                             'blocks', 
                             'faqs', 
                             'sectionOrders.block', 
                             'subServices' => function($query) {
                                 $query->where('publish_status', 0)
                                       ->orderBy('created_at', 'asc');
                             }, 
                             'parentService'
                         ])
                         ->firstOrFail();
        
        // Get section titles
        $titles = [
            'features' => \App\Models\ServiceTitle::getByTarget('features'),
            'values' => \App\Models\ServiceTitle::getByTarget('values'),
            'processes' => \App\Models\ServiceTitle::getByTarget('processes'),
            'faqs' => \App\Models\ServiceTitle::getByTarget('faqs'),
            'sub_services' => \App\Models\ServiceTitle::getByTarget('sub_services'),
        ];
        
        return view('pages.services.service', compact('service', 'titles'));
    }
}
