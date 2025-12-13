<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseProject extends Model
{
    use HasFactory;
    
    protected $table = 'showcase_project';
    protected $guarded = [];
    
    /**
     * Get the showcase that owns the relation
     */
    public function showcase()
    {
        return $this->belongsTo(Showcase::class);
    }
    
    /**
     * Get the project that owns the relation
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

