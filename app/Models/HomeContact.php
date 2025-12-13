<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContact extends Model
{
    use HasFactory;
    
    protected $table = 'home_contact';
    protected $guarded = [];
    
    /**
     * Get the single home contact record
     */
    public static function getSingle()
    {
        return self::first();
    }
    
    /**
     * Create or update the single record
     */
    public static function updateOrCreateSingle(array $data)
    {
        $record = self::first();
        
        if ($record) {
            $record->update($data);
            return $record;
        }
        
        return self::create($data);
    }
}

