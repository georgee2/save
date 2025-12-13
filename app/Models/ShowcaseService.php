<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseService extends Model
{
    use HasFactory;
    
    protected $table = 'showcase_service';
    protected $guarded = [];
    
    /**
     * Get the showcase that owns the relation
     */
    public function showcase()
    {
        return $this->belongsTo(Showcase::class);
    }
    
    /**
     * Get the service that owns the relation
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

