<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowcaseNew extends Model
{
    use HasFactory;
    
    protected $table = 'showcase_new';
    protected $guarded = [];
    
    /**
     * Get the showcase that owns the relation
     */
    public function showcase()
    {
        return $this->belongsTo(Showcase::class);
    }
    
    /**
     * Get the news item that owns the relation
     */
    public function news()
    {
        return $this->belongsTo(News::class, 'new_id');
    }
}

