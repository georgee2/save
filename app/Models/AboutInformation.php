<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class AboutInformation extends Model
{
    use HasFactory, LogsActivity;
    
    protected $logTitleField = 'title_english';
    
    protected $table = 'about_information';
    protected $guarded = [];
    
    /**
     * Get the singleton about information instance
     * Creates one if it doesn't exist
     */
    public static function getAboutInfo()
    {
        $aboutInfo = self::first();
        
        if (!$aboutInfo) {
            $aboutInfo = self::create([
                'title_english' => null,
                'title_arabic' => null,
                'subtitle_english' => null,
                'subtitle_arabic' => null,
                'about_english' => null,
                'about_arabic' => null,
                'about_image' => null,
                'mission_english' => null,
                'mission_arabic' => null,
                'mission_image' => null,
                'vision_english' => null,
                'vision_arabic' => null,
                'vision_image' => null,
                'values_english' => null,
                'values_arabic' => null,
                'values_points_english' => null,
                'values_points_arabic' => null,
                'values_image' => null,
                'page_cover_image' => null,
                'company_profile' => null,
            ]);
        }
        
        return $aboutInfo;
    }
    
    /**
     * Update about information
     */
    public static function updateAboutInfo(array $data)
    {
        $aboutInfo = self::getAboutInfo();
        $aboutInfo->update($data);
        return $aboutInfo;
    }
}

