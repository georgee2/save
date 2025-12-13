<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;
    
    protected $table = 'contact_information';
    protected $guarded = [];
    
    /**
     * Get the singleton contact information instance
     * Creates one if it doesn't exist
     */
    public static function getContactInfo()
    {
        $contactInfo = self::first();
        
        if (!$contactInfo) {
            $contactInfo = self::create([
                'email' => null,
                'mobile' => null,
                'secondary_mobile' => null,
                'whatsapp' => null,
                'facebook' => null,
                'instagram' => null,
                'linkedin' => null,
                'twitter' => null,
                'pinterest' => null,
                'location_text_english' => null,
                'location_text_arabic' => null,
                'location_map' => null,
                'footer_bio_english' => null,
                'footer_bio_arabic' => null,
                'tags' => [],
                'seo_description_english' => null,
                'seo_description_arabic' => null,
            ]);
        }
        
        return $contactInfo;
    }
    
    /**
     * Update contact information
     */
    public static function updateContactInfo(array $data)
    {
        $contactInfo = self::getContactInfo();
        $contactInfo->update($data);
        return $contactInfo;
    }
    
    /**
     * Get tags as comma-separated string (stored format)
     */
    public function getTagsStringAttribute()
    {
        return $this->tags ? $this->tags : '';
    }
}

