<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPageSection extends Model
{
    use HasFactory;

    protected $table = 'contact_page_sections';
    
    protected $fillable = [
        'section_key',
        'title_english',
        'title_arabic',
        'description',
        'icon',
        'blade_partial',
        'ordering',
        'status',
    ];

    /**
     * Get all active sections ordered by ordering field
     */
    public static function getActiveSections()
    {
        return self::where('status', 0)
            ->orderBy('ordering', 'asc')
            ->get();
    }

    /**
     * Get all sections for admin
     */
    public static function getAllSections()
    {
        return self::orderBy('ordering', 'asc')->get();
    }

    /**
     * Check if a section is active
     */
    public function isActive()
    {
        return $this->status == 0;
    }

    /**
     * Get section by key
     */
    public static function getByKey($key)
    {
        return self::where('section_key', $key)->first();
    }

    /**
     * Check if a specific section is active by key
     */
    public static function isSectionActive($key)
    {
        $section = self::getByKey($key);
        return $section && $section->status == 0;
    }
}
