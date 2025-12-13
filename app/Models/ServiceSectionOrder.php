<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSectionOrder extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    protected $casts = [
        'is_visible' => 'boolean',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function block()
    {
        return $this->belongsTo(ServiceBlock::class, 'section_id');
    }
    
    /**
     * Get section display name
     */
    public function getSectionNameAttribute()
    {
        $names = [
            'features' => 'Features Section',
            'main_info' => 'Main Information',
            'description' => 'Description & Bio',
            'values' => 'Values Section',
            'process' => 'Process Section',
            'faq' => 'FAQ Section',
            'custom_block' => 'Custom Block',
        ];
        
        return $names[$this->section_type] ?? $this->section_type;
    }
}
