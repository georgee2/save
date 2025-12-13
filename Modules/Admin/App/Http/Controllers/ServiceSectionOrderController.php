<?php

namespace Modules\Admin\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\ServiceSectionOrder;
use App\Models\Service;
use App\Models\ServiceBlock;

class ServiceSectionOrderController extends Controller
{
    /**
     * Initialize default section orders for a service
     */
    public function initializeOrders($serviceId)
    {
        $service = Service::with('blocks')->findOrFail($serviceId);
        
        // Check if orders already exist
        $existingOrders = ServiceSectionOrder::where('service_id', $serviceId)->count();
        
        if ($existingOrders > 0) {
            return redirect()->route('service.show', ['id' => $serviceId])
                ->with('info', 'Section orders already initialized for this service.');
        }
        
        // Default sections with their order
        $defaultSections = [
            ['section_type' => 'main_info', 'section_id' => null, 'order' => 1],
            ['section_type' => 'description', 'section_id' => null, 'order' => 2],
            ['section_type' => 'features', 'section_id' => null, 'order' => 3],
            ['section_type' => 'values', 'section_id' => null, 'order' => 4],
            ['section_type' => 'process', 'section_id' => null, 'order' => 5],
            ['section_type' => 'faq', 'section_id' => null, 'order' => 6],
        ];
        
        $orderCounter = 7;
        
        // Add each custom block as a separate section
        foreach ($service->blocks as $block) {
            $defaultSections[] = [
                'section_type' => 'custom_block',
                'section_id' => $block->id,
                'order' => $orderCounter++
            ];
        }
        
        // Create all section orders
        foreach ($defaultSections as $section) {
            ServiceSectionOrder::create([
                'service_id' => $serviceId,
                'section_type' => $section['section_type'],
                'section_id' => $section['section_id'],
                'order' => $section['order'],
                'is_visible' => true,
            ]);
        }
        
        return redirect()->route('service.show', ['id' => $serviceId])
            ->with('success', 'Section orders initialized successfully!');
    }
    
    /**
     * Update section orders via AJAX
     */
    public function updateOrders(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:service_section_orders,id',
            'orders.*.order' => 'required|integer',
        ]);
        
        foreach ($request->orders as $orderData) {
            ServiceSectionOrder::where('id', $orderData['id'])
                ->update(['order' => $orderData['order']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Section orders updated successfully!'
        ]);
    }
    
    /**
     * Toggle section visibility
     */
    public function toggleVisibility($id)
    {
        $sectionOrder = ServiceSectionOrder::findOrFail($id);
        $sectionOrder->is_visible = !$sectionOrder->is_visible;
        $sectionOrder->save();
        
        $status = $sectionOrder->is_visible ? 'shown' : 'hidden';
        
        return redirect()->route('service.show', ['id' => $sectionOrder->service_id])
            ->with('success', "Section {$status} successfully!");
    }
    
    /**
     * Reset orders to default
     */
    public function resetOrders($serviceId)
    {
        // Delete existing orders
        ServiceSectionOrder::where('service_id', $serviceId)->delete();
        
        // Reinitialize
        return $this->initializeOrders($serviceId);
    }
}

